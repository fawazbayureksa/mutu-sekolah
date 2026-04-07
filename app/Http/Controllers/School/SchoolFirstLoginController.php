<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SchoolFirstLoginController extends Controller
{
    public function show(Request $request)
    {
        $npsn = $request->session()->get('school_first_login_npsn');

        if (! $npsn) {
            return redirect()->route('school.login')
                ->withErrors(['npsn' => 'Sesi tidak valid. Silakan masukkan NPSN kembali.']);
        }

        // Confirm school still has no user (may have been activated in another tab)
        $school = School::where('npsn', $npsn)->first();

        if (! $school) {
            $request->session()->forget('school_first_login_npsn');
            return redirect()->route('school.login')
                ->withErrors(['npsn' => 'NPSN tidak ditemukan.']);
        }

        if ($school->user_id) {
            $request->session()->forget('school_first_login_npsn');
            return redirect()->route('school.login')
                ->with('info', 'Akun sudah terdaftar. Silakan masuk dengan password Anda.');
        }

        return view('school.auth.first-login', ['npsn' => $npsn, 'school' => $school]);
    }

    public function store(Request $request)
    {
        $npsn = $request->session()->get('school_first_login_npsn');

        if (! $npsn) {
            return redirect()->route('school.login')
                ->withErrors(['npsn' => 'Sesi tidak valid. Silakan masukkan NPSN kembali.']);
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $school = School::where('npsn', $npsn)->first();

        if (! $school) {
            $request->session()->forget('school_first_login_npsn');
            return redirect()->route('school.login')
                ->withErrors(['npsn' => 'NPSN tidak ditemukan.']);
        }

        // Race-condition guard: another request may have created the user
        if ($school->user_id) {
            $request->session()->forget('school_first_login_npsn');
            return redirect()->route('school.login')
                ->with('info', 'Akun sudah terdaftar. Silakan masuk dengan password Anda.');
        }

        DB::transaction(function () use ($request, $school, $npsn) {
            $user = User::create([
                'name'      => $school->school_name,
                'npsn'      => $npsn,
                'email'     => null,
                'password'  => Hash::make($request->input('password')),
                'role'      => 'school',
                'is_active' => true,
                'last_login_at' => now(),
            ]);

            $school->update(['user_id' => $user->id]);

            Auth::login($user);
        });

        $request->session()->forget('school_first_login_npsn');
        $request->session()->regenerate();

        return redirect()->route('school.dashboard')
            ->with('success', 'Akun berhasil dibuat. Selamat datang!');
    }
}
