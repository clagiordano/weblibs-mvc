<?php

namespace clagiordano\weblibs\mvc;

use clagiordano\weblibs\mvc\exceptions\ContainerException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use clagiordano\weblibs\mvc\exceptions\NotFoundException;

/**
 * Class Container
 * @package clagiordano\weblibs\mvc
 */
class Container implements ContainerInterface
{
    /** @var array $containerStorage */
    protected $containerStorage = [];

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if ($this->has($id) === false) {
            throw new NotFoundException("No entry was found for {$id} identifier");
        }

        $service = $this->containerStorage[$id];
        if (!$service) {
            throw new ContainerException('Error while retrieving the entry');
        }

        return $service;
    }

    /**
     * @param string $id
     * @param mixed $service
     */
    public function set($id, $service)
    {
        $this->containerStorage[$id] = $service;
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id)
    {
        return (isset($this->containerStorage[$id]) ? true : false);
    }
}