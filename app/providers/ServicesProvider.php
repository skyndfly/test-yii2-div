<?php
namespace app\providers;
use yii\base\BootstrapInterface;
use Yii;
class ServicesProvider implements BootstrapInterface
{

    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        $repositories = [
            \app\repositories\contracts\RequestRepositoryContract::class => \app\repositories\RequestRepository::class,
            \app\repositories\contracts\UserRepositoryContract::class => \app\repositories\UserRepository::class,
            \app\repositories\contracts\AuthTokenRepositoryContract::class => \app\repositories\AuthTokenRepository::class,
        ];
        $services = [
            \app\services\request\contract\RequestCreateServiceContract::class => \app\services\request\RequestCreateService::class,
            \app\services\request\contract\RequestFilteredServiceContract::class => \app\services\request\RequestFilteredService::class,
            \app\services\request\contract\RequestResolveServiceContract::class => \app\services\request\RequestResolveService::class,
            \app\services\request\contract\RequestResolvedSendMailServiceContract::class => \app\services\request\RequestResolvedSendMailService::class,
            \app\services\auth\contracts\AuthLoginServiceContract::class => \app\services\auth\AuthLoginService::class,
        ];

        $container = Yii::$container;

        foreach ($repositories as $contract => $definition) {
            $container->set($contract, [
                'class' => $definition,
            ]);
        }
        foreach ($services as $contract => $definition) {
            $container->set($contract, [
                'class' => $definition,
            ]);
        }
    }
}