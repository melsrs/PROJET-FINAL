<?php

namespace src\Repositories;

use PDO;
use src\Models\Database;

class ArticleRepository
{
    private $DB;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();

        require_once __DIR__ . '/../../config.php';
    }

    public function createArticle($titre, $texte, $date, $image, $Id_Categorie, $Id_Utilisateur)
    {
        $sql = "INSERT INTO article (titre, texte, date, image, Id_Categorie, Id_Utilisateur) 
                VALUES (:titre, :texte, :date, :image, :Id_categorie, :Id_Utilisateur);";

        $statement = $this->DB->prepare($sql);

        $success = $statement->execute([
            ':titre'               => $titre,
            ':texte'               => $texte,
            ':date'                => $date,
            ':image'               => $image,
            ':Id_categorie'        => $Id_Categorie,
            ':Id_Utilisateur'     => $Id_Utilisateur
        ]);

        return $success;
    }

}
