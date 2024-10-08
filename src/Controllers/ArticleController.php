<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\Article;
use src\Repositories\ArticleRepository;
use src\Repositories\CommenterRepository;
use src\Repositories\UtilisateurRepository;

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

            $article->setIdUtilisateur(isset($_SESSION['adminConnecte']) ? $_SESSION['adminConnecte'] : null);

            if (empty($article->getIdUtilisateur())) {
                throw new Exception("L'utilisateur n'est pas connecté.");
            }

            $this->articleRepository->newArticle($article);

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
        $articles = $this->articleRepository->getAllArticles();

        include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
    }

    public function showUpdateForm()
    {
        try {
            $Id_Article = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Article) || !filter_var($Id_Article, FILTER_VALIDATE_INT) || $Id_Article <= 0) {
                throw new Exception("L'ID de l'article est manquant ou invalide.");
            }

            $article = $this->articleRepository->getArticleById($Id_Article);

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
            $article = new Article();
            $article->setTitre(isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : null);
            $article->setTexte(isset($_POST['texte']) ? htmlspecialchars($_POST['texte']) : null);
            $article->setDate(new DateTime('now'));
            $article->setImage(isset($_POST['image']) ? htmlspecialchars($_POST['image']) : null);

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
                throw new Exception("Veuillez vous authentifier.");
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

            $success = $this->articleRepository->deleteArticle($Id_Article);

            if ($success) {
                $_SESSION['success'] = "L'article a été supprimé avec succès.";
            } else {
                throw new Exception("Une erreur est survenue lors de la suppression de l'article.");
            }

            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
        }
    }


    public function showArticleByCategorie($Id_Categorie)
    {
        try {
            // Vérifier et valider l'ID de la catégorie à partir de $_GET
            $Id_Categorie = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Categorie) || !filter_var($Id_Categorie, FILTER_VALIDATE_INT) || $Id_Categorie <= 0) {
                throw new Exception("L'ID de la catégorie est manquant ou invalide.");
            }

            // Récupérer les articles via le repository
            $articleRepository = new ArticleRepository();
            $articles = $articleRepository->findArticleByCategorie($Id_Categorie);

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


    public function showOneArticleByCategorie($Id_Article)
    {
        try {

            $Id_Categorie = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Categorie) || !filter_var($Id_Categorie, FILTER_VALIDATE_INT) || $Id_Categorie <= 0) {
                throw new Exception("L'ID de l'article est manquant ou invalide.");
            }

            $article = $this->articleRepository->getArticleById($Id_Article);

            if (!$article) {
                throw new Exception("Article de la catégorie non trouvé.");
            }

            if (isset($_SESSION['connecte']) && isset($_SESSION['Id_Utilisateur']) || isset($_SESSION['adminConnecte']) && isset($_SESSION['Id_Utilisateur'])) {
                $utilisateurRepository = new UtilisateurRepository();
                $utilisateur = $utilisateurRepository->getUtilisateurById($_SESSION['Id_Utilisateur']);
            }

            $commenterRepository = new CommenterRepository;
            $commentaires = $commenterRepository->getCommentairesByArticleId($Id_Article);

            $utilisateurRepository = new UtilisateurRepository();

            if (!$commentaires) {
                throw new Exception("Pas de commentaires trouvés.");
            }

            // Associons les utilisateurs à leurs commentaires
            $commentairesAvecUtilisateurs = [];
            if ($commentaires) {
                $utilisateurRepository = new UtilisateurRepository();

                foreach ($commentaires as $commentaire) {
                    // Récupérer l'utilisateur lié au commentaire
                    $utilisateurInfo = $utilisateurRepository->getUtilisateurById($commentaire->getIdUtilisateur());

                    // Stocker le commentaire et l'utilisateur dans un tableau associatif
                    $commentairesAvecUtilisateurs[] = [
                        'commentaire' => $commentaire,
                        'utilisateur' => $utilisateurInfo,
                    ];
                }
            }

            if (empty($commentaires)) {
                throw new Exception("Pas de commentaires trouvés.");
            }

            // Inclure la vue avec les données
            include __DIR__ . '/../Views/Categorie/articleDetailByCategorie.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/Categorie/categorie.php';
            exit;
        }
    }
}
