<?php

namespace App\Console\Commands;

use App\Models\DashboardRekapitulasi;
use App\Models\DashboardSectionSnapshot;
use App\Models\InstrumentSubmissionV2;
use App\Services\Dashboard\DashboardProjectionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class DashboardProjectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:project 
                            {--id= : Proyeksikan submission ID tertentu}
                            {--fresh : Bersihkan data proyeksi lama sebelum kalkulasi ulang}
                            {--force : Paksa kalkulasi ulang seluruh snapshot}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kalkulasi kernel projection layer (Rekapitulasi & Section Snapshots) dari data instrumen tanpa duplikasi';

    /**
     * Execute the console command.
     */
    public function handle(DashboardProjectionService $service): int
    {
        @ini_set('memory_limit', '512M');

        $id = $this->option('id');
        $isFresh = $this->option('fresh');

        if ($isFresh && !$id) {
            $this->warn('Membersihkan tabel proyeksi lama (dashboard_rekapitulasis & dashboard_section_snapshots)...');
            if (Schema::hasTable('dashboard_section_snapshots')) {
                DashboardSectionSnapshot::truncate();
            }
            if (Schema::hasTable('dashboard_rekapitulasis')) {
                DashboardRekapitulasi::truncate();
            }
            $this->info('Tabel proyeksi berhasil dibersihkan.');
        }

        if ($id) {
            $this->info("Memproses proyeksi kalkulasi untuk Submission ID: {$id}...");
            $submission = InstrumentSubmissionV2::find($id);

            if (!$submission) {
                $this->error("Submission ID {$id} tidak ditemukan.");
                return Command::FAILURE;
            }

            $rekap = $service->projectSubmission($submission, 'command');
            if ($rekap) {
                $this->info("Sukses memproyeksikan submission ID {$id}. Data tersimpan (idempotent/tanpa duplikasi).");
                return Command::SUCCESS;
            } else {
                $this->error("Gagal memproyeksikan submission ID {$id}.");
                return Command::FAILURE;
            }
        }

        $totalSubmissions = InstrumentSubmissionV2::count();
        $this->info("Memulai kernel projection untuk {$totalSubmissions} submission instrumen...");
        
        $count = $service->projectAll('command');

        $totalRekap = Schema::hasTable('dashboard_rekapitulasis') ? DashboardRekapitulasi::count() : 0;
        $totalSnapshots = Schema::hasTable('dashboard_section_snapshots') ? DashboardSectionSnapshot::count() : 0;

        $this->newLine();
        $this->info("=== HASIL PROYEKSI KERNEL DASHBOARD ===");
        $this->line("• Total Submission Diproses     : {$count}");
        $this->line("• Total Baris Rekapitulasi      : {$totalRekap} (1 baris per submission)");
        $this->line("• Total Section Snapshots       : {$totalSnapshots}");
        $this->info("Proses selesai secara aman! Perintah dapat dijalankan berulang kali tanpa risiko duplikasi data.");

        return Command::SUCCESS;
    }
}
