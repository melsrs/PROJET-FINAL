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

            // Si tout s'est bien passé, valider la transaction
            $this->DB->commit();

            return ['article' => $article, 'humain' => $humain];
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            $this->DB->rollBack();
            throw $e;
        }
    }
}
