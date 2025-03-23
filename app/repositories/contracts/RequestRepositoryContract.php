<?php

namespace app\repositories\contracts;

use app\services\request\dto\RequestCreateDto;

interface RequestRepositoryContract
{
    public function create(RequestCreateDto $dto);

    public function getFiltered(?array $filters): array;
}