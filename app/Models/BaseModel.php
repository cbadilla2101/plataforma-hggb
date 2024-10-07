<?php

abstract class BaseModel
{
    protected const TABLE_NAME = '';
    protected const ATTRIBUTE_PREFIX = '';

    protected static $db;

    protected $atributos = [];
    protected $rellenables = [];
    protected $protegidos = [];

    /**
     * Constructor del modelo base, inicializa la conexión a la base de datos.
     *
     * @param array $data Los datos del modelo.
     */
    public function __construct($data = [])
    {
        static::inicializarDB();

        foreach ($data as $atributo => $valor) {
            if (in_array($atributo, $this->rellenables) || in_array($atributo, $this->protegidos)) {
                $this->atributos[$atributo] = $valor;
            }
        }
    }

    /**
     * Inicializa la conexión a la base de datos si aún no ha sido establecida.
     *
     * @return void
     */
    protected static function inicializarDB()
    {
        if (!isset(static::$db)) static::$db = DB::getConnection();
    }

    /**
     * Crear un nuevo registro en la base de datos.
     *
     * @return bool
     */
    public function crear(): bool
    {
        $columns = array_keys($this->atributos);
        $columnList = implode(', ', $columns);

		$placeholders = array_map(function($col) { return ':' . $col; }, $columns);
        $placeholderList = implode(', ', $placeholders);

        $stmt = static::$db->prepare("INSERT INTO " . static::TABLE_NAME . " ({$columnList}) VALUES ({$placeholderList})");

        return $stmt->execute($this->atributos);
    }

    /**
     * Actualizar el registro en la base de datos.
     *
     * @return bool
     */
    public function actualizar(): bool
    {
        $setClause = implode(', ', array_map(function($col) { return "$col = :$col"; }, array_keys($this->atributos)));

        $idField = static::ATTRIBUTE_PREFIX . '_id';

        $stmt = static::$db->prepare("UPDATE " . static::TABLE_NAME . " SET $setClause WHERE $idField = :$idField");

        return $stmt->execute($this->atributos);
    }

    /**
     * Eliminar el registro de la base de datos.
     *
     * @return bool
     */
    public function eliminar(): bool
    {
        $idField = static::ATTRIBUTE_PREFIX . '_id';

        $stmt = static::$db->prepare("DELETE FROM " . static::TABLE_NAME . " WHERE $idField = :$idField");

        return $stmt->execute([$idField => $this->atributos[$idField]]);
    }

    /**
     * Obtener un registro por su ID.
     *
     * @param int $id El ID del registro.
     * @return static|null
     */
    public static function obtenerPorId($id): ?self
    {
        static::inicializarDB();

        $idField = static::ATTRIBUTE_PREFIX . '_id';

        $stmt = static::$db->prepare("SELECT * FROM " . static::TABLE_NAME . " WHERE $idField = :$idField");
        $stmt->execute([$idField => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        return new static($data);
    }

    /**
     * Obtener todos los registros.
     *
     * @return array Un array de instancias del modelo.
     */
    public static function obtenerTodos(): array
    {
        static::inicializarDB();

        $stmt = static::$db->query("SELECT * FROM " . static::TABLE_NAME);

        $items = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) $items[] = new static($row);

        return $items;
    }

    /**
     * Getter dinámico para acceder a los datos.
     *
     * @param string $key La clave del dato.
     * @return mixed
     */
    public function __get($key)
    {
        return $this->atributos[$key] ?? null;
    }

    /**
     * Setter dinámico para modificar los datos.
     *
     * @param string $key La clave del dato.
     * @param mixed $value El valor a asignar.
     * @return void
     */
    public function __set($key, $value): void
    {
        if (in_array($key, $this->rellenables)) $this->atributos[$key] = $value;
    }
}
