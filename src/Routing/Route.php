<?php

namespace App\Routing;

class Route
{
    public function __construct(
        private string $uri,
        private string $name,
        private string $httpMethod,
        private string $controllerClass,
        private string $controller,
        private array $parameters = []

        
    ) {
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
    public function extractParameters(string $uri): array
    {
        $pattern = $this->convertUriToRegex($this->uri);
        preg_match($pattern, $uri, $matches);

        // Vérifiez si des correspondances ont été trouvées
        return $matches ? array_slice($matches, 1) : [];
    }

    public function convertUriToRegex(string $uri): string
    {
        // Échappez les caractères spéciaux de l'URI
        $regex = preg_quote($uri, '/');

        // Remplacez les parties dynamiques de l'URI par des groupes de capture
        $regex = preg_replace('/\\\{([^\/]+)\\\}/', '(?P<$1>[^\/]+)', $regex);

        // Ajoutez des délimiteurs d'expression régulière
        $regex = '/^' . $regex . '$/';

        return $regex;
    }
}
