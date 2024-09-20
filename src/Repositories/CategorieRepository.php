<?php

namespace src\Repositories;

use PDO;
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
        $sql = "SELECT Id_Categorie, type FROM categorie;";
        $statement = $this->DB->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
