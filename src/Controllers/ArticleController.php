<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\Article;
use src\Models\Utilisateur;
use src\Repositories\ArticleRepository;

class ArticleController
{
    private $articleRepository;
    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }
    public function createArticle()
    {
        try {

            $article = new Article();
            $article->setTitre(isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : null);
            $article->setTexte(isset($_POST['texte']) ? htmlspecialchars($_POST['texte']) : null);
            $dateString = isset($_POST['date']) ? $_POST['date'] : null;

            if ($dateString) {
                try {
                    $date = new DateTime($dateString);  // Convertir la chaîne en objet DateTime
                    $article->setDate($date);           // Passer l'objet DateTime à la méthode setDate()
                } catch (Exception $e) {
                    throw new Exception("La date fournie est invalide.");
                }
            }

            $article->setImage(isset($_POST['image']) ? htmlspecialchars($_POST['image']) : null);
            $article->setIdCategorie(isset($_POST['categories']) ? (int) $_POST['categories'] : null);

            if (
                empty($article->getTitre()) ||
                empty($article->getTexte()) ||
                empty($article->getDate())  ||
                empty($article->getImage()) ||
                empty($article->getIdCategorie())
            ) {
                throw new Exception("Veuillez remplir tous les champs.");
            }

            $utilisateur = new Utilisateur();
            $utilisateur->setIdUtilisateur(isset($_SESSION['Id_Utilisateur']) ? $_SESSION['Id_Utilisateur'] : null);

            if (empty($utilisateur->getIdUtilisateur())) {
                throw new Exception("L'utilisateur n'est pas connecté.");
            }

            $this->articleRepository->createArticle($article);

            $success = "L'article a bien été créé";
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/ArticleAdmin/createArticle.php';
            exit;
        }
    }

    public function showAllArticle()
    {
        $this->articleRepository->getAllArticles();

        include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
    }

    public function showUpdateForm()
    {
        $article = new Article();
        $article->setIdArticle(isset($_GET['id']) ? (int) $_GET['id'] : null);

        // Afficher une erreur si pas entier ou si existe pas
        $idArticle = $article->getIdArticle();
        if (empty($idArticle) || filter_var($idArticle, FILTER_VALIDATE_INT) === false) {
            throw new Exception("L'ID de l'article est manquant ou invalide.");
        }

        if (!empty($article->getIdArticle())) {
            $article = $this->articleRepository->getArticleById($Id_Article);
            if (!$article) {
                throw new Exception("Article non trouvé.");
            }

            // Inclure la vue du formulaire de mise à jour
            include __DIR__ . '/../Views/DashboardAdmin/ArticleAdmin/updateArticle.php';
        } else {
            $error = "Mauvais Id d'article";
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
        }
    }

    public function saveUpdateArticle()
    {
        try {
            // Récupération des champs du formulaire
            $article = new Article();
            $article->setTitre(isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : null);
            $article->setTexte(isset($_POST['texte']) ? htmlspecialchars($_POST['texte']) : null);
            $dateString = isset($_POST['date']) ? $_POST['date'] : null;

            if ($dateString) {
                try {
                    $date = new DateTime($dateString);  // Convertir la chaîne en objet DateTime
                    $article->setDate($date);           // Passer l'objet DateTime à la méthode setDate()
                } catch (Exception $e) {
                    throw new Exception("La date fournie est invalide.");
                }
            }

            $article->setImage(isset($_POST['image']) ? htmlspecialchars($_POST['image']) : null);
            $article->setIdCategorie(isset($_POST['categories']) ? (int) $_POST['categories'] : null);

            // Vérification que tous les champs sont remplis
            if (
                empty($article->getTitre()) ||
                empty($article->getTexte()) ||
                empty($article->getDate())  ||
                empty($article->getImage()) ||
                empty($article->getIdCategorie())
            ) {
                throw new Exception("Veuillez remplir tous les champs.");
            }

            $article->setIdUtilisateur(isset($_SESSION['Id_Utilisateur']) ? $_SESSION['Id_Utilisateur'] : null);

            if (empty($article->getIdUtilisateur())) {
                throw new Exception("Veuillez vous authentifier");
            }

            $article->setIdArticle(isset($_POST['id_article']) ? (int) $_POST['id_article'] : null);
            if (empty($article->getIdArticle())) {
                throw new Exception("L'ID de l'article est manquant.");
            }

            $this->articleRepository->updateArticle();

            $success = "L'article a bien été modifié";
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
            exit;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
            exit;
        }
    }
}
