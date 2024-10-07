<?php

class Sesion extends BaseModel
{
    protected const TABLE_NAME = 'tron_sesion';
    protected const ATTRIBUTE_PREFIX = 'ses';

    protected $rellenables = [
        'us_id',
        'ses_time',
        'ses_ip',
    ];

    protected $protegidos = ['ses_id'];

    /**
     * Obtener una sesión por ID de usuario.
     *
     * @param int $usuarioId
     * @return Sesion|null
     */
    public static function obtenerPorUsuarioId($usuarioId): ?Sesion
    {
        static::inicializarDB();

        $stmt = self::$db->prepare("SELECT * FROM " . self::TABLE_NAME . " WHERE us_id = :us_id");
        $stmt->execute(['us_id' => $usuarioId]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        return new Sesion($data);
    }
}
