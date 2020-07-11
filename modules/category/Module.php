<?php

namespace app\modules\category;

use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->get('urlManager')->rules[] = new GroupUrlRule([
            'rules' => [
                '/catalog' => '/category/frontend/index',
                '/catalog/tree' => '/category/frontend/tree',
                '/catalog/<id>' => '/category/frontend/view',
            ],
        ]);
    }
}