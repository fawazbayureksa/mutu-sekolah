<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SchoolPasswordController extends Controller
{
    public function showChangeForm()
    {
        $provinces = Province::orderBy('name')->get();
        $school    = Auth::user()->school;

        return view('school.auth.change-password', compact('provinces', 'school'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
            'school_name'      => ['required', 'string', 'max:255'],
            'address'          => ['required', 'string', 'max:1000'],
            'province_code'    => ['required', 'exists:provinces,code'],
            'regency_code'     => ['required', 'exists:regencies,code'],
            'school_status'    => ['nullable', 'in:Negeri,Swasta'],
            'program_duration' => ['nullable', 'in:3 Tahun,4 Tahun'],
            'school_category'  => ['nullable', 'in:SMK PK,SMK Non PK,SMK Model'],
            'school_accreditation' => ['nullable', 'in:A,B,C,Belum Terakreditasi'],
            'curriculum'       => ['nullable', 'in:K13,Kurikulum Merdeka'],
        ]);

        $user = Auth::user();

        $user->update([
            'password'             => Hash::make($request->input('password')),
            'must_change_password' => false,
        ]);

        $schoolData = $request->only([
            'school_name',
            'address',
            'province_code',
            'regency_code',
            'school_status',
            'program_duration',
            'school_category',
            'school_accreditation',
            'curriculum',
        ]);

        $school = $user->school;

        if ($school) {
            $school->update($schoolData);
        } else {
            School::updateOrCreate(
                ['npsn' => $user->npsn],
                array_merge($schoolData, ['user_id' => $user->id, 'npsn' => $user->npsn])
            );
        }

        return redirect()->route('school.dashboard')
            ->with('success', 'Password berhasil dibuat. Selamat datang!');
    }
}
