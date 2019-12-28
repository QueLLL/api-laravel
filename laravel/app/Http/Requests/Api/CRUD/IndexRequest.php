<?php

namespace App\Http\Requests\Api\CRUD;

use App\Models\ISortable;

class IndexRequest extends BaseCrudRequest
{
    public function rules()
    {
        return $this->buildRules() + [
            'limit' => ['integer', 'min:0'],
            'offset' => ['integer', 'min:0'],
        ];
    }

    protected function buildRules()
    {
        $result = [];
        if ($object = $this->getClass()) {
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
