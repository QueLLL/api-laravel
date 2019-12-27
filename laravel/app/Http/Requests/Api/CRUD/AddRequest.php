<?php

namespace App\Http\Requests\Api\CRUD;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'year_of_writing' => ['integer', 'min:100', 'min:2100'],
            'number_of_pages' => ['integer', 'min:0'],
        ];
    }
}
