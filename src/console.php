<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\HelperSet;

$app = require __DIR__.'/app.php';
require __DIR__.'/../app/config/prod.php';
require __DIR__.'/registers.php';

$console = new Application('Pasxel Application', '1.0');

//cache clear command
$console
    ->register('cache:clear')
    ->setDescription('Clear cache')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $cachePaths = array(
            __DIR__ . '/../app/cache/doctrine',
            __DIR__ . '/../app/cache/doctrine/proxies',
            __DIR__ . '/../app/log'
        );
        
        foreach ($cachePaths as $folderPath) {
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            } else {
                foreach (glob($folderPath.'/*') as $file) {
                    if (!is_dir($file)) {
                        unlink($file);
                    }
                }
            }
        }
        $output->writeln('Clearing the cache for prod has been completed.');
    })
;

/**
 * Doctrine
 */
$helperSet = new HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($app['orm.em']->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($app['orm.em'])
));

$console->setHelperSet($helperSet);
Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($console);

return $console;
