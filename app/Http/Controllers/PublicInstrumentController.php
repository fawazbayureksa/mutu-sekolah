<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstrumentSubmissionRequest;
use App\Services\InstrumentSubmissionService;
use Illuminate\Support\Facades\Log;

class PublicInstrumentController extends Controller
{
    protected InstrumentSubmissionService $service;

    public function __construct(InstrumentSubmissionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        // Try advanced instrument first, fallback to legacy
        $instrument = $this->service->getInstrumentWithHierarchy('KPTK-ADV-2024');
        $useHierarchy = true;

        if (!$instrument) {
            $instrument = $this->service->getInstrument('KPTK-2024');
            $useHierarchy = false;
        }

        if (!$instrument) {
            abort(404, 'Instrumen tidak ditemukan');
        }

        // Get aspects for hierarchical view
        $aspects = $useHierarchy ? $instrument->aspects : collect();

        return view('instrument.form', compact('instrument', 'aspects', 'useHierarchy'));
    }

    public function store(InstrumentSubmissionRequest $request)
    {
        try {
            // Log the answers to debug structure type
            Log::info('Form submission answers:', ['answers' => $request->input('answers')]);

            $submission = $this->service->submit($request->validated());

            return redirect()->route('landing')->with('success', 'Data berhasil disimpan. Terima kasih atas partisipasi Anda.');
        } catch (\Exception $e) {
            Log::error('Submission error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.')
                ->withInput();
        }
    }
}
