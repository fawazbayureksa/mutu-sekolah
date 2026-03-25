<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (SubmissionNotFoundException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
            }

            return redirect()->back()->with('error', $e->getMessage());
        });

        $this->renderable(function (InvalidStatusTransitionException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            return redirect()->back()->with('error', $e->getMessage());
        });

        $this->renderable(function (TokenExpiredException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage()], Response::HTTP_GONE);
            }

            return redirect()->route('landing')->with('error', $e->getMessage());
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
