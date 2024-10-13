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
use src\Repositories\HumainRepository;



class AdminController
{
    private $articleRepository;
    private $utilisateurRepository;
    private $commenterRepository;
    private $categorieRepository;
    private $humainRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
        $this->utilisateurRepository = new UtilisateurRepository();
        $this->commenterRepository = new CommenterRepository();
        $this->categorieRepository = new CategorieRepository();
        $this->humainRepository = new HumainRepository();


    }

    public function showAll()
    {
        try {
            if (!isset($_SESSION['Id_Utilisateur'])) {
                throw new Exception("Vous devez être connecté pour accéder à cette page.");
            }

            $Id_Utilisateur = $_SESSION['Id_Utilisateur'];

            $utilisateur = $this->utilisateurRepository->getUtilisateurById($Id_Utilisateur);

            if (!$utilisateur) {
                throw new Exception("Utilisateur non trouvé.");
            }
            
            $articles = $this->articleRepository->getAllArticles();
            $utilisateurs = $this->utilisateurRepository->getAllUtilisateur();
            $categories = $this->categorieRepository->getAllCategories();
            $commentaires = $this->commenterRepository->getAllCommentaires();
            $humains = $this->humainRepository->gettAllArticlesHumain();

            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/Connexion/connexion.php';
            exit;
        }
    }

    public function showUpdateFormAdmin()
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
    
            include __DIR__ . '/../Views/DashboardAdmin/CommentaireAdmin/updateCommentaireAdmin.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
            exit;
        }
    }

    public function saveUpdateCommentaireAdmin()
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
            header('Location: ' . HOME_URL . 'dashboardAdmin');
            exit;
        } catch (\Exception $e) {
            $Id_Utilisateur = isset($_POST['Id_Utilisateur']) ? (int)$_POST['Id_Utilisateur'] : null;
            $Id_Article = isset($_POST['Id_Article']) ? (int)$_POST['Id_Article'] : null;
    
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . HOME_URL . 'dashboardAdmin/updateCommentaire?Id_Utilisateur=' . $Id_Utilisateur . '&Id_Article=' . $Id_Article);
            exit;
        }
    }
}