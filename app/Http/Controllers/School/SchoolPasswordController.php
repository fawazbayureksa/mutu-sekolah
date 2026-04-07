<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SchoolPasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('school.auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password'             => Hash::make($request->input('password')),
            'must_change_password' => false,
        ]);

        return redirect()->route('school.dashboard')
            ->with('success', 'Password berhasil dibuat. Selamat datang!');
    }
}
