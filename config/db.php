<?php

return [
    'class' => 'yii\db\Connection',
    /*'dsn' => 'mysql:host=localhost;dbname=ldp',
    'username' => 'superhakam',
    'password' => 'superhakam',
    'charset' => 'utf8',*/
    'dsn' => 'pgsql:host=localhost;port=5432;dbname=ldp_dw',
    'username' => 'superhakam',
    'password' => 'superhakam',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
