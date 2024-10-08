<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\Article;
use src\Repositories\ArticleRepository;
use src\Repositories\CommenterRepository;
use src\Repositories\UtilisateurRepository;
use src\Repositories\CategorieRepository;


class AdminController
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

    public function showAll()
    {
        $articles = $this->articleRepository->getAllArticles();
        $utilisateurs = $this->utilisateurRepository->getAllUtilisateur();
        
        include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';

    }

}