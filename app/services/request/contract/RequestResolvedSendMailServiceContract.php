<?php

namespace app\services\request\contract;

interface RequestResolvedSendMailServiceContract
{
    public function send(string $email, string $comment): void;
}