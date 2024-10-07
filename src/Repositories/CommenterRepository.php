<?php

namespace src\Repositories;

use PDO;
use src\Models\Database;
use src\Models\Commenter;

class CommenterRepository
{
    private $DB;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();

        require_once __DIR__ . '/../../config.php';
    }

    public function newCommentaire(Commenter $commentaire)
    {

        $sql = "INSERT INTO commenter (Id_Article, Id_Utilisateur, message, date_commentaire, valide) 
                VALUES (:id_article, :id_utilisateur, :message, :date_commentaire, 1);";

        $statement = $this->DB->prepare($sql);

        $statement->execute([
            ':id_article'            => $commentaire->getIdArticle(),
            ':id_utilisateur'        => $commentaire->getIdUtilisateur(),
            ':message'               => $commentaire->getMessage(),
            ':date_commentaire'      => $commentaire->getDateCommentaire()->format('Y-m-d H:i:s')
        ]);

        $idArticle = $this->DB->lastInsertId();
        $commentaire->setIdArticle($idArticle);

        return $commentaire;
    }

    public function getAllCommentaires()
    {
        $sql = "SELECT * FROM commenter;";
        return  $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Commenter::class);
    }

    public function getCommentairesByArticleId($Id_Article)
    {
        $sql = "SELECT * FROM commenter WHERE Id_Article = :id_article";
        $statement = $this->DB->prepare($sql);
        $statement->execute([':id_article' => $Id_Article]);
        $statement->setFetchMode(PDO::FETCH_CLASS, Commenter::class);
        $commentaire = $statement->fetchAll();

        return $commentaire;
    }

}
