<?php

namespace src\Repositories;

use PDO;
use src\Models\Article;
use src\Models\Humain;
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

    public function newArticle(Article $article): Article
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

    public function newArticleHumain(Article $article): Article
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
                    Id_Categorie = :Id_Categorie, 
                    Id_Utilisateur = :Id_Utilisateur 
                WHERE Id_Article = :Id_Article;";

        $statement = $this->DB->prepare($sql);

        $success = $statement->execute([
            ':Id_Article'           => $article->getIdArticle(),
            ':titre'                => $article->getTitre(),
            ':texte'                => $article->getTexte(),
            ':date'                 => $article->getDate()->format('Y-m-d H:i:s'),
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
        $article = $statement->fetch();
        return $article;
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

    public function findArticleByCategorie($Id_Categorie)
    {
        $sql = "SELECT * FROM article WHERE Id_Categorie = :Id_Categorie";
        $statement = $this->DB->prepare($sql);
        $statement->execute([':Id_Categorie' => $Id_Categorie]);
        $statement->setFetchMode(PDO::FETCH_CLASS, Article::class);
        $article = $statement->fetchAll();

        return $article;
    }

    public function getArticlesByCategoriePersonnage($Id_Categorie = 3)
    {
        $sql = "SELECT * FROM article WHERE Id_Categorie = :Id_Categorie";

        $statement = $this->DB->prepare($sql);
        $statement->execute([':Id_Categorie' => $Id_Categorie]);

        return $statement->fetchAll(PDO::FETCH_CLASS, Article::class);
    }


    public function getArticlesHumain($Id_Humain)
    {
        $sql = "SELECT h.Id_Humain,
                   h.prenom,
                   h.nom,
                   h.age,
                   h.anniversaire,
                   h.taille,
                   h.affiliation,
                   a.Id_Article,
                   a.titre AS titre_article,
                   a.texte,
                   a.date AS date_article,
                   a.image
            FROM Article a
            LEFT JOIN Humain h ON a.Id_Article = h.Id_Article
            WHERE h.Id_Humain = :Id_Humain
            ORDER BY h.nom, h.prenom;";

        $statement = $this->DB->prepare($sql);
        $statement->execute([':Id_Humain' => $Id_Humain]);

        return $statement->fetchAll(PDO::FETCH_CLASS, Article::class);
    }

    public function getAllArticlesHumain()
    {
        $sql = "SELECT h.Id_Humain,
                   h.prenom,
                   h.nom,
                   h.age,
                   h.anniversaire,
                   h.taille,
                   h.affiliation,
                   a.Id_Article,
                   a.titre AS titre,
                   a.texte,
                   a.date AS date,
                   a.image
            FROM Article a
            INNER JOIN Humain h ON a.Id_Article = h.Id_Article
            ORDER BY h.nom, h.prenom;";

        $statement = $this->DB->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, Article::class);
    }
}
