<?php

namespace app\services\request\contract;

interface RequestFilteredServiceContract
{
    public function execute(?array $filters): array;
}