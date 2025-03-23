<?php

namespace app\repositories\contracts;

use app\services\request\dto\RequestCreateDto;

interface RequestRepositoryContract
{
    public function create(RequestCreateDto $dto): void;

    public function getFiltered(?array $filters): array;

    public function resolve(int $id, string $message): void;

    public function getEmailById(int $id): string;
}