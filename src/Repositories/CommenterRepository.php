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
                VALUES (:id_article, :id_utilisateur, :message, :date_commentaire, 2);";

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

    public function getCommentairesByUtilisateurId($Id_Utilisateur)
    {
        $sql = "SELECT * FROM commenter WHERE Id_Utilisateur = :Id_Utilisateur";
        $statement = $this->DB->prepare($sql);
        $statement->execute([':Id_Utilisateur' => $Id_Utilisateur]);
        $statement->setFetchMode(PDO::FETCH_CLASS, Commenter::class);
        $commentaire = $statement->fetchAll();

        return $commentaire;
    }

    public function getCommentaireByUtilisateurAndArticle($Id_Utilisateur, $Id_Article)
    {
        $sql = "SELECT * FROM commenter WHERE Id_Utilisateur = :Id_Utilisateur AND Id_Article = :Id_Article";
        $statement = $this->DB->prepare($sql);

        $statement->execute([
            ':Id_Utilisateur'   => $Id_Utilisateur,
            ':Id_Article'       => $Id_Article
        ]);

        $statement->setFetchMode(PDO::FETCH_CLASS, Commenter::class);
        $commentaire = $statement->fetch();
        return $commentaire;
    }

    public function updateCommentaire(Commenter $commentaire)
    {
        $sql = "UPDATE commenter 
                SET message = :message, 
                    date_commentaire = :date_commentaire, 
                    valide = 2
                WHERE Id_Article = :Id_Article 
                AND Id_Utilisateur = :Id_Utilisateur;";
                     
        $statement = $this->DB->prepare($sql);
    
        $success = $statement->execute([
            ':Id_Article'        => $commentaire->getIdArticle(),
            ':Id_Utilisateur'    => $commentaire->getIdUtilisateur(),
            ':message'           => $commentaire->getMessage(),
            ':date_commentaire'  => $commentaire->getDateCommentaire()->format('Y-m-d H:i:s')
        ]);
    
        return $success;
    }
    
}
