<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;

class UserController extends Controller
{
    public function actionCreate($username, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->generateAuthKey();

        if ($user->save()) {
            echo "User created successfully.\n";
        } else {
            echo "Failed to create user.\n";
            print_r($user->errors);
        }
    }
}