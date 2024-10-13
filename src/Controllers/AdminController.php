<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\Article;
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
}