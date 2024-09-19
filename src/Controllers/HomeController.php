<?php

namespace src\Controllers;

class HomeController
{
    public function accueil()
    {
        include __DIR__. '/../Views/Accueil/accueil.php';
    }

    public function categorie()
    {
        include __DIR__ . '/../Views/Categorie/categorie.php';
    }

    public function aPropos()
    {
        include __DIR__ . '/../Views/APropos/aPropos.php';
    }

    public function afficherLaPageConnexion()
    {
        include __DIR__ . '/../Views/Connexion/connexion.php';
    }

    public function afficherLaPageInscription()
    {
        include __DIR__ . '/../Views/Inscription/inscription.php';
    }

    public function dashboardAdmin()
    {
        include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
    }

    public function dashboard()
    {
        include __DIR__ . '/../Views/DashboardUtilisateur/dashboardUtilisateur.php';
    }

    public function createArticle()
    {
        include __DIR__ . '/../Views/DashboardAdmin/ArticleAdmin.php/createArticle.php';
    }
    
    public function deconnexion()
    {
        session_destroy();
        header('Location: '.HOME_URL .'connexion?success=Déconnexion réussie');
    }
}