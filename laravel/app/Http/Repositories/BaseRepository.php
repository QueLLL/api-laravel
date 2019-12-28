<?php

namespace App\Http\Repositories;

use App\Models\ISortable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    const DEFAULT_LIMIT = 100;

    /** @var Model; $model*/
    protected $model;

    public function __construct()
    {
        $this->model = new $this->model();
    }

    /**
     * Метод для получения набора сущностей по заданным параметрам:
     * лимит, оффсет, сортировка
     *
     * @param $params
     * @return \Illuminate\Support\Collection
     */
    public function getAll($params)
    {
        $model = $this->model;
        $query = DB::table($model->getTable())->whereNull('deleted_at');
        foreach ($params as $key => $param) {
            if ($key == 'sort'&& $model instanceof ISortable) {
                /** @var ISortable $model */
                $aliases = $model->getFieldAliases();
                $this->addOrderBy($query, $params['sort'], $aliases);
            }

            if ($key == 'limit') {
                $query->limit($params['limit']);
            }

            if ($key == 'offset') {
                $query->offset($params['offset']);
            }
        }
        if (!array_key_exists('limit', $params)) {
            $query->limit(self::DEFAULT_LIMIT);
        }
        return $query->get();
    }

    /**
     * Добавляет в запрос order by
     *
     * @param $query
     * @param $params
     * @param $aliases
     */
    protected function addOrderBy(&$query, $params, $aliases)
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
