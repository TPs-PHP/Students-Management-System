<?php

require_once 'config.php';

class ConnexionDB
{
    private static $bdd = null;

    private function __construct()
    {
        $charset = 'utf8mb4';
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            self::$bdd = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (\PDOException $e) {
            // If the connection fails, throw an exception
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    public static function getInstance()
    {
        // Check if the instance already exists
        if (!self::$bdd) {
            // If not, create a new instance
            new ConnexionDB();
        }
        return self::$bdd;
    }
}
