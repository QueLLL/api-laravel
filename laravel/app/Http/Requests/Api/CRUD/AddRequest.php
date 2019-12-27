<?php

namespace App\Http\Requests\Api\CRUD;

class AddRequest extends BaseCrudRequest
{
    public function rules()
    {
        return $this->buildRules();
    }

    protected function buildRules()
    {
        $result = [];

        if ($object = $this->getClass()) {
            $result = $object->validateParams;
        }

        return $result;
    }
}
