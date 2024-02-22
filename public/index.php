<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\IndexController;
use App\Controller\UserController;
use App\Controller\AssetController;
use App\Controller\AuthenticationController;
use App\Controller\EventController;
use App\Routing\Exception\RouteNotFoundException;
use App\Routing\Route;
use App\Routing\Router;
use App\Database\DBConnector; // Importez la classe DBConnector

session_start();
// $_SESSION['logged'] = false;

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

    // Login et Register
    ->addRoute(
        new Route('/register', 'uregister', 'GET', AuthenticationController::class, 'register')
    )
    ->addRoute(
        new Route('/registered', 'uregistered', 'POST', AuthenticationController::class, 'registered')
    )
    ->addRoute(
        new Route('/confirmation/{id}', 'confirmation', 'GET', AuthenticationController::class, 'confirmation')
    )
    ->addRoute(
        new Route('/login', 'login', 'GET', AuthenticationController::class, 'login')
    )

    // Nous contacter
   ->addRoute(
        new Route('/checklogs', 'checklogs', 'POST', AuthenticationController::class, 'checklogs')
    )
    ->addRoute(
        new Route('/contact', 'contact', 'GET', IndexController::class, 'contact')
    )
    ->addRoute(
        new Route('/contact/send', 'send', 'POST', IndexController::class, 'send')
    )
    
    ->addRoute(
        new Route('/logout', 'logout', 'GET', AuthenticationController::class, 'logout')
    )

    // Route User
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
        new Route('/user/delete/{id}', 'delete', 'GET', UserController::class, 'delete')
    )

    // Route Wishlist
    ->addRoute(
        new Route('/wishlist', 'wishlist', 'GET', UserController::class, 'wishlist')
    )
    ->addRoute(
        new Route('/wishlist/add/{eventNumber}', 'addToWishlist', 'GET', UserController::class, 'addToWishlist')
    )
    ->addRoute(
        new Route('/wishlist/delete/{eventNumber}', 'deleteFromWishlist', 'GET', UserController::class, 'removeFromWishlist')
    )

    // Route Participate
    ->addRoute(
        new Route('/event/add-participant/{id}', 'addParticipant', 'GET', EventController::class, 'addParticipant')
    )
    ->addRoute(
        new Route('/event/remove-participant/{id}', 'removeParticipant', 'GET', EventController::class, 'removeParticipant')
    )

    // Route Img
    ->addRoute(
        new Route('/img/{file}', 'images', 'GET', AssetController::class, 'images')
    )
    
    // Route Event
    ->addRoute(
        new Route('/events', 'events', 'GET', EventController::class, 'index')
    )
    ->addRoute(
        new Route('/events/prevp', 'prevp', 'GET', EventController::class, 'prevp')
    )
    ->addRoute(
        new Route('/events/nextp', 'nextp', 'GET', EventController::class, 'nextp')
    )
    ->addRoute(
        new Route('/event/create', 'create', 'GET', EventController::class, 'create')
    )
    ->addRoute(
        new Route('/event/register', 'register', 'POST', EventController::class, 'register')
    )
    ->addRoute(
        new Route('/event/edit/{id}', 'edit', 'GET', EventController::class, 'edit')
    )
    ->addRoute(
        new Route('/event/update/{id}', 'update', 'POST', EventController::class, 'update')
    )
    ->addRoute(
        new Route('/event/delete/{id}', 'delete', 'GET', EventController::class, 'delete')
    )
    ->addRoute(
        new Route('/profil', 'profil', 'GET', UserController::class, 'profil')
    )
    ->addRoute(
        new Route('/profil/update/{id}', 'update', 'POST', UserController::class, 'profilUpdate')
    )
    ->addRoute(
        new Route('/profil/delete/{id}', 'delete', 'GET', UserController::class, 'profilDelete')
    );

    
[
    'REQUEST_URI'    => $uri,
    'REQUEST_METHOD' => $httpMethod
] = $_SERVER;
// var_dump($_SERVER);
$uri = explode('?', $uri)[0];
try {
    echo $router->execute($uri, $httpMethod);
} catch (RouteNotFoundException $e) {
    http_response_code(404);
    echo "Page non trouvée". $e->getMessage();
} catch (Exception $e) {
    http_response_code(500);
    echo "Erreur interne : " . $e->getMessage();
}
