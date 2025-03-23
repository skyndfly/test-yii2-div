<?php

namespace app\services\request;

use app\repositories\contracts\RequestRepositoryContract;
use app\services\request\contract\RequestCreateServiceContract;
use app\services\request\dto\RequestCreateDto;

class RequestCreateService implements RequestCreateServiceContract
{
    private RequestRepositoryContract $repository;

    public function __construct(RequestRepositoryContract $repository)
    {
        $this->repository = $repository;
    }


    public function execute(RequestCreateDto $dto): void
    {
        $this->repository->create($dto);
    }
}