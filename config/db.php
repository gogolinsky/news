<?php

use Cekurte\Environment\Environment;

return [
	'class' => yii\db\Connection::class,
	'dsn' => 'mysql:host=' . Environment::get('DB_HOST') . ';dbname=' . Environment::get('DB_NAME'),
	'username' => Environment::get('DB_USER'),
	'password' => Environment::get('DB_PASS'),
	'charset' => 'utf8',

	'enableSchemaCache' => YII_ENV_PROD,
	'schemaCacheDuration' => 60,
	'schemaCache' => 'cache',
];