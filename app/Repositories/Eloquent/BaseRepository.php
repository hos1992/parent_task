<?php

namespace App\Repositories\Eloquent;

use App\Repositories\BaseRepositoryInterface;
use App\Traits\Helpers;

abstract class BaseRepository implements BaseRepositoryInterface
{

    use Helpers;

    protected $model;

    // insert new row to ( current model )
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // insert multible new rows to ( current model )
    public function createMany(array $data)
    {
        return $this->model->createMany($data);
    }

    // update row to ( current model )
    public function update(array $data, $id)
    {
        $this->model->where('id', $id)->update($data);
        return $this->find($id);
    }

    // get 1 row by ID
    public function find($id)
    {
        return $this->model->find($id);
    }

    // get 1 row where
    public function findWhere(array $where)
    {
        return $this->model->where($where)->first();
    }

    // get 1 row where with
    public function findWhereWith(array $where, array $with)
    {
        return $this->model->where($where)->with($with)->first();
    }

    // get first row
    public function first()
    {
        return $this->model->first();
    }

    // get last row
    public function last()
    {
        return $this->model->last();
    }

    // get All
    public function get($orderKey = 'id', $orderDir = "DESC")
    {
        return $this->model->orderBy($orderKey, $orderDir)->get();
    }

    // get Where condition
    public function getWhere(array $where, $orderKey = 'id', $orderDir = "DESC")
    {
        return $this->model->where($where)->orderBy($orderKey, $orderDir)->get();
    }

    // get 1 row by ID With relations
    public function findWith($id, array $with)
    {
        return $this->model->with($with)->find($id);
    }

    // get All with relations
    public function getWith(array $with, $orderKey = 'id', $orderDir = "DESC")
    {
        return $this->model->orderBy($orderKey, $orderDir)->with($with)->get();
    }

    // get Where condition with relations
    public function getWhereWith(array $where, array $with, $orderKey = 'id', $orderDir = "DESC")
    {
        return $this->model->where($where)->orderBy($orderKey, $orderDir)->with($with)->get();
    }

    // delete row
    public function delete($id)
    {
        $this->model->destroy($id);
        return [];
    }

    // count rows
    public function count()
    {
        return $this->model->count();
    }
}
