<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolController extends Controller
{
    public function index(Request $request): View
    {
        $query = School::query();

        if ($request->filled('search')) {
            $query->where('school_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('npsn')) {
            $query->where('npsn', 'like', '%' . $request->npsn . '%');
        }

        if ($request->filled('address')) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }

        $schools = $query->latest()->paginate(15);

        return view('admin.schools.index', compact('schools'));
    }

    public function create(): View
    {
        return view('admin.schools.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'npsn' => 'required|string|max:20|unique:schools,npsn',
            'address' => 'required|string',
        ]);

        School::create($validated);

        return redirect()
            ->route('admin.schools.index')
            ->with('success', 'Sekolah berhasil ditambahkan');
    }

    public function show(School $school): View
    {
        $school->load(['province', 'regency', 'instrumentSubmissionsV2']);

        return view('admin.schools.show', compact('school'));
    }

    public function edit(School $school): View
    {
        return view('admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school): RedirectResponse
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'npsn' => 'required|string|max:20|unique:schools,npsn,' . $school->id,
            'address' => 'required|string',
        ]);

        $school->update($validated);

        return redirect()
            ->route('admin.schools.show', $school)
            ->with('success', 'Data sekolah berhasil diperbarui');
    }

    public function destroy(School $school): RedirectResponse
    {
        $school->delete();

        return redirect()
            ->route('admin.schools.index')
            ->with('success', 'Sekolah berhasil dihapus');
    }

    public function assessments(School $school): View
    {
        $assessments = $school->assessments()->with('instrument')->latest()->paginate(15);

        return view('admin.schools.assessments', compact('school', 'assessments'));
    }

    public function submissions(School $school): View
    {
        $submissions = $school->submissions()->with('instrument')->latest()->paginate(15);

        return view('admin.schools.submissions', compact('school', 'submissions'));
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'schools' => 'required|array',
            'schools.*' => 'exists:schools,id',
            'action' => 'required|in:delete',
        ]);

        if ($validated['action'] === 'delete') {
            School::whereIn('id', $validated['schools'])->delete();
        }

        return redirect()
            ->route('admin.schools.index')
            ->with('success', 'Aksi berhasil dilakukan');
    }
}
