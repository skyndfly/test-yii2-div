<?php

namespace app\services\request\contract;

interface RequestResolveServiceContract
{
    public function execute(int $id, string $comment): void;
}