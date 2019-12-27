<?php

namespace App\Http\Controllers\Api\Books;

use App\Http\Controllers\CRUDController;
use App\Http\Repositories\Books\BooksRepository;
use App\Models\Book;

class BooksCRUDController extends CRUDController
{
    public function __construct(BooksRepository $repository, Book $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }
}
