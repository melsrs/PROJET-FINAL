<?php

namespace src\Controllers;

class HomeController
{
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
    
    public function afficherAccueil()
    {
        include __DIR__. '/../Views/Accueil/accueil.php';
    }
    
    public function deconnexion()
    {
        session_destroy();
        header('Location: '.HOME_URL .'accueil?success=deconnexion réussie');
    }
}