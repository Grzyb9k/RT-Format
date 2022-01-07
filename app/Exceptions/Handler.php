<?php

namespace App\Exceptions;

use App\Mail\ErrorMail;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
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
    public function report($e)
    {
        if ($e instanceof \Exception) {
            $error['code'] = $e->getCode();
            $error['line'] = $e->getLine();
            $error['message'] = $e->getMessage();

            Log::error($error['message'] . ' | ' . Route::getCurrentRoute()->getActionName() . ' | CODE ' . $error['code']);

        }
        return parent::report($e);
    }
}
