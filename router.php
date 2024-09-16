<?php

use src\Controllers\HomeController;
use src\Controllers\UtilisateurController;

$homeController = new HomeController();
$utlisateurController = new UtilisateurController();

$route = $_SERVER['REDIRECT_URL'];
$methode = $_SERVER['REQUEST_METHOD'];
// var_dump($_SERVER);
// die();

switch ($route) {
    case HOME_URL:
        $homeController->accueil();
        break;
    case HOME_URL . 'accueil':
        $homeController->accueil();
        break;
    case HOME_URL . 'categorie':
        $homeController->categorie();
        break;
    case HOME_URL . 'aPropos':
        $homeController->aPropos();
        break;

    case HOME_URL . 'connexion':
        if ($methode === 'POST') {
            $utlisateurController->TraitementConnexion();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'inscription':
        if ($methode === 'POST') {
            $utlisateurController->createUtilisateur();
        } else {
            $homeController->afficherLaPageInscription();
        }
        break;

    case HOME_URL . 'dashboardAdmin':
        if ($_SESSION['adminConnecte'] = true) {
            $homeController->dashboardAdmin();
        } else {
            header('Location: ' . HOME_URL . 'connexion');
        }
        break;
    case HOME_URL . 'dashboard':
        if ($_SESSION['connecte'] = true) {
            $homeController->dashboard();
        } else {
            header('Location: ' . HOME_URL . 'connexion');
        }
        break;


    case HOME_URL . 'deconnexion':
        $homeController->deconnexion();
        break;
    default:
        echo "Page non trouvée";
        break;
}
