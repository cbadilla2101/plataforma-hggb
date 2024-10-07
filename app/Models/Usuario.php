<?php

require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/BaseModel.php';
require_once __DIR__ . '/Sesion.php';

class Usuario extends BaseModel
{
    protected const TABLE_NAME = 'tron_usuario';
    protected const ATTRIBUTE_PREFIX = 'us';

    protected $rellenables = [
        'us_nombres',
        'us_ap',
        'us_am',
        'us_email',
        'us_username',
        'us_password',
        'us_pic',
        'us_fecha',
        'us_activo',
        'us_existe',
    ];

    protected $protegidos = ['us_id'];

    /**
     * Obtiene la información de un usuario por su email.
     *
     * @param string $email El email del usuario.
     * @return Usuario|null El objeto del usuario si se encuentra, de lo contrario null.
     */
    public static function obtenerPorEmail($email): ?Usuario
    {
        static::inicializarDB();

        $emailField = self::ATTRIBUTE_PREFIX . '_email';

        $stmt = static::$db->prepare("SELECT * FROM " . self::TABLE_NAME . " WHERE $emailField = :$emailField");
        $stmt->execute([$emailField => $email]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        return new Usuario($data);
    }

    /**
     * Obtener la sesión asociada al usuario.
     *
     * @return Sesion|null
     */
    public function sesion(): ?Sesion
    {
        return Sesion::obtenerPorUsuarioId($this->us_id);
    }
}
