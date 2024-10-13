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

    public function newCategorie(Categorie $categorie)
    {
        $sql = "INSERT INTO categorie (type, image) 
                VALUES (:type, :image);";

        $statement = $this->DB->prepare($sql);

        $statement->execute([
            ':type'                => $categorie->getType(),
            ':image'               => $categorie->getImage(),
        ]);

        $IdCategorie = $this->DB->lastInsertId();
        $categorie->setIdCategorie($IdCategorie);

        return $categorie;
    }

    public function getCategorieById($Id_Categorie)
    {
        $sql = "SELECT * FROM categorie WHERE Id_Categorie = :Id_Categorie";
        $statement = $this->DB->prepare($sql);
        $statement->execute([':Id_Categorie' => $Id_Categorie]);
        $statement->setFetchMode(PDO::FETCH_CLASS, Categorie::class);
        $categorie = $statement->fetch();
        return $categorie;
    }

    public function getCategorie()
    {
        $sql = "SELECT Id_Categorie, type FROM categorie;";
        return  $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Categorie::class);
    }

    public function getCategorieByType($type)
    {
        $sql = "SELECT * FROM categorie WHERE type = :type;";
        $statement = $this->DB->prepare($sql);
        $statement->execute([':type' => $type]);
        $statement->setFetchMode(PDO::FETCH_CLASS, Categorie::class);
        $categorie = $statement->fetch();
        return $categorie;
    }

    public function updateCategorie(Categorie $categorie)
    {
        $sql = "UPDATE categorie 
                SET type = :type, 
                    image = :image
                WHERE Id_Categorie = :Id_Categorie;";

        $statement = $this->DB->prepare($sql);

        $success = $statement->execute([
            ':Id_Categorie'           => $categorie->getIdCategorie(),
            ':type'                   => $categorie->getType(),
            ':image'                  => $categorie->getImage()
        ]);

        return $success;
    }

    public function deleteCategorie($Id_Categorie): bool
    {
        $sql = "DELETE FROM article WHERE Id_Categorie = :Id_Categorie;
                DELETE FROM categorie WHERE Id_Categorie = :Id_Categorie";

        $statement = $this->DB->prepare($sql);

        return $statement->execute([':Id_Categorie' => $Id_Categorie]);
    }


}
