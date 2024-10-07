<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Models/DB.php';

class Auth
{
    /**
     * Intenta autenticar al usuario con el email y la contraseña proporcionados.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public static function intentar($email, $password): bool
    {
        $usuario = Usuario::obtenerPorEmail($email);

        if ($usuario && password_verify($password, $usuario->us_password)) {
            self::iniciarSesion($usuario);

            return true;
        }

        return false;
    }

    /**
     * Inicia la sesión para el usuario autenticado.
     *
     * @param Usuario $usuario El objeto usuario.
     * @return void
     */
    public static function iniciarSesion(Usuario $usuario): void
    {
        session_start();

        $sesion = new Sesion([
            'us_id' => $usuario->us_id,
            'ses_time' => date('Y-m-d H:i:s'),
            'ses_ip' => $_SERVER['REMOTE_ADDR']
        ]);

        $sesion->crear();

        $_SESSION['us_id'] = $usuario->us_id;
        setcookie('us_id', $usuario->us_id, time() + 3600, "/");
    }

    /**
     * Verifica si el usuario está autenticado.
     *
     * @return bool
     */
    public static function estaAutenticado(): bool
    {
        if (isset($_SESSION['us_id'])) {
            return self::verificarSesion($_SESSION['us_id']);
        } elseif (isset($_COOKIE['us_id'])) {
            return self::verificarSesion($_COOKIE['us_id']);
        }

        return false;
    }

    /**
     * Verifica si una sesión es válida por usuario ID.
     *
     * @param int $usuarioId El ID del usuario.
     * @return bool
     */
    private static function verificarSesion($usuarioId): bool
    {
        $sesion = Sesion::obtenerPorUsuarioId($usuarioId);

        return $sesion && $sesion->ses_ip === $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Cierra la sesión del usuario actual.
     *
     * @return void
     */
    public static function cerrarSesion(): void
    {
        session_start();

        if (isset($_SESSION['us_id'])) {
            unset($_SESSION['us_id']);
            setcookie('us_id', '', time() - 3600, "/");
        }
    }

    /**
     * Obtiene el usuario autenticado.
     *
     * @return Usuario|null
     */
    public static function usuarioAutenticado(): ?Usuario
    {
        if (!self::estaAutenticado()) return null;

        return Usuario::obtenerPorId($_SESSION['us_id'] ?? $_COOKIE['us_id']);
    }

    /**
     * Registra un nuevo usuario en el sistema.
     *
     * @param array $datos Los datos del nuevo usuario.
     * @return bool
     */
    public static function registro(array $datos): bool
    {
        $usuario = new Usuario($datos);
        $usuario->us_password = password_hash($datos['password'], PASSWORD_BCRYPT);

        return $usuario->crear();
    }
}
