<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function create(array $data);

    public function createMany(array $data);

    public function update(array $data, $id);

    public function find($id);

    public function findWhere(array $where);

    public function findWhereWith(array $where, array $with);

    public function first();

    public function last();

    public function get($orderKey = 'id', $orderDir = "DESC");

    public function getWhere(array $where, $orderKey = 'id', $orderDir = "DESC");

    public function getWhereWith(array $where, array $with, $orderKey = 'id', $orderDir = "DESC");

    public function findWith($id, array $with);

    public function getWith(array $with, $orderKey = 'id', $orderDir = "DESC");

    public function delete($id);

    public function count();
}
