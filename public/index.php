<?php

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/src/Controllers/LoanController.php';

use Rollbar\RollbarMiddleware;
use Slim\Factory\AppFactory;
use App\Controllers\LoanController;
use Controllers\MyController;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Middleware\BodyParsingMiddleware;
use Dotenv\Dotenv;
use Rollbar\Rollbar;
use Rollbar\Payload\Level;
use Slim\Psr7\Factory\ServerRequestFactory;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$config = [
    'rollbar' => [
        'access_token' => $_ENV['ROLLBAR_ACCESS_TOKEN'],
        'environment' => 'production',
    ],
];
$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);
$rollbarConfig = Rollbar::init($config['rollbar']);

// Настройте базу данных
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/../database/sqlite.db',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();



// Определение маршрутов

$app->get('/', LoanController::class . ':main');
$app->get('/loans', LoanController::class . ':index');
$app->get('/loans/{id}', LoanController::class . ':show');
$app->post('/loans', LoanController::class . ':store');
$app->put('/loans/{id}', LoanController::class . ':update');
$app->delete('/loans/{id}', LoanController::class . ':destroy');

$app->run();
