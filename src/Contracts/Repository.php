<?php


namespace WhoJonson\LaravelOrganizer\Contracts;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use WhoJonson\LaravelOrganizer\Exceptions\UndefinedModelException;

interface Repository
{
    /**
     * @param int|string|null $id
     *
     * @return Collection|Model[]|Model|null
     * @throws UndefinedModelException
     */
    public function get($id = null);

    /**
     * @param array $data
     *
     * @return Model|null
     * @throws UndefinedModelException
     */
    public function create(array $data) : ?Model;

    /**
     * @param int|string $id
     * @param array $data
     *
     * @return Model|null
     * @throws UndefinedModelException
     */
    public function update($id, array $data) : ?Model;

    /**
     * @param int|string $id
     *
     * @return bool
     * @throws UndefinedModelException
     */
    public function delete($id) : ?bool;

    /**
     * @return array
     * @throws UndefinedModelException
     */
    public function fillable() : array;
}
