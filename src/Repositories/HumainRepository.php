<?php

namespace src\Repositories;

use PDO;
use src\Models\Article;
use src\Models\Humain;
use src\Models\Database;

class HumainRepository
{
    private $DB;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();

        require_once __DIR__ . '/../../config.php';
    }

    public function createArticleHumain(Article $article, Humain $humain): array
    {
        $this->DB->beginTransaction();

        try {

            $sqlArticle = "INSERT INTO article (titre, texte, date, image, Id_Categorie, Id_Utilisateur) 
                           VALUES (:titre, :texte, :date, :image, :Id_categorie, :Id_Utilisateur)";

            $statementArticle = $this->DB->prepare($sqlArticle);

            $statementArticle->execute([
                ':titre'               => $article->getTitre(),
                ':texte'               => $article->getTexte(),
                ':date'                => $article->getDate()->format('Y-m-d H:i:s'),
                ':image'               => $article->getImage(),
                ':Id_categorie'        => $article->getIdCategorie(),
                ':Id_Utilisateur'      => $article->getIdUtilisateur()
            ]);

            $idArticle = $this->DB->lastInsertId();
            $article->setIdArticle($idArticle);

            $sqlHumain = "INSERT INTO humain (Id_Article, prenom, nom, age, anniversaire, taille, affiliation) 
                          VALUES (:Id_Article, :prenom, :nom, :age, :anniversaire, :taille, :affiliation)";

            $statementHumain = $this->DB->prepare($sqlHumain);

            $statementHumain->execute([
                ':Id_Article'    => $idArticle,
                ':prenom'        => $humain->getPrenom(),
                ':nom'           => $humain->getNom(),
                ':age'           => $humain->getAge(),
                ':anniversaire'  => $humain->getAnniversaire(),
                ':taille'        => $humain->getTaille(),
                ':affiliation'   => $humain->getAffiliation()
            ]);

            $idHumain = $this->DB->lastInsertId();
            $humain->setIdHumain($idHumain);
            $humain->setIdArticle($idArticle);

            // Valider la transaction si aucune erreur
            $this->DB->commit();

            return ['article' => $article, 'humain' => $humain];
        } catch (\Exception $e) {
            // Annuler la transaction si erreur
            $this->DB->rollBack();
            throw $e;
        }
    }

    public function updateArticleHumain(Article $article, Humain $humain): array
    {
        $this->DB->beginTransaction();

        try {
            $sqlArticle = "UPDATE article 
                       SET titre = :titre, 
                           texte = :texte, 
                           date = :date, 
                           image = :image, 
                           Id_Categorie = :Id_Categorie, 
                           Id_Utilisateur = :Id_Utilisateur
                       WHERE Id_Article = :Id_Article";

            $statementArticle = $this->DB->prepare($sqlArticle);

            $statementArticle->execute([
                ':titre'            => $article->getTitre(),
                ':texte'            => $article->getTexte(),
                ':date'             => $article->getDate()->format('Y-m-d H:i:s'),
                ':image'            => $article->getImage(),
                ':Id_Categorie'     => $article->getIdCategorie(),
                ':Id_Utilisateur'   => $article->getIdUtilisateur(),
                ':Id_Article'       => $article->getIdArticle()
            ]);

            $sqlHumain = "UPDATE humain 
                      SET prenom = :prenom, 
                          nom = :nom, 
                          age = :age, 
                          anniversaire = :anniversaire, 
                          taille = :taille, 
                          affiliation = :affiliation
                          
                      WHERE Id_Humain = :Id_Humain";

            $statementHumain = $this->DB->prepare($sqlHumain);

            $statementHumain->execute([
                ':prenom'        => $humain->getPrenom(),
                ':nom'           => $humain->getNom(),
                ':age'           => $humain->getAge(),
                ':anniversaire'  => $humain->getAnniversaire(),
                ':taille'        => $humain->getTaille(),
                ':affiliation'   => $humain->getAffiliation(),
                
                ':Id_Humain'      => $humain->getIdHumain()
            ]);

            $this->DB->commit();

            return ['article' => $article, 'humain' => $humain];
        } catch (\Exception $e) {
            $this->DB->rollBack();
            throw $e;
        }
    }


    public function updateArticleHumainnn(Humain $humain)
    {
        $sql = "UPDATE humain 
                SET prenom = :prenom, 
                    nom = :nom, 
                    age = :age, 
                    anniversaire = :anniversaire, 
                    taille = :taille, 
                    affiliation = :affiliation, 
                    Id_Article = :Id_Article 
                WHERE Id_Humain = :Id_Humain;";

        $statement = $this->DB->prepare($sql);

        $success = $statement->execute([
            ':Id_Humain'            => $humain->getIdHumain(),
            ':prenom'               => $humain->getPrenom(),
            ':nom'                  => $humain->getNom(),
            ':age'                  => $humain->getAge(),
            ':anniversaire'         => $humain->getAnniversaire(),
            ':taille'               => $humain->getTaille(),
            ':affiliation'          => $humain->getAffiliation(),
            ':Id_Article'          => $humain->getIdArticle()
        ]);

        return $success;
    }

    public function gettAllArticlesHumain()
    {
        $sql = "SELECT * FROM humain;";
        return  $this->DB->query($sql)->fetchAll(PDO::FETCH_CLASS, Humain::class);
    }

    public function getArticleHumainById($Id_Humain)
    {
        $sql = "SELECT * FROM humain WHERE Id_Humain = :Id_Humain";
        $statement = $this->DB->prepare($sql);
        $statement->execute([':Id_Humain' => $Id_Humain]);
        $statement->setFetchMode(PDO::FETCH_CLASS, Humain::class);
        $humain = $statement->fetch();
        return $humain;
    }

    public function getHumainByArticleId($Id_Article)
    {
        $sql = "SELECT * FROM humain
                WHERE Id_Article = :Id_Article";

        $statement = $this->DB->prepare($sql);
        $statement->execute([':Id_Article' => $Id_Article]);
        $statement->setFetchMode(PDO::FETCH_CLASS, Humain::class);
        $humain = $statement->fetch();
        return $humain;
    }
}
