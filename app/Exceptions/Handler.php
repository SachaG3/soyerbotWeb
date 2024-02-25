<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

    public function render($request, Throwable $exception)
    {
        return redirect()->route('error')->with('error', 'Une erreur est survenue.');
    }
    public function register() {
        $this->reportable(function (Throwable $e) {
            //
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }
}
