<?php

namespace App\Http\Controllers;

use App\Services\InstrumentSubmissionService;
use Illuminate\Http\Request;

class PublicInstrumentController extends Controller
{
    protected InstrumentSubmissionService $service;

    public function __construct(InstrumentSubmissionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $instrument = $this->service->getInstrument('KPTK-2024');

        if (! $instrument) {
            abort(404, 'Instrumen tidak ditemukan');
        }

        return view('instrument.form', compact('instrument'));
    }

    public function store(Request $request)
    {
        try {
            $school = $this->service->submit($request->all());

            return redirect()->route('landing')->with('success', 'Data berhasil disimpan. Terima kasih atas partisipasi Anda.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.')
                ->withInput();
        }
    }
}
