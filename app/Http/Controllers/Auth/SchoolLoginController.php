<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SchoolLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('school.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'npsn'     => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'string'],
        ]);

        $npsn = $request->input('npsn');

        $existingUser = User::where('npsn', $npsn)->where('role', 'school')->first();

        // --- Existing account: require and check password ---
        if ($existingUser) {
            if (! $request->filled('password')) {
                throw ValidationException::withMessages([
                    'password' => 'Masukkan password untuk akun yang sudah terdaftar.',
                ]);
            }

            if (Auth::attempt(['npsn' => $npsn, 'password' => $request->input('password')])) {
                $request->session()->regenerate();

                Auth::user()->update(['last_login_at' => now()]);

                if (Auth::user()->must_change_password) {
                    return redirect()->route('school.password.change');
                }

                return redirect()->route('school.dashboard');
            }

            throw ValidationException::withMessages([
                'password' => 'Password yang Anda masukkan salah.',
            ]);
        }

        // --- New NPSN: auto-register, link or create school, force password change ---
        DB::transaction(function () use ($npsn) {
            $school = School::where('npsn', $npsn)->first();

            $user = User::create([
                'name'                 => $school ? $school->school_name : 'Sekolah ' . $npsn,
                'npsn'                 => $npsn,
                'password'             => Hash::make(Str::random(32)),
                'role'                 => 'school',
                'is_active'            => true,
                'must_change_password' => true,
                'last_login_at'        => now(),
            ]);

            if ($school) {
                if (! $school->user_id) {
                    $school->update(['user_id' => $user->id]);
                }
            } else {
                // No pre-existing school record — create a placeholder so the dashboard works
                School::create([
                    'user_id'     => $user->id,
                    'school_name' => 'Sekolah ' . $npsn,
                    'npsn'        => $npsn,
                    'address'     => '',
                ]);
            }

            Auth::login($user);
        });

        $request->session()->regenerate();

        return redirect()->route('school.password.change');
    }

    public function showRegisterForm()
    {
        return view('school.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'npsn'        => ['required', 'regex:/^\d{8}$/', 'unique:users,npsn'],
            'school_name' => ['required', 'string', 'max:255'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'npsn.unique' => 'NPSN ini sudah terdaftar. Silakan masuk menggunakan password Anda.',
            'npsn.regex'  => 'NPSN harus terdiri dari 8 digit angka.',
        ]);

        $user = DB::transaction(function () use ($request) {
            $npsn       = $request->input('npsn');
            $schoolName = $request->input('school_name');

            $user = User::create([
                'name'                 => $schoolName,
                'npsn'                 => $npsn,
                'password'             => Hash::make($request->input('password')),
                'role'                 => 'school',
                'is_active'            => true,
                'must_change_password' => false,
                'last_login_at'        => null,
            ]);

            // Link to an existing school record or create a new one
            $school = School::where('npsn', $npsn)->first();

            if ($school) {
                if (! $school->user_id) {
                    $school->update(['user_id' => $user->id]);
                } else {
                    // School already linked to a different user (edge case: admin-seeded data)
                    // — create a dedicated record for this new user.
                    School::create([
                        'user_id'     => $user->id,
                        'school_name' => $schoolName,
                        'npsn'        => $npsn,
                        'address'     => '',
                    ]);
                }
            } else {
                School::create([
                    'user_id'     => $user->id,
                    'school_name' => $schoolName,
                    'npsn'        => $npsn,
                    'address'     => '',
                ]);
            }

            return $user;
        });

        Auth::login($user);

        return redirect()->route('school.dashboard')
            ->with('success', 'Selamat datang! Akun Anda berhasil didaftarkan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('school.login');
    }
}
