<?php
class Router
{
    private string $url;
    private array $routes = [];

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function get(string $path, string $controller)
    {
        $this->routes['GET'][$path] = $controller;
    }

    public function post(string $path, string $controller)
    {
        $this->routes['POST'][$path] = $controller;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($this->url, PHP_URL_PATH);

        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            echo "404 Pagina niet gevonden";
            return;
        }

        [$controllerName, $action] = explode('@', $this->routes[$method][$path]);
        $controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            http_response_code(500);
            echo "Controllerbestand niet gevonden: $controllerName";
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            http_response_code(500);
            echo "Controllerklasse niet gevonden: $controllerName";
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            http_response_code(500);
            echo "Actie niet gevonden: $action";
            return;
        }

        $controller->$action();
    }
}
