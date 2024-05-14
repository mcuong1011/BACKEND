<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if ($e instanceof ApiException) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => $e->getStatusCode(),
            ], $e->getStatusCode());
        }
        if ($e instanceof AuthenticationException) {
            return response()->json([
                'error' => 'Unauthenticated',
                'status' => 401,
            ], 401);
        }
        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Resource not found',
                'status' => 404,
            ], 404);
        }
        if ($e instanceof ValidationException) {
            return response()->json([
                'error' => $e->validator->errors()->getMessages(),
                'status' => 400,
            ], 400);
        }
        return parent::render($request, $e);
    }


}
