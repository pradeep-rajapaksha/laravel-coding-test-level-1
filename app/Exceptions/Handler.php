<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // 
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->header('Content-Type') == 'application/json' || $request->is('api/*')) {
                return response(['error' => $e->getMessage()], $e->getCode() ?: 400);
            }
            // return response()->view('errors.invalid-order', [], 500);
        });
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function render($request, Throwable $e)
    // {
        // if ($request->header('Content-Type') == 'application/json' || $request->is('api/*')) {
            // return response(['error' => $e->getMessage()], $e->getCode() ?: 400);
        // }
    // }
}
