<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\IndexController;
use App\Controller\ProductController;
use App\Controller\UserController;
use App\Controller\AssetController;
use App\Controller\AuthenticationController;
use App\Routing\Exception\RouteNotFoundException;
use App\Routing\Route;
use App\Routing\Router;
use App\Database\DBConnector; // Importez la classe DBConnector

try {
    // Utilisez la classe DBConnector pour établir la connexion à la base de données
    $dbConnector = new DBConnector();
    $pdo = $dbConnector->getPDO();
} catch (PDOException) {
    echo "Erreur lors de la connexion à la base de données";
    exit;
}


$router = new Router();

$router
    ->addRoute(
        new Route('/', 'home', 'GET', IndexController::class, 'home')
    )
    ->addRoute(
        new Route('/register', 'uregister', 'GET', AuthenticationController::class, 'register')
    )
    ->addRoute(
        new Route('/registered', 'uregistered', 'POST', AuthenticationController::class, 'registered')
    )
    ->addRoute(
        new Route('/login', 'login', 'GET', IndexController::class, 'login')
    )
    ->addRoute(
        new Route('/contact', 'contact', 'GET', IndexController::class, 'contact')
    )
    ->addRoute(
        new Route('/products', 'products_list', 'GET', ProductController::class, 'list')
    )
    ->addRoute(
        new Route('/users', 'index', 'GET', UserController::class, 'index')
    )
    ->addRoute(
        new Route('/user/create', 'create', 'GET', UserController::class, 'create')
    )
    ->addRoute(
        new Route('/user/register', 'register', 'POST', UserController::class, 'register')
    )
    ->addRoute(
        new Route('/user/edit/{id}', 'edit', 'GET', UserController::class, 'edit')
    )
    ->addRoute(
        new Route('/user/update/{id}', 'update', 'POST', UserController::class, 'update')
    )
    ->addRoute(
        new Route('/css/{file}', 'styles', 'GET', AssetController::class, 'styles')
    );

[
    'REQUEST_URI'    => $uri,
    'REQUEST_METHOD' => $httpMethod
] = $_SERVER;

try {
    echo $router->execute($uri, $httpMethod);
} catch (RouteNotFoundException) {
    http_response_code(404);
    echo "Page non trouvée";
} catch (Exception $e) {
    http_response_code(500);
    echo "Erreur interne : " . $e->getMessage();
}
