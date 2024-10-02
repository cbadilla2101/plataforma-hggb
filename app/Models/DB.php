<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class DB
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        $this->connection = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Obtiene la conexión a la base de datos.
     *
     * @return PDO La conexión a la base de datos.
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new DB();
        }

        return self::$instance->connection;
    }
}
