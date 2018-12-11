<?php

use yii\helpers\ArrayHelper;

$db = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=db_name',
    'username' => 'user_name',
    'password' => 'password',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

// если есть локальные настройки - заменяем
if (file_exists(__DIR__ . '/.local/db.php')) {
    $db = ArrayHelper::merge($db, require __DIR__ . '/.local/db.php');
}

return $db;
