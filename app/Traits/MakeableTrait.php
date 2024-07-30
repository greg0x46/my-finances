<?php

namespace App\Traits;

trait MakeableTrait
{
    public static function make(array $parameters = []): static
    {
        if (app()->has(static::class)) {
            return app(static::class);
        }

        return app()->make(static::class, $parameters);
    }

}
