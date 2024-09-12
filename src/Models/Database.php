<?php

namespace src\Models;

use PDO;
use PDOException;

final class Database
{
    private $DB;
    private $config;

    public function __construct()
    {
        $this->config = __DIR__ . '/../../config.php';
        require_once $this->config;
        $this->connexionDB();
    }

    private function connexionDB()
    {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            $this->DB = new PDO($dsn, DB_USER, DB_PWD);
        } catch (PDOException $error) {
            echo 'Connexion échouée : ' . $error->getMessage();
        }
    }
    public function getDB(): mixed
    {
        return $this->DB;
    }
}
