<?php

namespace app\controllers\api;

use yii\rest\Controller;

class RequestController extends Controller
{
    public function actionIndex()
    {
        print_r(1);
        die;
    }
    public function actionCreate()
    {
        print_r(2);
        die;
    }
}