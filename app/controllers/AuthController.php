<?php

namespace app\controllers;

use app\components\ApiResponse;
use app\services\auth\contracts\AuthLoginServiceContract;
use Exception;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    private AuthLoginServiceContract $loginService;

    public function __construct(
        $id,
        $module,
        AuthLoginServiceContract $loginService,
        $config = [],
    )
    {
        parent::__construct($id, $module, $config);
        $this->loginService = $loginService;
    }


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
        try {
            $username = Yii::$app->request->post('username');
            $password = Yii::$app->request->post('password');

            $token = $this->loginService->execute($username, $password);
            return ApiResponse::success(['token' => $token]);
        }catch (Exception $e){
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }


    }
}