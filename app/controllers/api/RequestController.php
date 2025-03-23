<?php

namespace app\controllers\api;

use app\components\ApiResponse;
use app\services\request\contract\RequestCreateServiceContract;
use app\services\request\dto\RequestCreateDto;
use Exception;
use Yii;
use yii\rest\Controller;

class RequestController extends Controller
{
    private RequestCreateServiceContract $createRequestService;

    public function __construct(
        $id,
        $module,
        RequestCreateServiceContract $createRequestService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->createRequestService = $createRequestService;
    }


    public function actionIndex()
    {
        print_r(1);
        die;
    }

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
            return ApiResponse::success($dto);
        }catch (Exception $e){
            return ApiResponse::error($e->getMessage(), 400, $e->getTraceAsString());
        }
    }
}