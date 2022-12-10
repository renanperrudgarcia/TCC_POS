<?php

return [
    'externalApi' => [],
    'templatePresentation' => [
        'viewsPath' => __DIR__ . '/../views',
        'cachePath' => __DIR__ . '/../runtime/cache',
        'enableCache' => $_ENV['APP_ENV'] === 'production'
    ],
    'database' => [
        'host' => $_ENV['DB_HOST_POSTGRES'],
        'port' => $_ENV['DB_PORT_POSTGRES'],
        'username' => $_ENV['DB_USERNAME_POSTGRES'],
        'password' => $_ENV['DB_PASSWORD_POSTGRES'],
        'dbname' => $_ENV['DB_DATABASE'],
        'charset' => $_ENV['DB_CHARSET']
    ],

    'jwt' => [
        'key' => $_ENV['JWT_KEY'],
        'algorithm' => $_ENV['JWT_ALGORITHM']
    ]
];
