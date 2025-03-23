<?php
namespace app\components;
use Yii;
use yii\web\Response;

class ApiResponse
{
    public static function success($data = [], $message = 'OK', $code = 200): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = $code;
        return [
            'status' => $code,
            'message' => $message,
            'total' => count($data),
            'data' => $data,
        ];
    }
    public static function error($message = 'Error', $code = 400, $errors = []): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = $code;
        return [
            'status' => $code,
            'message' => $message,
            'errors' => $errors,
        ];
    }
}