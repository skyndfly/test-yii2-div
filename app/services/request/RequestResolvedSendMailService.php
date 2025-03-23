<?php

namespace app\services\request;

use app\services\request\contract\RequestResolvedSendMailServiceContract;
use Yii;

class RequestResolvedSendMailService implements RequestResolvedSendMailServiceContract
{

    public function send(string $email, string $comment): void
    {
        //TODO добавить шаблон письма
        Yii::$app->mailer->compose()

            ->setTo($email)
            ->setSubject('Ответ на вашу заявку')
            ->setTextBody($comment)
            ->send();
    }
}