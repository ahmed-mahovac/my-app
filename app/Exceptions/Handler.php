<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
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
    }

    public function report(Throwable $exception)
    {
        Log::error('Exception: ' . $exception->getMessage() . ' Stack trace: ' . $exception->getTraceAsString());
    }


    public function render($request, Throwable $exception)
    {
        
        if ($this->isHttpException($exception)) {
            return $this->renderHttpException($exception);
        } 
        else if($exception instanceof UserException){
            return response()->json(['message' => 'User exception. An unexpected has error occurred.'], 500);
        }
        else{
            // e.g. Eloquent exception
            return response()->json(['message' => 'Server error. An unexpected error has occurred.'], 500);
        }
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message'=> 'Unauthenticated.'], 401);
    }
}
