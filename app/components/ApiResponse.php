<?php
namespace app\components;
use Yii;

class ApiResponse
{
    public static function success($data = [], $message = 'OK', $code = 200): array
    {
        Yii::$app->response->statusCode = $code;
        return [
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ];
    }
    public static function error($message = 'Error', $code = 400, $errors = []): array
    {
        Yii::$app->response->statusCode = $code;
        return [
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ];
    }
}