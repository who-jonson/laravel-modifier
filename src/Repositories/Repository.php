<?php


namespace WhoJonson\LaravelOrganizer\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use WhoJonson\LaravelOrganizer\Contracts\Repository as RepositoryInterface;
use WhoJonson\LaravelOrganizer\Exceptions\UndefinedModelException;

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
     *
     */
    public function get($id = null)
    {
        $this->checkModel();
        return $id
            ? $this->model->find($id)
            : $this->model->all();
    }

    /**
     * @param array $data
     * @return Model|null
     */
    public function create(array $data) : ?Model
    {
        $this->checkModel();
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
     * @return bool
     */
    public function delete($id) : ?bool
    {
        $model = $this->get($id);
        if (!$model) {
            return null;
        }
        try {
            return $model->delete();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return array
     */
    public function fillable() : array
    {
        $this->checkModel();
        return $this->model->getFillable();
    }

    /**
     * @return void
     * @throws UndefinedModelException
     */
    private function checkModel() {
        if(!$this->model) {
            throw new UndefinedModelException('Model not defined on constructor!');
        }
    }

}
