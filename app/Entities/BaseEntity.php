<?php

declare(strict_types=1);

namespace App\Entities;

/**
 * Class BaseEntity.
 */
class BaseEntity
{
    /**
     * @var
     */
    private $instance;

    /**
     * BaseEntity constructor.
     */
    public function __construct()
    {
        self::setInstance($this);
    }

    /**
     * @param BaseEntity $fromEntity
     *
     * @return BaseEntity
     */
    public function translateByEntity(BaseEntity $fromEntity)
    {
        /** @var BaseEntity $toEntity */
        $toEntity = get_class($this);
        $toEntity = new $toEntity();

        $fromArrayMethods = get_class_methods($fromEntity);
        foreach (get_class_methods($toEntity) as $getMethod) {
            // only method names that begin with 'get'; aka... the getters...
            if ($this->isValidMethod($getMethod)) {
                if (in_array($getMethod, $fromArrayMethods, true)) {
                    // derive $setMethod
                    $setMethod = str_replace('get', 'set', $getMethod);
                    $toEntity->getInstance()->$setMethod($fromEntity->getInstance()->$getMethod());
                }
            }
        }

        return $toEntity;
    }

    /**
     * @param string $method
     *
     * @return bool
     */
    public function isValidMethod(string $method)
    {
        if ( ! strncmp($method, 'get', strlen('get'))) {
            if (strncmp($method, 'getInstance', strlen('getInstance'))) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @param mixed $instance
     */
    public function setInstance($instance)
    {
        $this->instance = $instance;
    }
}
