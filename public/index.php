<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR .'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

session_start();
use App\Application;
$app = new Application();
$app->run();