<?php

use src\Controllers\HomeController;
use src\Controllers\UtilisateurController;

$homeController = new HomeController();
$utlisateurController = new UtilisateurController();


$route = $_SERVER['REDIRECT_URL'];
$methode = $_SERVER['REQUEST_METHOD'];
// var_dump($_SERVER);
// die();

// $route = Router::routeComposee();

switch ($route) {
    case HOME_URL:
        $homeController->afficherAccueil();
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
        // termine
    case HOME_URL . 'inscription':
        if ($methode === 'POST') {
            $utlisateurController->createUtilisateur();
        } else {
            $homeController->afficherLaPageInscription();
        }
        break;

    case HOME_URL . 'accueil':
        if ($methode === 'POST') {
           //
        } else {
            $homeController->afficherAccueil();
        }
        break;

        case HOME_URL .'admin':
            
            if ($_SESSION['adminConnecte'] = true) {
                $homeController->adminPage();
            } else {
                header('Location: '.HOME_URL.'connexion');
            }

        break;











        case HOME_URL . 'deconnexion':
            $homeController->deconnexion();
        break;
    default:
        echo "Page non trouvée";
        break;
}
