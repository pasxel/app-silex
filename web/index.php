<?php

require_once __DIR__.'/../bootstrap.php';

$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../app/config/prod.php';
require __DIR__.'/../src/registers.php';
require __DIR__.'/../src/controllers.php';
$app->run();