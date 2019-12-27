<?php

namespace App\Http\Repositories;

use App\Models\Traits\ISortable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

abstract class BaseRepository
{
    const DEFAULT_LIMIT = 100;

    /** @var Model; $model*/
    protected $model;

    public function __construct()
    {
        $this->model = new $this->model();
    }

    public function getAll($params) : Collection
    {
        $model = $this->model;
        $query = $model::query();

        foreach ($params as $key => $param) {
            if ($key == 'sort'&& $model instanceof ISortable) {
                /** @var ISortable $model */
                $aliases = $model->getFieldAliases();
                $this->addOrderBy($query, $params['sort'], $aliases);
            }

            if ($key = 'limit') {
                $query->limit($params['limit']);
            } else {
                $query->limit(self::DEFAULT_LIMIT);
            }

            if ($key = 'offest') {
                $query->offset($params['offest']);
            }
        }

        return $query->get();
    }

    protected function addOrderBy(&$query, $params, $aliases): void
    {
        $sortParams = explode(',', $params);
        foreach ($sortParams as $sortParam) {
            $method = 'ASC';
            if ($sortParam[0] == '-') {
                $sortParam = substr($sortParam, 1);
                $method = 'DESC';
            }
            if ($realField = $aliases[$sortParam]) {
                /** @var Builder $query */
                $query->orderBy($realField, $method);
            }
        }
    }
}
