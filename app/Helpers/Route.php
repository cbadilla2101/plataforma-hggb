<?php

class Route
{
    private static $routes = [];

    /**
     * Registra una ruta GET.
     *
     * @param string $route La URL de la ruta.
     * @param string $controller La clase del controlador.
     * @param string $method El método en el controlador.
     * @return void
     */
    public static function get($route, $controller, $method): void
    {
        self::addRoute('GET', $route, $controller, $method);
    }

    /**
     * Registra una ruta POST.
     *
     * @param string $route La URL de la ruta.
     * @param string $controller La clase del controlador.
     * @param string $method El método en el controlador.
     * @return void
     */
    public static function post($route, $controller, $method): void
    {
        self::addRoute('POST', $route, $controller, $method);
    }

    /**
     * Registra una ruta PUT.
     *
     * @param string $route La URL de la ruta.
     * @param string $controller La clase del controlador.
     * @param string $method El método en el controlador.
     * @return void
     */
    public static function put($route, $controller, $method): void
    {
        self::addRoute('PUT', $route, $controller, $method);
    }

    /**
     * Registra una ruta DELETE.
     *
     * @param string $route La URL de la ruta.
     * @param string $controller La clase del controlador.
     * @param string $method El método en el controlador.
     * @return void
     */
    public static function delete($route, $controller, $method): void
    {
        self::addRoute('DELETE', $route, $controller, $method);
    }

    /**
     * Registra una ruta PATCH.
     *
     * @param string $route La URL de la ruta.
     * @param string $controller La clase del controlador.
     * @param string $method El método en el controlador.
     * @return void
     */
    public static function patch($route, $controller, $method): void
    {
        self::addRoute('PATCH', $route, $controller, $method);
    }

    /**
     * Añade una nueva ruta a la tabla de enrutamiento.
     *
     * @param string $method El método HTTP (GET, POST, etc.).
     * @param string $route La URL de la ruta.
     * @param string $controller La clase del controlador.
     * @param string $action El método en el controlador que maneja la petición.
     * @return void
     */
    private static function addRoute($method, $route, $controller, $action): void
    {
        self::$routes[] = [
            'method' => $method,
            'route' => $route,
            'controller' => $controller,
            'action' => $action
        ];
    }

    /**
     * Despacha la petición actual a la ruta correspondiente.
     *
     * Compara la URI y el método de la petición con las rutas registradas
     * y llama al controlador y acción adecuados.
     *
     * @return void
     */
    public static function dispatch(): void
    {
        $requestUri = rtrim($_SERVER['REQUEST_URI'], '/');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            if ($route['method'] === $requestMethod) {
                $pattern = preg_replace('/\{(\w+)\}/', '([\w\-]+)', rtrim($route['route'], '/'));

                if (preg_match('#^' . $pattern . '$#', $requestUri, $matches)) {
                    array_shift($matches);
                    $controller = new $route['controller'];
                    call_user_func_array([$controller, $route['action']], $matches);

                    return;
                }
            }
        }

        self::render404();
    }

    /**
     * Renderiza la vista de error 404.
     *
     * @return void
     */
    public static function render404(): void
    {
        http_response_code(404);

        include __DIR__ . '/../Views/404.php';
    }
}
