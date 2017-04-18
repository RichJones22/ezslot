<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Entities\BaseEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interface BaseRepositoryContract.
 */
interface BaseRepositoryContract
{
    /**
     * populate the entity with model data.
     *
     * @param Collection $records
     *
     * @return Collection
     */
    public function hydrateEntity(Collection $records): Collection;

    /**
     * @param BaseEntity $entity
     *
     * @return mixed
     */
    public function persistEntity(BaseEntity $entity);

    /**
     * @return BaseEntity
     */
    public function getEntity(): BaseEntity;

    /**
     * @param BaseEntity $entity
     */
    public function setEntity(BaseEntity $entity);

    /**
     * @return Model
     */
    public function getModel(): Model;

    /**
     * @param Model $model
     */
    public function setModel(Model $model);

    /**
     * @return Collection
     */
    public function getCollection(): Collection;

    /**
     * @param Collection $collection
     */
    public function setCollection(Collection $collection);
}
