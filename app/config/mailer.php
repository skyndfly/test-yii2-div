<?php
return [
    'class' => yii\symfonymailer\Mailer::class,
    'viewPath' => '@app/mail',
    'useFileTransport' => true,
    'messageConfig' => [
        'from' => ['noreply@example.com' => 'App Bot'],
    ],
];