<?php

namespace App\Http\Requests\Api\CRUD;

use App\Models\ISortable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Models;

class IndexRequest extends FormRequest
{
    public function rules()
    {
        return $this->buildRules() + [
            'limit' => ['integer', 'min:0'],
            'offset' => ['integer', 'min:0'],
        ];
    }

    private function buildRules()
    {
        $result = [];

        $name = Str::singular(explode('/', $this->path())[1]);
        $className = 'App\Models\\'.ucfirst($name);
        if (class_exists($className)) {
            $object = new $className();
            if ($object instanceof ISortable) {
                $sortFieldAliases = $object->getFieldAliases();
                $keys = array_keys($sortFieldAliases);
                $descKeys = array_map(function ($key) {
                    return '-'.$key;
                }, $keys);
                $string = implode(',', array_merge($keys, $descKeys));
                $result['sort'] = ["in:$string"];
            }
        }
        return $result;
    }
}
