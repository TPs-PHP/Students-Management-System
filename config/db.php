<?php

require_once 'config.php';

class ConnexionDB
{
    private $pdo;

    private function __construct()
    {
        $charset = 'utf8mb4';
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            // Establish the connection and assign to the $pdo
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (\PDOException $e) {
            // If the connection fails, throw an exception
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    public function getConnection()
    {
        if (!isset($this->pdo)) {
            // If the connection is not established, create a new instance
            $this->pdo = new self();
        }
        return $this->pdo;
    }
}
