<?php

use src\Controllers\HomeController;
use src\Controllers\UtilisateurController;
use src\Controllers\ArticleController;

$homeController = new HomeController();
$utlisateurController = new UtilisateurController();
$articleController = new ArticleController();

$route = $_SERVER['REDIRECT_URL'];
$methode = $_SERVER['REQUEST_METHOD'];

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
    case HOME_URL . 'mentionsLegales':
        $homeController->mentionsLegales();
        break;
    case HOME_URL . 'politiqueConfidentialité':
        $homeController->politiqueConfidentialité();
        break;
    case HOME_URL . 'conditionsGenerales':
        $homeController->conditionsGenerales();
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
        if ($_SESSION['adminConnecte'] === true) {
            $homeController->dashboardAdmin();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboard':
        if ($_SESSION['connecte'] === true) {
            $homeController->dashboard();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;


    case HOME_URL . 'dashboardAdmin/createArticle':
        if ($methode === 'POST' && $_SESSION['adminConnecte'] === true) {
            $articleController->createArticle();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboardAdmin/updateArticle':
        if ($methode === 'GET' && isset($_GET['id']) && $_SESSION['adminConnecte'] === true) {
            $articleController->showUpdateForm((int)$_GET['id']);
        } elseif ($methode === 'POST' && $_SESSION['adminConnecte'] === true) {
            $articleController->saveUpdateArticle();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboardAdmin/deleteArticle':
        if ($methode === 'POST' && isset($_POST['Id_Article']) && $_SESSION['adminConnecte'] === true) {
            $articleController->deleteThisArticle((int)$_POST['Id_Article']);
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;


    case HOME_URL . 'deconnexion':
        $utlisateurController->deconnexion();
        break;
    default:
        echo "Page non trouvée";
        break;
}
