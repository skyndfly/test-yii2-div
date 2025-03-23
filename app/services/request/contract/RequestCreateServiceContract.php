<?php

namespace app\services\request\contract;

use app\services\request\dto\RequestCreateDto;

interface RequestCreateServiceContract
{
    public function execute(RequestCreateDto $dto): void;
}