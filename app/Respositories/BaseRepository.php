<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\BaseRepositoryContract;
use App\Entities\BaseEntity;
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
        /** @var Collection $collection */
        $collection = new $this->collection;

        foreach ($records as $record) {
            $entity = new $this->entity();

            foreach ($record->getAttributes() as $key => $value) {
                $method = 'set'.ucfirst(Str::camel($key));
                $entity->$method($value);
            }

            $collection->push($entity);
        }

        return $collection;
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

        foreach (get_class_methods($entity) as $method) {
            if ($entity->isValidMethod($method)) {
                // derive attribute name from getter name.
                $attributeName = str::snake(substr($method, strlen('get'), (strlen($method) - strlen('get'))));

                // set attribute on model
                $model->setAttribute($attributeName, $entity->$method());
            }
        }

        // persist model
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
