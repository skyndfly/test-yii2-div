<?php

namespace app\services\request;

use app\services\request\contract\RequestCreateServiceContract;
use app\services\request\dto\RequestCreateDto;

class RequestCreateService implements RequestCreateServiceContract
{

    public function execute(RequestCreateDto $dto): void
    {
    }
}