<?php


namespace WhoJonson\LaravelOrganizer\Contracts;


use BadMethodCallException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use WhoJonson\LaravelOrganizer\Exceptions\UndefinedModelException;

interface Repository
{
    /**
     * @param int|string|null $id
     *
     * @return Collection|Model[]|Model|null
     */
    public function get($id = null);

    /**
     * @param array $data
     *
     * @return Model|null
     */
    public function create(array $data) : ?Model;

    /**
     * @param int|string $id
     * @param array $data
     *
     * @return Model|null
     */
    public function update($id, array $data) : ?Model;

    /**
     * @param int|string $id
     *
     * @return bool|string|null
     */
    public function delete($id);

    /**
     * @return array
     */
    public function fillable() : array;

    /**
     * @param $method
     * @param $arguments
     *
     * @return bool
     * @throws UndefinedModelException|BadMethodCallException
     */
    public function __call($method, $arguments): bool;
}
