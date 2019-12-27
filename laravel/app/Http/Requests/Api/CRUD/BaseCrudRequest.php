<?php

namespace App\Http\Requests\Api\CRUD;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

abstract class BaseCrudRequest extends FormRequest
{
    /**
     * Получает объект класса, чтобы потом оттуда взять параметры
     * @return Model|null
     */
    protected function getClass()
    {
        $name = Str::singular(explode('/', $this->path())[1]);
        $className = 'App\Models\\'.ucfirst($name);
        if (class_exists($className)) {
            $object = new $className();
            return $object;
        }
        return null;
    }

    /**
     * Получает дополнительные ограничения из модели
     * @return array
     */
    abstract protected function buildRules();
}
