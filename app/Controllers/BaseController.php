<?php

class BaseController
{
    /**
     * Renderiza una vista.
     *
     * @param string $view El nombre del archivo de vista.
     * @param array $data Un array asociativo de datos a pasar a la vista.
     * @return void
     */
    protected function render($view, $data = []): void
    {
        extract($data);

        ob_start();
        include __DIR__ . "/../Views/$view.php";
        $content = ob_get_clean();

        include __DIR__ . '/../Views/Layouts/Main.php';
    }

    /**
     * Renderiza la vista de error 404.
     *
     * @return void
     */
    public function render404(): void
    {
        http_response_code(404);

        include __DIR__ . '/../Views/404.php';
    }
}
