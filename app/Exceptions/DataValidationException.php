<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;
class DataValidationException extends Exception
{
    const DEFAULT_MESSAGE = 'DTO Validation Exception';

    protected array $context;

    public function __construct(Validator $validator, string $message = null, int $code = 0, ?\Throwable $previous = null)
    {
        $message = $message ?? self::DEFAULT_MESSAGE . ': ' . $validator->errors()->first();
        parent::__construct($message, $code, $previous);
        $this->context = $validator->errors()->toArray();
    }

    public function context(): array
    {
        return $this->context;
    }
}
