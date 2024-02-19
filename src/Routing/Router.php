<?php

namespace App\Routing;

use App\Routing\Exception\RouteNotFoundException;

class Router
{
    /** @var Route[] */
    private array $routes = [];

    public function addRoute(Route $route): self
    {
        // TODO: Gestion doublon
        $this->routes[] = $route;
        return $this;
    }

    public function getRoute(string $uri, string $httpMethod): ?Route
    {
        foreach ($this->routes as $savedRoute) {
            if ($savedRoute->getUri() === $uri && $savedRoute->getHttpMethod() === $httpMethod) {
                return $savedRoute;
            }
        }

        return null;
    }

    /**
     * Executes a route against given URI and HTTP method
     *
     * @param string $uri
     * @param string $httpMethod
     * @return void
     * @throws RouteNotFoundException
     */
    public function execute(string $uri, string $httpMethod): string
    {
        $route = $this->getRoute($uri, $httpMethod);

        if ($route === null) {
            throw new RouteNotFoundException();
        }

        $controllerClass = $route->getControllerClass();
        $method = $route->getController();
        $controllerInstance = new $controllerClass();
        return $controllerInstance->$method();
    }
}
