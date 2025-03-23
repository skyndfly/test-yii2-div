<?php

namespace app\services\request;

use app\repositories\contracts\RequestRepositoryContract;
use app\services\request\contract\RequestFilteredServiceContract;

class RequestFilteredService implements RequestFilteredServiceContract
{
    private RequestRepositoryContract $repository;

    public function __construct(RequestRepositoryContract $repository)
    {
        $this->repository = $repository;
    }


    public function execute(?array $filters): array
    {
       return $this->repository->getFiltered($filters);
    }
}