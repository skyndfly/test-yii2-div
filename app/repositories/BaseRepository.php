<?php

namespace app\repositories;

use Yii;
use yii\db\Command;
use yii\db\Query;

abstract class BaseRepository
{
    protected function getCommand(): Command
    {
        return Yii::$app->getDb()->createCommand();
    }
    protected function getQuery(): Query
    {
        return new Query();
    }
}