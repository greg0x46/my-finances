<?php

namespace App\Data;

use App\Exceptions\DataValidationException;
use Illuminate\Support\Str;
use App\Traits\MakeableTrait;
use Illuminate\Support\Facades\Validator;

abstract class BaseData
{
    use MakeableTrait {
        make as traitMake;
    }

    public static function make(array $parameters = []): static
    {
        return static::traitMake(['data' => $parameters]);
    }

    public function __construct(array $data)
    {
        foreach ($this->hasOne() as $attribute => $dto) {
            if (empty($data[$attribute])) {
                unset($data[$attribute]);
                continue;
            }

            $this->$attribute = $dto::make($data[$attribute]);
            unset($data[$data[$attribute]]);
        }

        foreach ($this->hasMany() as $attribute => $dto) {
            if (empty($data[$attribute])) {
                unset($data[$attribute]);
                continue;
            }

            $this->$attribute = collect();
            foreach ($data[$attribute] as $datum) {
                $this->$attribute->push($dto::make($datum));
            }

            unset($data[$attribute]);
        }

        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }

        $rules = $this->rules();

        if (!empty($rules)) {
            $validator = Validator::make($data, $this->rules());

            if ($validator->fails()) {
                throw new DataValidationException($validator);
            }
        }

        foreach ($this->appends() as $append) {
            $appendMethod = "append" . Str::ucfirst(Str::camel($append));
            $this->$appendMethod();
        }
    }

    public function __get(string $name): mixed
    {
        return $this->$name;
    }

    public function __set(string $name, mixed $value): void
    {
        $setter = 'set' . Str::ucfirst(Str::camel($name));

        if (method_exists($this, $setter)) {
            $this->$setter($value);
            return;
        }

        $this->$name = $value;
    }

    public function has($attribute): bool
    {
        return isset($this->$attribute);
    }

    public function hasMany(): array
    {
        return [];
    }

    public function hasOne()
    {
        return [];
    }

    public function rules(): array
    {
        return [];
    }

    public function appends()
    {
        return [];
    }

    public function toArray()
    {
        $data = get_object_vars($this);

        foreach (array_keys($this->hasOne()) as $attribute) {
            if (!isset($data[$attribute])) continue;
            $data[$attribute] = $data[$attribute]->toArray();
        }

        foreach (array_keys($this->hasMany()) as $attribute) {
            if (empty($data[$attribute])) continue;

            $data[$attribute] = $data[$attribute]->map(function ($i) {
                return $i->toArray();
            })->toArray();
        }

        return $data;
    }

    public function toArrayWithoutRelations()
    {
        return array_except(
            get_object_vars($this),
            array_merge(
                array_keys($this->hasOne()),
                array_keys($this->hasMany()),
            )
        );
    }
}
