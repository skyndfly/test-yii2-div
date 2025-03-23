<?php

namespace app\controllers;

use app\components\ApiResponse;
use app\services\auth\contracts\AuthLoginServiceContract;
use Exception;
use Yii;
use yii\web\Controller;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="Operations for user authentication"
 * )
 */
class AuthController extends Controller
{
    private AuthLoginServiceContract $loginService;

    public function __construct(
        $id,
        $module,
        AuthLoginServiceContract $loginService,
        $config = [],
    ) {
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

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Аутентификация"},
     *     summary="Получить токен авторизации",
     *     description="Аутентификация пользователя и возврат токена доступа",
     *     @OA\RequestBody(
     *         description="Учетные данные",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"username", "password"},
     *                 @OA\Property(property="username", type="string", example="admin@example.com"),
     *                 @OA\Property(property="password", type="string", example="password123")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешная аутентификация",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="token",
     *                     type="string",
     *                     example="a7d82K9vRqPwLb3cX1mZ0yT5nFgH6jSe"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неверные учетные данные"
     *     )
     * )
     */
    public function actionLogin()
    {
        try {
            $username = Yii::$app->request->post('username');
            $password = Yii::$app->request->post('password');

            $token = $this->loginService->execute($username, $password);
            return ApiResponse::success(['token' => $token]);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }
    }


}