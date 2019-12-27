<?php

namespace App\Http\Controllers;

use App\Http\Repositories\BaseRepository;
use App\Http\Requests\Api\CRUD\AddRequest;
use App\Http\Requests\Api\CRUD\IndexRequest;
use Illuminate\Database\Eloquent\Model;

abstract class CRUDController extends Controller
{
    /** @var BaseRepository $repository */
    protected $repository;
    /** @var Model */
    protected $model;

    public function index(IndexRequest $request)
    {
        $items = $this->repository->getAll($request->query());

        return $this->sendSuccessResponse($items);
    }

    public function store(AddRequest $request)
    {
        $book = $this->model->fill($request->all())->save();

        if ($book) {
            return $this->sendSuccessResponse('Successfully added', 201);
        } else {
            return $this->sendErrorResponse('Not added');
        }
    }

    public function destroy($id)
    {
        if ($this->model::destroy($id)) {
            return $this->sendSuccessResponse('Deleted');
        } else {
            return $this->sendErrorResponse('Not found', 404);
        }
    }

    public function update(addRequest $request, $id)
    {
//        $this->model::query()->find($id)->first()->update($request);
//
//        return response()->json('success', 200);
    }
}
