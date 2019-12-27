<?php

namespace App\Http\Repositories\Books;

use App\Http\Repositories\BaseRepository;
use App\Models\Book as Model;

class BooksRepository extends BaseRepository
{
    protected $model = Model::class;
}
