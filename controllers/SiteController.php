<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => ErrorAction::class,
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
