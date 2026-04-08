<?php

class Database
{

    private string $host;
    private string $db_name;
    private string $username;
    private string $password;
    private $conn = null;

    public function __construct()
    {
        $this->host     = $_ENV['DB_HOST'] ?? '';
        $this->db_name  = $_ENV['DB_NAME'] ?? '';
        $this->username = $_ENV['DB_USER'] ?? '';
        $this->password = $_ENV['DB_PASS'] ?? '';
    }

    public function getConnection(): PDO
    {
        if ($this->conn !== null) {
            return $this->conn;
        }

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            error_log("Error fatal de BD: " . $e->getMessage());
            throw new RuntimeException("Error interno al conectar con la base de datos.");
        }

        return $this->conn;
    }
}
