<?php

namespace App\Http\Controllers\Verifier;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordChangeRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VerifierPasswordController extends Controller
{
    public function edit(): View
    {
        return view('verifier.change-password');
    }

    public function update(PasswordChangeRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.password_changed',
            'model_type' => \App\Models\User::class,
            'model_id' => $user->id,
            'description' => "Changed own password",
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
