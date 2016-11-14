<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname='.$params['db_name'],
    'username' => $params['db_username'],
    'password' => $params['db_password'],
    'charset' => 'utf8',
];