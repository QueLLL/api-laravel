<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model implements ISortable
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'year_of_writing', 'number_of_pages',
    ];

    public function getFieldAliases()
    {
        return [
            'name'  => 'name',
            'year'  => 'year_of_writing',
            'pages' => 'number_of_pages'
        ];
    }
}
