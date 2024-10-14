<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\Article;
use src\Models\Humain;
use src\Repositories\ArticleRepository;
use src\Repositories\CategorieRepository;
use src\Repositories\CommenterRepository;
use src\Repositories\UtilisateurRepository;
use src\Repositories\HumainRepository;


class HumainController
{
    private $humainRepository;
    public function __construct()
    {
        $this->humainRepository = new humainRepository();
    }


    public function createArticleHumain()
    {
        try {
            $article = new Article();
            $article->setTitre(isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : null);
            $article->setTexte(isset($_POST['texte']) ? htmlspecialchars($_POST['texte']) : null);
            $article->setDate(new DateTime('now'));
            $article->setImage(isset($_POST['image']) ? htmlspecialchars($_POST['image']) : null);
            $article->setIdCategorie(isset($_POST['Id_Categorie']) ? (int) $_POST['Id_Categorie'] : null);

            $humain = new Humain();
            $humain->setPrenom(isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : null);
            $humain->setNom(isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : null);
            $humain->setAge(isset($_POST['age']) ? htmlspecialchars($_POST['age']) : null);
            $humain->setAnniversaire(isset($_POST['anniversaire']) ? htmlspecialchars($_POST['anniversaire']) : null);
            $humain->setTaille(isset($_POST['taille']) ? htmlspecialchars($_POST['taille']) : null);
            $humain->setAffiliation(isset($_POST['affiliation']) ? htmlspecialchars($_POST['affiliation']) : null);

            if (!isset($_POST['Id_Categorie']) || $_POST['Id_Categorie'] === '') {
                throw new Exception("Veuillez remplir le champs catégories.");
            }

            if (
                empty($article->getTitre()) ||
                empty($article->getTexte()) ||
                empty($article->getDate())  ||
                empty($article->getImage()) ||
                empty($article->getIdCategorie()) ||
                empty($humain->getPrenom()) ||
                empty($humain->getNom()) ||
                empty($humain->getAge()) ||
                empty($humain->getAnniversaire()) ||
                empty($humain->getTaille()) ||
                empty($humain->getAffiliation())
            ) {
                throw new Exception("Veuillez remplir tous les champs.");
            }

            $article->setIdUtilisateur(isset($_SESSION['adminConnecte']) ? $_SESSION['adminConnecte'] : null);

            if (empty($article->getIdUtilisateur())) {
                throw new Exception("L'utilisateur n'est pas connecté.");
            }

            $humainRepository = new HumainRepository();
            $humainRepo = $humainRepository->createArticleHumain($article, $humain);

            $_SESSION['success'] = "L'article a bien été créé.";
            header('Location: ' . HOME_URL . 'dashboardAdmin');
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . HOME_URL . 'dashboardAdmin/createArticle');
            exit;
        }
    }

    public function readArticleHumain()
    {
        try {
            $Id_Humain = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Humain) || !filter_var($Id_Humain, FILTER_VALIDATE_INT) || $Id_Humain <= 0) {
                throw new Exception("L'ID de l'article est manquant ou invalide.");
            }

            $humain = $this->humainRepository->getArticleHumainById($Id_Humain);

            if (!$humain) {
                throw new Exception("Article non trouvé.");
            }

            include __DIR__ . '/../Views/DashboardAdmin/ArticleHumain/readArticleHumain.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
            exit;
        }
    }



    public function showUpdateFormHumain()
    {
        try {
            $Id_Humain = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Humain) || !filter_var($Id_Humain, FILTER_VALIDATE_INT) || $Id_Humain <= 0) {
                throw new Exception("L'Id de l'article est manquant ou invalide.");
            }

            $humain = $this->humainRepository->getArticleHumainById($Id_Humain);

            if (!$humain) {
                throw new Exception("Article non trouvé.");
            }

            include __DIR__ . '/../Views/DashboardAdmin/ArticleHumain/updateArticleHumain.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/ArticleHumain/updateArticleHumain.php';
            exit;
        }
    }

    public function saveUpdateArticleHumain()
    {
        try {

            $humain = new Humain();
            $humain->setPrenom(isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : null);
            $humain->setNom(isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : null);
            $humain->setAge(isset($_POST['age']) ? htmlspecialchars($_POST['age']) : null);
            $humain->setAnniversaire(isset($_POST['anniversaire']) ? htmlspecialchars($_POST['anniversaire']) : null);
            $humain->setTaille(isset($_POST['taille']) ? htmlspecialchars($_POST['taille']) : null);
            $humain->setAffiliation(isset($_POST['affiliation']) ? htmlspecialchars($_POST['affiliation']) : null);

            if (
                empty($humain->getPrenom()) ||
                empty($humain->getNom()) ||
                empty($humain->getAge()) ||
                empty($humain->getAnniversaire()) ||
                empty($humain->getTaille()) ||
                empty($humain->getAffiliation())
            ) {
                throw new Exception("Veuillez remplir tous les champs.");
            }

            $humain->setIdHumain(isset($_POST['Id_Humain']) ? (int) $_POST['Id_Humain'] : null);
            if (empty($humain->getIdHumain())) {
                throw new Exception("L'Id de l'humain est manquant.");
            }

            $humain->setIdArticle(isset($_POST['Id_Article']) ? (int) $_POST['Id_Article'] : null);
            if (empty($humain->getIdArticle())) {
                throw new Exception("L'ID de l'article est manquant.");
            }

            $this->humainRepository->updateArticleHumain($humain);

            $_SESSION['success'] = "L'article a bien été modifié.";

            header('Location: ' . HOME_URL . 'dashboardAdmin');
            exit;
        } catch (\Exception $e) {
            $Id_Humain = isset($_POST['Id_Humain']) ? (int)$_POST['Id_Humain'] : null;
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . HOME_URL . 'dashboardAdmin/updateArticleHumain?id=' . $Id_Humain);
            exit;
        }
    }

    public function showArticleByCategorie($Id_Categorie, $type)
    {
        try {
            $Id_Categorie = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Categorie) || !filter_var($Id_Categorie, FILTER_VALIDATE_INT) || $Id_Categorie <= 0) {
                throw new Exception("L'ID de la catégorie est manquant ou invalide.");
            }

            // Récupérer les articles via le repository
            $articleRepository = new ArticleRepository();
            $articles = $articleRepository->findArticleByCategorie($Id_Categorie);

            // Récupérer la catégorie par son type
            $categorieRepository = new CategorieRepository();
            $categorie = $categorieRepository->getCategorieByType($type);

            if (empty($articles)) {
                throw new Exception("Aucun article trouvé pour cette catégorie.");
            }

            include __DIR__ . '/../Views/Categorie/allArticlesByCategorie.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/Categorie/categorie.php';
            exit;
        }
    }
}