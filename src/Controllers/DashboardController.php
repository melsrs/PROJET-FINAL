<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\Article;
use src\Models\Commenter;
use src\Repositories\ArticleRepository;
use src\Repositories\CommenterRepository;
use src\Repositories\UtilisateurRepository;
use src\Repositories\CategorieRepository;


class DashboardController
{
    private $articleRepository;
    private $utilisateurRepository;
    private $commenterRepository;
    private $categorieRepository;
    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
        $this->utilisateurRepository = new UtilisateurRepository();
        $this->commenterRepository = new CommenterRepository();
        $this->categorieRepository = new CategorieRepository();

    }


    public function showUtilisateurAndCommentaire()
    {
        try {
            if (!isset($_SESSION['Id_Utilisateur'])) {
                throw new Exception("Vous devez être connecté pour accéder à cette page.");
            }

            // Récupération de l'ID utilisateur depuis la session
            $Id_Utilisateur = $_SESSION['Id_Utilisateur'];

            // Récupération des informations utilisateur via le repository
            $utilisateur = $this->utilisateurRepository->getUtilisateurById($Id_Utilisateur);

            if (!$utilisateur) {
                throw new Exception("Utilisateur non trouvé.");
            }

            $commentaires = $this->commenterRepository->getCommentairesByUtilisateurId($Id_Utilisateur);

            include __DIR__ . '/../Views/DashboardUtilisateur/dashboardUtilisateur.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/Connexion/connexion.php';
            exit;
        }
    }


    public function showUpdateForm()
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
    
            // Récupérer le commentaire à partir de la base de données
            $commentaireRepository = new CommenterRepository();
            $commentaire = $commentaireRepository->getCommentaireByUtilisateurAndArticle($Id_Utilisateur, $Id_Article);
    
            if (!$commentaire) {
                throw new Exception("Commentaire non trouvé.");
            }
    
            include __DIR__ . '/../Views/DashboardUtilisateur/updateCommentaire.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardUtilisateur/dashboardUtilisateur.php';
            exit;
        }
    }

    public function saveUpdateCommentaire()
    {
        try {
            $commentaire = new Commenter();
            $commentaire->setMessage(isset($_POST['message']) ? htmlspecialchars($_POST['message']) : null);
            $commentaire->setDateCommentaire(new DateTime('now'));
            $commentaire->setValide(isset($_POST['valide']) ? htmlspecialchars($_POST['valide']) : null);
            $commentaire->setIdArticle(isset($_POST['Id_Article']) ? htmlspecialchars($_POST['Id_Article']) : null);
            $commentaire->setIdUtilisateur(isset($_POST['Id_Utilisateur']) ? htmlspecialchars($_POST['Id_Utilisateur']) : null);
    
            if (empty($commentaire->getMessage()) ||
                empty($commentaire->getDateCommentaire()) ||
                empty($commentaire->getIdArticle()) ||
                empty($commentaire->getIdUtilisateur())) {
    
                throw new Exception("Veuillez remplir tous les champs.");
            }
    
            $this->commenterRepository->updateCommentaire($commentaire);
    
            $_SESSION['success'] = "Le commentaire a été modifié.";
            header('Location: ' . HOME_URL . 'dashboard');
            exit;
        } catch (\Exception $e) {
            $Id_Utilisateur = isset($_POST['Id_Utilisateur']) ? (int)$_POST['Id_Utilisateur'] : null;
            $Id_Article = isset($_POST['Id_Article']) ? (int)$_POST['Id_Article'] : null;
    
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . HOME_URL . 'dashboard/updateCommentaire?Id_Utilisateur=' . $Id_Utilisateur . '&Id_Article=' . $Id_Article);
            exit;
        }
    }

        public function deleteThisCommentaire($Id_Article, $Id_Utilisateur)
        {
            try {
                if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] !== true) {
                    throw new Exception("Accès refusé. Vous devez être connecté pour supprimer un commentaire.");
                }

                $success = $this->commenterRepository->deleteCommentaire($Id_Article, $Id_Utilisateur);

                if ($success) {
                    $_SESSION['success'] = "Le commentaire a été supprimé avec succès.";
                } else {
                    throw new Exception("Erreur lors de la suppression du commentaire.");
                }

                header('Location: ' . HOME_URL . 'dashboard');
                exit;
    
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: ' . HOME_URL . 'dashboard');
                exit;
            }

    }
    
}