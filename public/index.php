<?php
require __DIR__ . '/../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: API-Key, Authorization");

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$routes = scandir("../src/Route");
foreach(array_splice($routes, 2) as $file_name)
{
    require "../src/Route/$file_name";
}

$app->run();