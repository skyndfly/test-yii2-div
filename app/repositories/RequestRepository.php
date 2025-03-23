<?php
namespace app\repositories;
use app\repositories\contracts\RequestRepositoryContract;
use app\services\request\dto\RequestCreateDto;

class RequestRepository implements RequestRepositoryContract
{

    public function create(RequestCreateDto $dto)
    {
        // TODO: Implement create() method.
    }
}