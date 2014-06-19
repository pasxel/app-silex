<?php

// include the prod configuration
require __DIR__.'/dev.php';

$app['session.test'] = true;

$app['app.db.options'] = $app['app.testdb.options'];