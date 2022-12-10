<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'postgres',
            'host' => 'localhost',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'pgsql',
            'host' => $_ENV['DB_HOST_POSTGRES'],
            'name' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME_POSTGRES'],
            'pass' => $_ENV['DB_PASSWORD_POSTGRES'],
            'port' => $_ENV['DB_PORT_POSTGRES'],
            'charset' => 'utf8',
        ],
        'testing' => [
          'adapter' => 'pgsql',
          'host' => $_ENV['DB_HOST_POSTGRES'],
          'name' => $_ENV['DB_DATABASE'],
          'user' => $_ENV['DB_USERNAME_POSTGRES'],
          'pass' => $_ENV['DB_PASSWORD_POSTGRES'],
          'port' => $_ENV['DB_PORT_POSTGRES'],
          'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];