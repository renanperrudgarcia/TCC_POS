<?php

use App\Shared\Infra\Drivers\DoctrineDriver;
use App\Shared\Infra\TwigEngine;
use DI\Container;
use DI\ContainerBuilder;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions($injections);

$container = $containerBuilder->build();

$container->set('config', function () {
    return require __DIR__ . DS . 'config.php';
});

$container->set('database', function (Container $container) {
    $dbConfig = $container->get('config')['database'];

    $connectionParams = array(
        'dbname' => $dbConfig['dbname'],
        'user' => $dbConfig['username'],
        'password' => $dbConfig['password'],
        'host' => $dbConfig['host'],
        'port' => $dbConfig['port'],
        'charset' => $dbConfig['charset'],
        'driver' => 'pdo_pgsql',
    );

    return new DoctrineDriver($connectionParams);
});

$container->set('templatePresentation', function (Container $container) {
    $config = $container->get('config')['templatePresentation'];

    $loader = new FilesystemLoader($config['viewsPath']);

    $twig = new Environment($loader, [
        'cache' => $config['enableCache'] === true ? $config['cachePath'] : false
    ]);

    return new TwigEngine($twig, $config);
});
