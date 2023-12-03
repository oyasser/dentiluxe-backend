<?php

namespace App\Services;


use App\Repositories\Contracts\BaseRepository;
use App\Services\Contracts\BaseService;
use Exception;

abstract class Service implements BaseService
{
    /**
     * Repository class.
     * @var \App\Repositories\Contracts\BaseRepository
     */
    private $repository;


    /**
     * Set repository.
     * @param BaseRepository $repository
     */
    public function setRepo(BaseRepository $repository): void
    {
        $this->repository = $repository;
    }

    /**
     * Get the repository object.
     * @return BaseRepository
     */
    public function repo(): BaseRepository
    {
        return $this->repository;
    }


    /**
     * Try to find the called method in repository layer
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call(string $method, array $arguments)
    {
        if (method_exists($this->repo(), $method)) {
            return $this->repo()->{$method}(...$arguments);
        }

        throw new Exception(sprintf("Can't find method (%s) on %s class.", $method, static::class));
    }

    /**
     * Try to get the given dependency
     * @param string $dependency
     * @return mixed
     * @throws Exception
     */
    public function __get(string $dependency)
    {
        if (!method_exists($this, $dependency)) {
            throw new Exception(sprintf(
                "Call undefined (%s) property. [Tip] try to use setRepo() or setCache() methods in your constructor.",
                $dependency
            ));
        }

        return $this->{$dependency}();
    }
}
