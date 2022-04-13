<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    public function __call($method, $parameters)
    {
        return $this->model->{$method}(...$parameters);
    }

    abstract public function getModel();

    /**
     * @return Model
     */
    public function setModel()
    {
        $model = app()->make($this->getModel());
        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->getModel()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Filter query.
     *
     * @param mixed $query
     *
     * @return mixed
     */
    public function filter($query, array $data = [])
    {
        if (count($data) && method_exists($this, 'search')) {
            foreach ($data as $key => $value) {
                $query = $this->search($query, $key, $value);
            }
        }

        return $query;
    }

    /**
     * List items.
     *
     * @return mixed
     */
    public function list(array $condition)
    {
        // select
        $entities = $this->model->select($condition['select'] ?? ['*']);

        // relations
        if (isset($condition['with'])) {
            $entities = $entities->with($condition['with']);
        }

        // realtion counts
        if (isset($condition['with_count'])) {
            $entities = $entities->withCount($condition['with_count']);
        }

        // filter data
        if (count($condition)) {
            $entities = $this->filter($entities, $condition);
        }

        // order by
        if (isset($condition['order_by'], $condition['order_type'])) {
            $entities = $entities->orderBy($condition['order_by'], $condition['order_type'] ? 'asc' : 'desc');
        }

        // first
        if (isset($condition['first'])) {
            return $entities->first();
        }

        // all
        if (isset($condition['all'])) {
            return $entities->get();
        }

        // limit
        if (isset($condition['limit'])) {
            return $entities->paginate($condition['limit']);
        }

        return $entities->get();
    }
}
