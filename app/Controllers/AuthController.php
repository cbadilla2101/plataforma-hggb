<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Helpers/Auth.php';

class AuthController extends BaseController
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return void
     */
    public function mostrarIniciarSesion(): void
    {
        $this->render('Auth/IniciarSesion', ['title' => 'Iniciar Sesión']);
    }

    /**
     * Maneja el intento de inicio de sesión.
     *
     * @return void
     */
    public function iniciarSesion(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (Auth::intentar($email, $password)) {
            header('Location: /');

            exit;
        }

        $this->render('Auth/IniciarSesion', [
            'title' => 'Iniciar Sesión',
            'error' => 'Credenciales incorrectas',
        ]);
    }

    /**
     * Maneja el cierre de sesión.
     *
     * @return void
     */
    public function cerrarSesion(): void
    {
        Auth::cerrarSesion();

        header('Location: /iniciar-sesion');

        exit;
    }
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return void
     */
    public function mostrarRegistro(): void
    {
        $this->render('Auth/Registro', ['title' => 'Registro']);
    }

    /**
     * Maneja el intento de inicio de sesión.
     *
     * @return void
     */
    public function registro(): void
    {
        $nombres = $_POST['nombres'] ?? null;
        $ap = $_POST['ap'] ?? null;
        $am = $_POST['am'] ?? null;
        $email = $_POST['email'] ?? null;
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        $registroExitoso = Auth::registro([
            'us_nombres' => $nombres,
            'us_ap' => $ap,
            'us_am' => $am,
            'us_email' => $email,
            'us_username' => $username,
            'us_password' => $password,
            'us_pic' => 'users/no-photo.png',
            'us_fecha' => date('Y-m-d'),
            'us_activo' => true,
            'us_existe' => true,
        ]);

        if ($registroExitoso) {
            header('Location: /iniciar-sesion');

            exit;
        }

        $this->render('Auth/Registro', [
            'title' => 'Registro',
            'error' => 'Error en el registro',
        ]);
    }
}
