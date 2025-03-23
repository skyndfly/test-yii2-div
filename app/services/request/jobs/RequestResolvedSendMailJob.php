<?php

namespace app\services\request\jobs;



use app\services\request\contract\RequestResolvedSendMailServiceContract;
use Yii;
use yii\queue\JobInterface;

class RequestResolvedSendMailJob implements JobInterface
{
    public string $email;
    public string $comment;

    public function __construct(string $email, string $comment)
    {
        $this->email = $email;
        $this->comment = $comment;
    }


    public function execute($queue)
    {
        $this->getService()->send($this->email, $this->comment);
    }
    private function getService(): RequestResolvedSendMailServiceContract
    {
        return Yii::$container->get(RequestResolvedSendMailServiceContract::class);
    }
}