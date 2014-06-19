<?php

use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(
    new Silex\Provider\SwiftmailerServiceProvider(),
    ['swiftmailer.options' => $app['swiftmailer.options']]
);

$app->register(new DoctrineServiceProvider, array(
    "db.options" => $app['app.db.options'],
));

$app["orm.proxies_dir"] = __DIR__.'/../app/cache/doctrine/proxies/';
$app->register(new DoctrineOrmServiceProvider, array(
    "orm.em.options" => array(
        "mappings" => array(
            array(
                "type" => "annotation",
                "use_simple_annotation_reader"=> false,
                "namespace" => $app['app.entity.namespace'],
                "path" => __DIR__.$app['app.entity.src'],
            ),
        ),
    ),
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../app/log/app.log',
));
