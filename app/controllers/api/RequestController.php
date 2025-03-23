<?php

namespace app\controllers\api;

use app\components\ApiResponse;
use app\services\request\contract\RequestCreateServiceContract;
use app\services\request\contract\RequestFilteredServiceContract;
use app\services\request\dto\RequestCreateDto;
use Exception;
use Yii;
use yii\rest\Controller;

class RequestController extends Controller
{
    private RequestCreateServiceContract $createRequestService;
    private RequestFilteredServiceContract $filteredRequestService;

    public function __construct(
        $id,
        $module,
        RequestCreateServiceContract $createRequestService,
        RequestFilteredServiceContract $filteredRequestService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->createRequestService = $createRequestService;
        $this->filteredRequestService = $filteredRequestService;
    }


    public function actionIndex()
    {
        try {

           $result =  $this->filteredRequestService->execute(Yii::$app->request->get('filters'));
           return ApiResponse::success($result);
        }catch (Exception $e){
            return ApiResponse::error($e->getMessage(), 400, $e->getTraceAsString());
        }
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