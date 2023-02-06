<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'errors' => [
                    'message' => trans('exception.validation'),
                    'errors'  => $exception->errors()
                ]
            ], 422);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'errors' => [
                    'message' => trans('exception.unauthorized')
                ]
            ], 401);
        }

        if ($exception instanceof ErrorException) {
            return response()->json([
                'message' => trans($exception->getName(), $exception->getParams()),
            ], $exception->getStatusCode());
        }

        return $this->prepareJsonResponse($request, $exception);
    }
}
