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

    public function getCategorieById($Id_categorie)
    {
        $sql = "SELECT type FROM categorie WHERE Id_Categorie = :id_categorie;";
        $statement = $this->DB->prepare($sql);
        $statement->execute([':categorie' => $Id_categorie]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllCategories()
    {
        $query = "SELECT * FROM Categorie";
        $statement = $this->DB->prepare($query);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
