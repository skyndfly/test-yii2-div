<?php

namespace app\services\request;

use app\repositories\contracts\RequestRepositoryContract;
use app\services\request\jobs\RequestResolvedSendMailJob;
use Yii;

class RequestResolveService implements contract\RequestResolveServiceContract
{
    private RequestRepositoryContract $repository;

    public function __construct(RequestRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id, string $comment): void
    {
        $this->repository->resolve($id, $comment);
        $email =  $this->repository->getEmailById($id);
        Yii::$app->queue->push(new RequestResolvedSendMailJob($email, $comment));
    }
}