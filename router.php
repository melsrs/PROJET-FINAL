<?php

use src\Controllers\HomeController;
use src\Controllers\UtilisateurController;
use src\Controllers\ArticleController;
use src\Controllers\CategorieController;
use src\Controllers\CommenterController;
use src\Controllers\AdminController;


$homeController = new HomeController();
$utilisateurController = new UtilisateurController();
$articleController = new ArticleController();
$categorieController = new CategorieController();
$commenterController = new CommenterController;
$adminController = new AdminController();

$route = $_SERVER['REDIRECT_URL'];
$methode = $_SERVER['REQUEST_METHOD'];

switch ($route) {
    case HOME_URL:
        $homeController->accueil();
        break;
    case HOME_URL . 'accueil':
        $homeController->accueil();
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

    case HOME_URL . 'categorie':
        $categorieController->showAllCategories();
        break;

    case HOME_URL . 'categorie/ACTUALITÉ':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showArticleByCategorie((int)$_GET['id']);
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/ACTUALITÉ/article':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showOneArticleByCategorie((int)$_GET['id']);
        } elseif ($methode === 'POST') {
            $commenterController->createCommentaire();
        } else {
            $homeController->AfficherCategories();
        }
        break;

    case HOME_URL . 'categorie/HISTOIRE':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showArticleByCategorie((int)$_GET['id']);
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/HISTOIRE/article':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showOneArticleByCategorie((int)$_GET['id']);
        } elseif ($methode === 'POST') {
            $commenterController->createCommentaire();
        } else {
            $homeController->AfficherCategories();
        }
        break;



    case HOME_URL . 'categorie/PERSONNAGE':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showArticleByCategorie((int)$_GET['id']);
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/LIEU+MYTHIQUE':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showArticleByCategorie((int)$_GET['id']);
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/INFORMATION':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showArticleByCategorie((int)$_GET['id']);
        } else {
            $homeController->AfficherCategories();
        }
        break;



    case HOME_URL . 'connexion':
        if ($methode === 'POST') {
            $utilisateurController->TraitementConnexion();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'inscription':
        if ($methode === 'POST') {
            $utilisateurController->createUtilisateur();
        } else {
            $homeController->afficherLaPageInscription();
        }
        break;

    case HOME_URL . 'dashboardAdmin':
        if (isset($_SESSION['adminConnecte']) && $_SESSION['adminConnecte'] === true) {
            $adminController->showAll();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;



    case HOME_URL . 'dashboard':
        if (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
            $utilisateurController->showUtilisateurbyId();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;

    case HOME_URL . 'dashboardAdmin/createArticle':
        if (isset($_SESSION['adminConnecte']) && $_SESSION['adminConnecte'] === true) {
            if ($methode === 'GET') {
                $homeController->afficherFormulaireCreationArticle();  // Affiche le formulaire vide
            } elseif ($methode === 'POST') {
                $articleController->createArticle();
            }
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
        $utilisateurController->deconnexion();
        break;
    default:
        echo "Page non trouvée";
        break;
}
