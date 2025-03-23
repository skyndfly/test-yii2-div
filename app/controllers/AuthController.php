<?php

namespace app\controllers;

use app\components\ApiResponse;
use app\models\AuthToken;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public function beforeAction($action)
    {
        // Отключаем CSRF проверку для метода login
        if ($action->id === 'login') {
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    public function actionLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');
        $user = User::findOne(['username' => $username]);
        if ($user && Yii::$app->security->validatePassword($password, $user->password_hash)) {
            $token = Yii::$app->security->generateRandomString();
            $authToken = new AuthToken();
            $authToken->token = $token;
            $authToken->user_id = $user->id;
            $authToken->save();

            return ApiResponse::success(['token' => $token]);
        }

        return ApiResponse::error('Invalid credentials', 401);

    }
}