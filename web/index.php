<?php

use Cekurte\Environment\Environment;
use yii\web\Application;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/..');
$dotenv->load();

defined('YII_DEBUG') or define('YII_DEBUG', Environment::get('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', Environment::get('YII_ENV'));

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new Application($config))->run();
