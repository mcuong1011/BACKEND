<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    private int $statusCode;

    public function __construct($message, $code = 500)
    {
        $this->statusCode = $code;
        parent::__construct($message, $code);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
