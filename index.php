<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Views\PhpRenderer;
use Src\Controllers\HomeController;
use Src\Controllers\LoginController;
use Src\Controllers\NoteController;
use Src\Controllers\RegisterController;
use Src\Middleware\AuthMiddleware;

session_start();

require __DIR__ . '/vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

$container->set(PhpRenderer::class, function () {
    return new PhpRenderer(__DIR__ . '/templates');
});

ORM::configure('mysql:host=database;dbname=docker;charset=utf8mb4');
ORM::configure('username', 'root');
ORM::configure('password', 'tiger');

$app->get('/', [HomeController::class, 'index']);
$app->get('/login', [LoginController::class, 'loginPage']);
$app->get('/register', [RegisterController::class, 'registerPage']);
$app->post('/auth/login', [LoginController::class, 'login']);
$app->post('/auth/register', [RegisterController::class, 'register']);

$app->group('/', function () use ($app) {
    $app->get('/notes', [NoteController::class, 'index']);
    $app->get('/notes/create', [NoteController::class, 'create']);
    $app->post('/notes/create', [NoteController::class, 'store']);
    $app->get('/notes/{id}/edit', [NoteController::class, 'edit']);
    $app->post('/notes/{id}/edit', [NoteController::class, 'update']);
    $app->get('/notes/{id}/delete', [NoteController::class, 'delete']);
    $app->get('/logout', [LoginController::class, 'logout']);
})->add(new AuthMiddleware($container->get(ResponseFactory::class)));

$app->run();
