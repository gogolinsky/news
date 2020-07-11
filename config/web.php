<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'name' => 'Свежие новости',
	'sourceLanguage' => 'en-US',
	'language' => 'ru-RU',
    'bootstrap' => [
    	'log',
	    'category',
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
	'modules' => [
		'category' => \app\modules\category\Module::class,
		'news' => \app\modules\news\Module::class,
	],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'ij0FexE0s-xrhKL3rw2qTP5bRdyS33KT',
        ],
        'cache' => \yii\caching\FileCache::class,
        'user' => [
	        'identityClass' => \app\models\User::class,
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            	//
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = \yii\debug\Module::class;
}

return $config;
