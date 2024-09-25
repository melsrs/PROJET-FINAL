<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\Article;
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
            $article->setDate(new DateTime('now'));
            $article->setImage(isset($_POST['image']) ? htmlspecialchars($_POST['image']) : null);

            if (!isset($_POST['Id_Categorie']) || $_POST['Id_Categorie'] === '') {
                throw new Exception("Veuillez remplir le champs catégories.");
            }
            $article->setIdCategorie(isset($_POST['Id_Categorie']) ? (int) $_POST['Id_Categorie'] : null);

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
                throw new Exception("L'utilisateur n'est pas connecté.");
            }

            $this->articleRepository->createArticle($article);

            $success = "L'article a bien été créé.";
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
        try {
            $Id_Article = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Article) || !filter_var($Id_Article, FILTER_VALIDATE_INT) || $Id_Article <= 0) {
                throw new Exception("L'Id de l'article est manquant ou invalide.");
            }

            $article = new Article();
            $article->setIdArticle($Id_Article);

            $this->articleRepository->getArticleById($Id_Article);

            if (!$article) {
                throw new Exception("Article non trouvé.");
            }

            include __DIR__ . '/../Views/DashboardAdmin/ArticleAdmin/updateArticle.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/ArticleAdmin/updateArticle.php';
            exit;
        }
    }


    public function saveUpdateArticle()
    {
        try {
            // Récupération des champs du formulaire
            $article = new Article();
            $article->setTitre(isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : null);
            $article->setTexte(isset($_POST['texte']) ? htmlspecialchars($_POST['texte']) : null);
            $article->setDate(new DateTime('now'));
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

            $article->setIdUtilisateur(isset($_SESSION['Id_Utilisateur']) ? $_SESSION['Id_Utilisateur'] : null);

            if (empty($article->getIdUtilisateur())) {
                throw new Exception("Veuillez vous authentifier");
            }

            $article->setIdArticle(isset($_POST['id_article']) ? (int) $_POST['id_article'] : null);
            if (empty($article->getIdArticle())) {
                throw new Exception("L'ID de l'article est manquant.");
            }

            $this->articleRepository->updateArticle($article);

            $success = "L'article a bien été modifié";
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
            exit;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
            exit;
        }
    }


    public function deleteThisArticle($Id_Article)
    {
        try {
            // Vérifier si l'article existe avant de le supprimer
            $article = $this->articleRepository->getArticleById($Id_Article);
            if (!$article) {
                throw new Exception("L'article n'existe pas.");
            }
    
            // Tenter de supprimer l'article
            $success = $this->articleRepository->deleteArticle($Id_Article);
    
            if ($success) {
                // Si la suppression a réussi
                $_SESSION['success'] = "L'article a été supprimé avec succès.";
            } else {
                // Si la suppression a échoué pour une raison quelconque
                throw new Exception("Une erreur est survenue lors de la suppression de l'article.");
            }
    
            // $articles = $this->articleRepository->getAllArticles();

            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
    
        } catch (Exception $e) {

            $_SESSION['error'] = $e->getMessage();  
            // $articles = $this->articleRepository->getAllArticles();
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
        }
    }


}
