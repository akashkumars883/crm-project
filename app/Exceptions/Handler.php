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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, \Throwable $e)
    {
        // Add enough padding so Chrome doesn't block it as a "short" 500 response
        $padding = str_repeat("<!-- padding to bypass chrome friendly error pages padding to bypass chrome friendly error pages padding to bypass chrome friendly error pages -->\n", 20);
        $html = "<html><body><h1>System Error Encountered</h1><h2>Error Message:</h2><pre>" . e($e->getMessage()) . "</pre><h2>File:</h2><p>" . e($e->getFile()) . " at line " . e($e->getLine()) . "</p><h2>Stack Trace:</h2><pre>" . e($e->getTraceAsString()) . "</pre>" . $padding . "</body></html>";
        return response($html, 500);
    }
}
