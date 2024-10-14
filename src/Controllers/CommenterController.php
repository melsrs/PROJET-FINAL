<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\Article;
use src\Models\Commenter;
use src\Repositories\CategorieRepository;
use src\Repositories\CommenterRepository;
use src\Repositories\UtilisateurRepository;

class CommenterController
{
    private $commenterRepository;
    public function __construct()
    {
        $this->commenterRepository = new CommenterRepository();
    }

    public function createCommentaire($type)
    {
        try {
            if (!isset($_SESSION['Id_Utilisateur'])) {
                throw new Exception("L'utilisateur n'est pas connecté.");
            }

            $Id_Utilisateur = $_SESSION['Id_Utilisateur'];
            $utilisateurRepository = new UtilisateurRepository();
            $utilisateur = $utilisateurRepository->getUtilisateurById($Id_Utilisateur);

            if (!$utilisateur) {
                throw new Exception("Cet utilisateur n'existe pas.");
            }

            $article = new Article();
            $article->setIdArticle(isset($_POST['Id_Article']) ? (int)$_POST['Id_Article'] : null);

            if (empty($article->getIdArticle())) {
                throw new Exception("Id de l'article manquant ou invalide.");
            }

            $categorieRepository = new CategorieRepository();
            $categorie = $categorieRepository->getCategorieByType($type);

            $commentaire = new Commenter();
            $commentaire->setMessage(isset($_POST['commentaire']) ? htmlspecialchars($_POST['commentaire']) : null);
            $commentaire->setDateCommentaire(new DateTime('now'));

            if (empty($commentaire->getMessage())) {
                throw new Exception("Veuillez remplir le champ commentaire.");
            }

            if (strlen($commentaire->getMessage()) < 10 || strlen($commentaire->getMessage()) > 500) {
                throw new Exception("Le commentaire doit contenir entre 10 et 500 caractères.");
            }

            // Associer l'Id utilisateur et l'Id article au commentaire
            $commentaire->setIdUtilisateur($utilisateur->getIdUtilisateur());
            $commentaire->setIdArticle($article->getIdArticle());

            $this->commenterRepository->newCommentaire($commentaire);

            $_SESSION['success'] = "Votre commentaire a bien été pris en compte.";
            header('Location: ' . HOME_URL . 'categorie/' . urlencode($categorie->getType()) . '/article?id=' . $article->getIdArticle());
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . HOME_URL . 'categorie/' . urlencode($categorie->getType()) . '/article?id=' . $article->getIdArticle());
            exit;
        }
    }

    public function readCommentaire()
    {
        try {
            $Id_Utilisateur = isset($_GET['Id_Utilisateur']) ? (int)$_GET['Id_Utilisateur'] : null;
            $Id_Article = isset($_GET['Id_Article']) ? (int)$_GET['Id_Article'] : null;

            if (empty($Id_Utilisateur) || !filter_var($Id_Utilisateur, FILTER_VALIDATE_INT) || $Id_Utilisateur <= 0) {
                throw new Exception("L'Id de l'utilisateur est manquant ou invalide.");
            }

            if (empty($Id_Article) || !filter_var($Id_Article, FILTER_VALIDATE_INT) || $Id_Article <= 0) {
                throw new Exception("L'Id de l'article est manquant ou invalide.");
            }

            $commentaire = $this->commenterRepository->getCommentaireByUtilisateurAndArticle($Id_Utilisateur, $Id_Article);

            if (!$commentaire) {
                throw new Exception("Commentaire non trouvé.");
            }

            include __DIR__ . '/../Views/DashboardAdmin/CommentaireAdmin/readCommentaireAdmin.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
            exit;
        }
    }

    public function deleteThisCommentaire($Id_Article, $Id_Utilisateur)
    {
        try {
            if (!isset($_SESSION['adminConnecte']) || $_SESSION['adminConnecte'] !== true) {
                throw new Exception("Accès refusé. Vous devez être connecté pour supprimer un commentaire.");
            }
            $success = $this->commenterRepository->deleteCommentaire($Id_Article, $Id_Utilisateur);

            if ($success) {
                $_SESSION['success'] = "Le commentaire a été supprimé avec succès.";
            } else {
                throw new Exception("Une erreur est survenue lors de la suppression du commentaire.");
            }

            header('Location: ' . HOME_URL . 'dashboardAdmin');
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . HOME_URL . 'dashboardAdmin');
            exit();
        }
    }
}
