<?php

namespace app\controllers\api;

use app\components\ApiResponse;
use app\filters\TokenAuth;
use app\services\request\contract\RequestCreateServiceContract;
use app\services\request\contract\RequestFilteredServiceContract;
use app\services\request\contract\RequestResolveServiceContract;
use app\services\request\dto\RequestCreateDto;
use DomainException;
use Exception;
use Yii;
use yii\rest\Controller;
/**
 * @OA\Info(
 *     title="API системы заявок",
 *     version="1.0.0",
 *     @OA\Contact(email="support@example.com"),
 *     @OA\License(name="Proprietary")
 * )
 * @OA\SecurityScheme(
 *     securityScheme="ApiToken",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Access token authentication",
 * )
 */
class RequestController extends Controller
{
    private RequestCreateServiceContract $createRequestService;
    private RequestFilteredServiceContract $filteredRequestService;
    private RequestResolveServiceContract $resolveRequestService;

    public function __construct(
        $id,
        $module,
        RequestCreateServiceContract $createRequestService,
        RequestFilteredServiceContract $filteredRequestService,
        RequestResolveServiceContract $resolveRequestService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->createRequestService = $createRequestService;
        $this->filteredRequestService = $filteredRequestService;
        $this->resolveRequestService = $resolveRequestService;
    }

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => ['http://sky.com'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT'],
                ],
            ],
            'tokenAuth' => [
                'class' => TokenAuth::class,
                'only' => ['index', 'update'],
            ],
        ];
    }
    /**
     * @OA\Get(
     *     path="/api/requests",
     *     summary="Получить список заявок",
     *     tags={"Requests"},
     *     security={{"ApiToken":{}}},
     *     @OA\Parameter(
     *         name="filters[status]",
     *         in="query",
     *         description="Фильтрация по статусу (например: 'new', 'resolved')",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список заявок успешно получен",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="message", type="string"),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function actionIndex()
    {
        try {

            $result = $this->filteredRequestService->execute(Yii::$app->request->get('filters'));
            return ApiResponse::success($result);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 400, $e->getTraceAsString());
        }
    }
    /**
     * @OA\Post(
     *     path="/api/requests",
     *     summary="Создать новую заявку",
     *     tags={"Requests"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "message"},
     *             @OA\Property(property="name", type="string", example="Иван Иванов"),
     *             @OA\Property(property="email", type="string", format="email", example="ivan@example.com"),
     *             @OA\Property(property="message", type="string", example="Мне нужна помощь...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Заявка успешно создана"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Ошибка при создании заявки"
     *     )
     * )
     */
    public function actionCreate()
    {
        try {
            $data = Yii::$app->request->post();
            $dto = new RequestCreateDto(
                $data['name'],
                $data['email'],
                $data['message']
            );
            $this->createRequestService->execute($dto);
            return ApiResponse::success();
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 400, $e->getTraceAsString());
        }
    }
    /**
     * @OA\Put(
     *     path="/api/requests/{id}",
     *     summary="Оставить комментарий к заявке (ответить на нее)",
     *     tags={"Requests"},
     *     security={{"ApiToken":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID заявки",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"comment"},
     *             @OA\Property(property="comment", type="string", example="Ответ администратора на заявку")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Комментарий успешно добавлен"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Ошибка при добавлении комментария"
     *     ),
     *     @OA\Response(
     *         response=406,
     *         description="Comment cannot be null"
     *     )
     * )
     */
    public function actionUpdate(int $id)
    {
        try {
            $comment = Yii::$app->request->post('comment');
            if (is_null($comment)) {
                throw new DomainException('Comment cannot be null');
            }
            $this->resolveRequestService->execute($id, $comment);
            return ApiResponse::success();
        } catch (DomainException $e) {
            return ApiResponse::error($e->getMessage(), 406, $e->getTraceAsString());
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 400, $e->getTraceAsString());
        }
    }
}