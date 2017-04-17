<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class BaseRepository implements BaseRepositoryContract
{
    /** @var string */
    const FROM_DATE = '1900-01-01';

    /**
     * @var BaseEntity
     */
    public $entity;
    /**
     * @var Model
     */
    public $model;
    /**
     * @var Collection
     */
    public $collection;

    public function __construct(
        BaseEntity $entity,
        Model $model,
        Collection $collection)
    {
        $this->setEntity($entity);
        $this->setModel($model);
        $this->setCollection($collection);
    }

    /**
     * populate the entity with model data.
     *
     * @param Collection $records
     *
     * @return Collection
     */
    public function hydrateEntity(Collection $records): Collection
    {
        foreach ($records as $record) {
            $entity = new $this->entity();
            foreach ($record->getAttributes() as $key => $value) {
                $method = 'set'.ucfirst(Str::camel($key));
                $entity->$method($value);
            }
            $this->getCollection()->push($entity);
        }

        return $this->getCollection();
    }

    /**
     * @param BaseEntity $entity
     *
     * @return $this
     */
    public function persistEntity(BaseEntity $entity)
    {
        /** @var Model $model */
        $model = new $this->model();
        foreach (get_class_methods($entity) as $key) {
            // only method names that begin with 'get'; aka... the getters...
            if (strncmp($key, 'get', strlen('get'))) {
                // derive attribute name from getter name; convert camel to snake.
                $attributeName = str::snake(substr($key, strlen('get'), (strlen($key) - strlen('get'))));
                $method = 'get'.ucfirst(str::camel($attributeName));
                $model->setAttribute($attributeName, $entity->$method());
            }
        }
        // persist $model
        $model->save();

        return $this;
    }

    /**
     * @return BaseEntity
     */
    public function getEntity(): BaseEntity
    {
        return $this->entity;
    }

    /**
     * @param BaseEntity $entity
     */
    public function setEntity(BaseEntity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }

    /**
     * @param Collection $collection
     */
    public function setCollection(Collection $collection)
    {
        $this->collection = $collection;
    }
}
