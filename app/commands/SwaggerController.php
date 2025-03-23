<?php

namespace app\commands;

use yii\console\Controller;
use OpenApi\Generator;

class SwaggerController extends Controller
{
    public function actionGenerate()
    {
        $openapi = Generator::scan([__DIR__ . '/../controllers', __DIR__ . '/../models']);
        file_put_contents(__DIR__ . '/../web/swagger.json', $openapi->toJson());
        echo "Swagger JSON сгенерирован\n";
    }
}