<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DatabaseBackupController extends Controller
{
    /**
     * Path to the backup shell script on the server.
     */
    private function scriptPath(): string
    {
        return env('BACKUP_SCRIPT_PATH', '/root/backup-mysql.sh');
    }

    /**
     * Directory where backup files are stored on the server.
     */
    private function storagePath(): string
    {
        return rtrim(env('BACKUP_STORAGE_PATH', '/var/backup/mysql'), '/');
    }

    /**
     * List all available backup files (JSON for AJAX).
     */
    public function index(): JsonResponse
    {
        $dir = $this->storagePath();

        if (! is_dir($dir)) {
            return response()->json([
                'success' => false,
                'message' => 'Direktori backup tidak ditemukan: ' . $dir,
                'files'   => [],
            ]);
        }

        $files = collect(scandir($dir))
            ->filter(fn($f) => ! in_array($f, ['.', '..']) && is_file($dir . '/' . $f))
            ->map(function ($filename) use ($dir) {
                $fullPath = $dir . '/' . $filename;
                return [
                    'name'         => $filename,
                    'size'         => filesize($fullPath),
                    'size_human'   => $this->humanFileSize(filesize($fullPath)),
                    'modified'     => filemtime($fullPath),
                    'modified_str' => date('d M Y, H:i', filemtime($fullPath)),
                ];
            })
            ->sortByDesc('modified')
            ->values();

        return response()->json([
            'success' => true,
            'files'   => $files,
        ]);
    }

    /**
     * Trigger the backup script in the background.
     * Requires password confirmation for safety.
     */
    public function trigger(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        // Re-confirm the admin's password before running the script
        if (! Hash::check($request->password, auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah. Backup dibatalkan.',
            ], 401);
        }

        $script = $this->scriptPath();

        if (! file_exists($script)) {
            return response()->json([
                'success' => false,
                'message' => 'Script backup tidak ditemukan di: ' . $script,
            ], 500);
        }

        if (! is_executable($script)) {
            return response()->json([
                'success' => false,
                'message' => 'Script backup tidak memiliki permission execute.',
            ], 500);
        }

        // Run the backup script in background (non-blocking)
        // stdout & stderr discarded, nohup prevents kill on session end
        $safeScript = escapeshellarg($script);
        $cmd = "nohup {$safeScript} > /dev/null 2>&1 &";
        exec($cmd, $output, $exitCode);

        Log::info('[DatabaseBackup] Backup triggered by admin', [
            'user_id' => auth()->id(),
            'user'    => auth()->user()->email ?? auth()->user()->name,
            'ip'      => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Backup sedang berjalan di background. Refresh daftar file dalam beberapa menit.',
        ]);
    }

    /**
     * Stream a backup file to the browser as a download.
     */
    public function download(Request $request, string $filename): BinaryFileResponse
    {
        // Whitelist: only allow safe filenames (alphanumeric, dash, underscore, dot)
        if (! preg_match('/^[\w\-\.]+$/', $filename)) {
            abort(400, 'Nama file tidak valid.');
        }

        $dir        = $this->storagePath();
        $targetPath = realpath($dir . '/' . $filename);

        // Ensure realpath resolves within the backup directory (prevent path traversal)
        $realDir = realpath($dir);
        if ($targetPath === false || $realDir === false || ! str_starts_with($targetPath, $realDir . DIRECTORY_SEPARATOR)) {
            abort(403, 'Akses file ditolak.');
        }

        if (! is_file($targetPath)) {
            abort(404, 'File backup tidak ditemukan.');
        }

        Log::info('[DatabaseBackup] File downloaded by admin', [
            'user_id'  => auth()->id(),
            'user'     => auth()->user()->email ?? auth()->user()->name,
            'filename' => $filename,
            'ip'       => $request->ip(),
        ]);

        // Explicit MIME map — mime_content_type() often misdetects .sql.gz
        $ext     = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $mimeMap = [
            'gz'  => 'application/gzip',
            'zip' => 'application/zip',
            'sql' => 'application/octet-stream',
        ];
        $mimeType = $mimeMap[$ext] ?? 'application/octet-stream';

        // BinaryFileResponse streams the file directly to the client, handling
        // Content-Length and range requests automatically — no buffering issues.
        return response()->download($targetPath, $filename, [
            'Content-Type'           => $mimeType,
            'Cache-Control'          => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'                 => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Format bytes into human-readable size.
     */
    private function humanFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i     = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
