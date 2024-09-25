<?php

namespace src\Repositories;

use PDO;
use src\Models\Article;
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

    public function createArticle(Article $article): Article
    {
        $sql = "INSERT INTO article (titre, texte, date, image, Id_Categorie, Id_Utilisateur) 
                VALUES (:titre, :texte, :date, :image, :Id_categorie, :Id_Utilisateur);";

        $statement = $this->DB->prepare($sql);

        $statement->execute([
            ':titre'               => $article->getTitre(),
            ':texte'               => $article->getTexte(),
            ':date'                => $article->getDate()->format('Y-m-d H:i:s'),
            ':image'               => $article->getImage(),
            ':Id_categorie'        => $article->getIdCategorie(),
            ':Id_Utilisateur'      => $article->getIdUtilisateur()
        ]);

        $idArticle = $this->DB->lastInsertId();
        $article->setIdArticle($idArticle);

        return $article;
    }

    public function getAllArticles()
    {
        $sql = "SELECT * FROM article;";
        return  $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Article::class);
    }

    public function updateArticle(Article $article)
    {
        $sql = "UPDATE article 
                SET titre = :titre, 
                    texte = :texte, 
                    date = :date, 
                    image = :image, 
                    Id_Categorie = :Id_categorie, 
                    Id_Utilisateur = :Id_Utilisateur 
                WHERE Id_Article = :Id_Article;";

        $statement = $this->DB->prepare($sql);

        $success = $statement->execute([
            ':Id_Article'           => $article->getIdArticle(),
            ':titre'                => $article->getTitre(),
            ':texte'                => $article->getTexte(),
            ':date'                 => $article->getDate(),
            ':image'                => $article->getImage(),
            ':Id_Categorie'         => $article->getIdCategorie(),
            ':Id_Utilisateur'       => $article->getIdUtilisateur()
        ]);

        return $success;
    }

    public function getArticleById($Id_Article)
    {
        $sql = "SELECT * FROM article WHERE Id_Article = :Id_Article";
        $statement = $this->DB->prepare($sql);
        $statement->execute([':Id_Article' => $Id_Article]);
        $statement->setFetchMode(PDO::FETCH_CLASS, Article::class);
        return $statement->fetch();
    }

    public function deleteArticle($Id_Article): bool
    {
      $sql = "DELETE FROM commenter WHERE Id_Article = :Id_Article;
              DELETE FROM humain WHERE Id_Article = :Id_Article;
              DELETE FROM titan WHERE Id_Article = :Id_Article;
              DELETE FROM likes WHERE Id_Article = :Id_Article;
              DELETE FROM article WHERE Id_Article = :Id_Article";
  
      $statement = $this->DB->prepare($sql);
  
      return $statement->execute([':Id_Article' => $Id_Article]);
    }
}
