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
        $items = $this->repository->getAll($request);

        return $this->sendSuccessResponse($items);
    }

    public function store(AddRequest $request)
    {
        $this->model->fill($request->all());

        $this->sendSuccessResponse('success', 201);
    }

    public function destroy($id)
    {
        if ($this->model::destroy($id)) {
            $this->sendSuccessResponse('success', 200);
        } else {
            $this->sendErrorResponse('Not found', 404);
        }
    }

    public function update(addRequest $request, $id)
    {
//        $this->model::query()->find($id)->first()->update($request);
//
//        return response()->json('success', 200);
    }
}
