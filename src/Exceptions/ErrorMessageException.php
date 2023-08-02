<?php

namespace App\Exceptions;

use Exception;

class ErrorMessageException extends Exception
{
    public function render(): array
    {
        return [
            'data' => $this->getMessage(),
            'code' => 400,
        ];
    }
}
