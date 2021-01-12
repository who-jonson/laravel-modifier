<?php

namespace WhoJonson\LaravelOrganizer\Repositories;

use BadMethodCallException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use WhoJonson\LaravelOrganizer\Exceptions\UndefinedModelException;
use WhoJonson\LaravelOrganizer\Contracts\Repository as RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    /**
     * @var Model|null
     */
    protected $model;

    public function __construct(?Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param int|string|null $id
     *
     * @return Collection|Model[]|Model|null
     */
    public function get($id = null)
    {
        return $id
            ? $this->model->find($id)
            : $this->model->all();
    }

    /**
     * @param array $data
     *
     * @return Model|null
     */
    public function create(array $data) : ?Model
    {
        return $this->model->create($data);
    }


    /**
     * @param int|string $id
     * @param array $data
     *
     * @return Model|null
     */
    public function update($id, array $data) : ?Model
    {
        $model = $this->get($id);
        if(!$model || !$model->update($data)) {
            return null;
        }
        return $model->refresh();
    }

    /**
     * @param int|string $id
     *
     * @return bool|string|null
     */
    public function delete($id)
    {
        $model = $this->get($id);
        if (!$model) {
            return 'Requested resource not found!';
        }
        try {
            return $model->delete();
        } catch (\Exception $e) {
            return 'Something went wrong!';
        }
    }

    /**
     * @return array
     */
    public function fillable() : array
    {
        return $this->model->getFillable();
    }

    /**
     * @throws UndefinedModelException
     */
    private function checkModel() {
        if(!$this->model) {
            throw new UndefinedModelException();
        }
    }

    /**
     * @param $method
     * @param $arguments
     *
     * @return bool
     * @throws UndefinedModelException|BadMethodCallException
     */
    public function __call($method, $arguments) : bool
    {
        if(method_exists($this, $method)) {
            $this->checkModel();
            return call_user_func_array([$this, $method], $arguments);
        } else {
            throw new BadMethodCallException();
        }
    }

}
