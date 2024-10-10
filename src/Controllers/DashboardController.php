<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\Article;
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
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
            exit;
        }
    }

}