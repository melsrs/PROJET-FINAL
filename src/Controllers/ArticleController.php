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

            $_SESSION['success'] = "L'article a bien été créé.";
            header('Location: ' . HOME_URL . 'dashboardAdmin');
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . HOME_URL . 'dashboardAdmin/createArticle');
            exit;
        }
    }

    public function showAllArticle()
    {
        $articles = $this->articleRepository->getAllArticles();

        include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
    }

    public function readArticle()
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

            $categorieRepository = new CategorieRepository();
            $categories = $categorieRepository->getAllCategories(); // Assurez-vous que cette méthode retourne toutes les catégories
            $categorieId = $article->getIdCategorie();
            $categorieType = null;

            include __DIR__ . '/../Views/DashboardAdmin/ArticleAdmin/readArticle.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
            exit;
        }
    }


    public function showUpdateForm()
    {
        try {
            $Id_Article = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Article) || !filter_var($Id_Article, FILTER_VALIDATE_INT) || $Id_Article <= 0) {
                throw new Exception("L'Id de l'article est manquant ou invalide.");
            }

            $article = $this->articleRepository->getArticleById($Id_Article);

            if (!$article) {
                throw new Exception("Article non trouvé.");
            }

            $categorieRepository = new CategorieRepository();
            $categories = $categorieRepository->getCategorie();

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

            $_SESSION['success'] = "L'article a bien été modifié.";

            header('Location: ' . HOME_URL . 'dashboardAdmin');
            exit;
        } catch (\Exception $e) {
            $Id_Article = isset($_POST['id_article']) ? (int)$_POST['id_article'] : null;
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . HOME_URL . 'dashboardAdmin/updateArticle?id=' . $Id_Article);
            exit;
        }
    }

    public function deleteThisArticle($Id_Article)
    {
        try {
            // Récupération de l'article par ID
            $article = $this->articleRepository->getArticleById($Id_Article);
            if (!$article) {
                // Si l'article n'existe pas, renvoyer une erreur
                throw new Exception("L'article n'existe pas.");
            }

            // Suppression de l'article
            $success = $this->articleRepository->deleteArticle($Id_Article);

            // Vérifier si la suppression a été effectuée avec succès
            if ($success) {
                // Réponse en JSON en cas de succès
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => "L'article a été supprimé avec succès."]);
            } else {
                // Si la suppression échoue, renvoyer une erreur
                throw new Exception("Une erreur est survenue lors de la suppression de l'article.");
            }
        } catch (Exception $e) {
            // Réponse en JSON avec le message d'erreur
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit(); // Terminer l'exécution après avoir envoyé le JSON
    }

    public function showArticleByCategorie($Id_Categorie, $type)
    {
        try {
            $Id_Categorie = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Categorie) || !filter_var($Id_Categorie, FILTER_VALIDATE_INT) || $Id_Categorie <= 0) {
                throw new Exception("L'ID de la catégorie est manquant ou invalide.");
            }

            $articles = $this->articleRepository->findArticleByCategorie($Id_Categorie);

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


    public function showOneArticleByCategorie($Id_Article, $type)
    {
        try {
            if (empty($Id_Article) || !filter_var($Id_Article, FILTER_VALIDATE_INT) || $Id_Article <= 0) {
                throw new Exception("L'Id de l'article est manquant ou invalide.");
            }

            $article = $this->articleRepository->getArticleById($Id_Article);

            if (!$article) {
                throw new Exception("Article non trouvé.");
            }

            $categorieRepository = new CategorieRepository();
            $categorie = $categorieRepository->getCategorieByType($type);

            if (isset($_SESSION['connecte']) && isset($_SESSION['Id_Utilisateur']) || isset($_SESSION['adminConnecte']) && isset($_SESSION['Id_Utilisateur'])) {
                $utilisateurRepository = new UtilisateurRepository();
                $utilisateur = $utilisateurRepository->getUtilisateurById($_SESSION['Id_Utilisateur']);
            }

            $commenterRepository = new CommenterRepository;
            $commentaires = $commenterRepository->getCommentairesByArticleId($Id_Article);

            $commentairesAvecUtilisateurs = [];
            if ($commentaires) {
                $utilisateurRepository = new UtilisateurRepository();

                foreach ($commentaires as $commentaire) {
                    $utilisateurInfo = $utilisateurRepository->getUtilisateurById($commentaire->getIdUtilisateur());
                    $commentairesAvecUtilisateurs[] = [
                        'commentaire' => $commentaire,
                        'utilisateur' => $utilisateurInfo,
                    ];
                }
            }

            include __DIR__ . '/../Views/Categorie/articleDetailByCategorie.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/error.php';
            exit;
        }
    }


    public function showArticlePersoHumainByCategorie($Id_Article, $type)
    {
        try {
            if (empty($Id_Article) || !filter_var($Id_Article, FILTER_VALIDATE_INT) || $Id_Article <= 0) {
                throw new Exception("L'Id de l'article est manquant ou invalide.");
            }

            $article = $this->articleRepository->getArticleById($Id_Article);

            if (!$article) {
                throw new Exception("Article non trouvé.");
            }

            $categorieRepository = new CategorieRepository();
            $categorie = $categorieRepository->getCategorieByType($type);

            if (isset($_SESSION['connecte']) && isset($_SESSION['Id_Utilisateur']) || isset($_SESSION['adminConnecte']) && isset($_SESSION['Id_Utilisateur'])) {
                $utilisateurRepository = new UtilisateurRepository();
                $utilisateur = $utilisateurRepository->getUtilisateurById($_SESSION['Id_Utilisateur']);
            }

            $humainRepository = new HumainRepository();
            $humain = $humainRepository->getHumainByArticleId($Id_Article);

            $commenterRepository = new CommenterRepository;
            $commentaires = $commenterRepository->getCommentairesByArticleId($Id_Article);

            $commentairesAvecUtilisateurs = [];
            if ($commentaires) {
                $utilisateurRepository = new UtilisateurRepository();

                foreach ($commentaires as $commentaire) {
                    $utilisateurInfo = $utilisateurRepository->getUtilisateurById($commentaire->getIdUtilisateur());
                    $commentairesAvecUtilisateurs[] = [
                        'commentaire' => $commentaire,
                        'utilisateur' => $utilisateurInfo,
                    ];
                }
            }
            include __DIR__ . '/../Views/Categorie/articlePersoHumain.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/error.php';
            exit;
        }
    }
}
