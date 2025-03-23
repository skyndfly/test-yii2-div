<?php

namespace app\filters;

use app\components\ApiResponse;
use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;
use app\models\AuthToken;

class TokenAuth extends ActionFilter
{
    public function beforeAction($action)
    {
        $token = Yii::$app->request->headers->get('Authorization');

        if (!$token) {
            $this->sendErrorResponse('Token is missing.');
        }

        $authToken = AuthToken::findOne(['token' => $token]);

        if (!$authToken) {
            $this->sendErrorResponse('Invalid token.');
        }

        // Если все проверки прошли успешно, продолжаем выполнение
        return parent::beforeAction($action);
    }


    protected function sendErrorResponse(string $message)
    {

        Yii::$app->response->data = ApiResponse::error($message, 401);

        // Выбросить исключение с ошибкой
        throw new UnauthorizedHttpException($message);
    }
}