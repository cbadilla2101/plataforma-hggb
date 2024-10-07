<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Models/Usuario.php';

class UsuarioController extends BaseController
{
    /**
     * Muestra la lista de usuarios.
     *
     * @return void
     */
    public function index(): void
    {
        $usuarios = Usuario::obtenerTodos();

        $this->render('Usuarios/Index', [
            'title' => 'Lista de Usuarios',
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Muestra la información de un usuario.
     *
     * @param int $id El ID del usuario.
     * @return void
     */
    public function mostrar($id): void
    {
        $usuario = Usuario::obtenerPorId($id);

        if ($usuario) {
            $this->render('Usuarios/Mostrar', [
                'title' => 'Usuario #' . $usuario->us_id,
                'usuario' => $usuario,
            ]);
        } else {
            $this->render404();
        }
    }
}
