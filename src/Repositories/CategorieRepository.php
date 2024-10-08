<?php

namespace src\Repositories;

use PDO;
use src\Models\Categorie;
use src\Models\Database;

class CategorieRepository
{
    private $DB;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();

        require_once __DIR__ . '/../../config.php';
    }

    public function getAllCategories()
    {
        $sql = "SELECT * FROM categorie;";
        return  $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Categorie::class);
    }

    public function getCategorieById()
    {
        $sql = "SELECT Id_Categorie, type FROM categorie;";
        return  $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Categorie::class);

    }
    
}
