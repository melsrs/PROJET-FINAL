<?php

use src\Controllers\HomeController;
use src\Controllers\UtilisateurController;
use src\Controllers\ArticleController;
use src\Controllers\CategorieController;
use src\Controllers\CommenterController;
use src\Controllers\AdminController;
use src\Controllers\DashboardController;
use src\Controllers\HumainController;

$homeController = new HomeController();
$utilisateurController = new UtilisateurController();
$articleController = new ArticleController();
$categorieController = new CategorieController();
$commenterController = new CommenterController;
$adminController = new AdminController();
$dashboardController = new DashboardController();
$humainController = new HumainController();

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
            $articleController->showArticleByCategorie((int)$_GET['id'], 'ACTUALITÉ');
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/HISTOIRE':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showArticleByCategorie((int)$_GET['id'], "HISTOIRE");
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/PERSONNAGE':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showArticleByCategorie((int)$_GET['id'], "PERSONNAGE");
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/LIEU+MYTHIQUE':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showArticleByCategorie((int)$_GET['id'], "LIEU MYTHIQUE");
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/INFORMATION':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showArticleByCategorie((int)$_GET['id'], "INFORMATION");
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/ACTUALITÉ/article':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showOneArticleByCategorie((int)$_GET['id'], "ACTUALITÉ");
        } elseif ($methode === 'POST') {
            $commenterController->createCommentaire("ACTUALITÉ");
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/HISTOIRE/article':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showOneArticleByCategorie((int)$_GET['id'], "HISTOIRE");
        } elseif ($methode === 'POST') {
            $commenterController->createCommentaire("HISTOIRE");
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/PERSONNAGE/article':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showArticlePersoHumainByCategorie((int)$_GET['id'], "PERSONNAGE");
        } elseif ($methode === 'POST') {
            $commenterController->createCommentaire("PERSONNAGE");
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/LIEU+MYTHIQUE/article':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showOneArticleByCategorie((int)$_GET['id'], "LIEU MYTHIQUE");
        } elseif ($methode === 'POST') {
            $commenterController->createCommentaire("LIEU MYTHIQUE");
        } else {
            $homeController->AfficherCategories();
        }
        break;
    case HOME_URL . 'categorie/INFORMATION/article':
        if ($methode === 'GET' && isset($_GET['id'])) {
            $articleController->showOneArticleByCategorie((int)$_GET['id'], "INFORMATION");
        } elseif ($methode === 'POST') {
            $commenterController->createCommentaire("INFORMATION");
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
    case HOME_URL . 'dashboardAdmin/updateAdmin':
        if ($methode === 'GET' && isset($_GET['id']) && $_SESSION['adminConnecte'] === true) {
            $utilisateurController->showUpdateFormAdmin((int)$_GET['id']);
        } elseif ($methode === 'POST' && $_SESSION['adminConnecte'] === true) {
            $utilisateurController->saveUpdateUtilisateur();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboardAdmin/createArticle':
        if (isset($_SESSION['adminConnecte']) && $_SESSION['adminConnecte'] === true) {
            if ($methode === 'GET') {
                $homeController->afficherFormulaireCreationArticle();
            } elseif ($methode === 'POST') {
                $articleController->createArticle();
            }
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboardAdmin/readArticle':
        if ($methode === 'GET' && isset($_GET['id']) && $_SESSION['adminConnecte'] === true) {
            $articleController->readArticle((int)$_GET['id']);
        } else {
            $homeController->dashboardAdmin();
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
    case HOME_URL . 'dashboardAdmin/createArticleHumain':
        if (isset($_SESSION['adminConnecte']) && $_SESSION['adminConnecte'] === true) {
            if ($methode === 'GET') {
                $homeController->afficherFormulaireCreationArticleHumain();
            } elseif ($methode === 'POST') {
                $humainController->createArticleHumain();
            }
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboardAdmin/readArticleHumain':
        if ($methode === 'GET' && isset($_GET['id']) && $_SESSION['adminConnecte'] === true) {
            $humainController->readArticleHumain((int)$_GET['id']);
        } else {
            $homeController->dashboardAdmin();
        }
        break;
    case HOME_URL . 'dashboardAdmin/updateArticleHumain':
        if ($methode === 'GET' && isset($_GET['id']) && $_SESSION['adminConnecte'] === true) {
            $humainController->showUpdateFormHumain((int)$_GET['id']);
        } elseif ($methode === 'POST' && $_SESSION['adminConnecte'] === true) {
            $humainController->saveUpdateArticleHumain();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboardAdmin/deleteUtilisateur':
        if ($methode === 'POST' && isset($_POST['Id_Utilisateur']) && $_SESSION['adminConnecte'] === true) {
            $utilisateurController->deleteThisUtilisateur((int)$_POST['Id_Utilisateur']);
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboardAdmin/createCategorie':
        if (isset($_SESSION['adminConnecte']) && $_SESSION['adminConnecte'] === true) {
            if ($methode === 'GET') {
                $homeController->afficherFormulaireCreationCategorie();
            } elseif ($methode === 'POST') {
                $categorieController->createCategorie();
            }
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboardAdmin/updateCategorie':
        if ($methode === 'GET' && isset($_GET['id']) && $_SESSION['adminConnecte'] === true) {
            $categorieController->showUpdateFormCategorie((int)$_GET['id']);
        } elseif ($methode === 'POST' && $_SESSION['adminConnecte'] === true) {
            $categorieController->saveUpdateCategorie();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboardAdmin/deleteCategorie':
        if ($methode === 'POST' && isset($_POST['Id_Categorie']) && $_SESSION['adminConnecte'] === true) {
            $categorieController->deleteThisCategorie((int)$_POST['Id_Categorie']);
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboardAdmin/readCommentaire':
        if ($methode === 'GET' && isset($_GET['Id_Utilisateur']) && isset($_GET['Id_Article']) && $_SESSION['adminConnecte'] === true) {
            $commenterController->readCommentaire((int)$_GET['Id_Utilisateur'], (int)$_GET['Id_Article']);
        } else {
            $homeController->dashboardAdmin();
        }
        break;
    case HOME_URL . 'dashboardAdmin/updateCommentaire':
        if ($methode === 'GET' && isset($_GET['Id_Utilisateur']) && isset($_GET['Id_Article']) && $_SESSION['adminConnecte'] === true) {
            $adminController->showUpdateFormAdmin((int)$_GET['Id_Utilisateur'], (int)$_GET['Id_Article']);
        } elseif ($methode === 'POST' && $_SESSION['adminConnecte'] === true) {
            $adminController->saveUpdateCommentaireAdmin();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;


    case HOME_URL . 'dashboard':
        if (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
            $dashboardController->showUtilisateurAndCommentaire();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboard/updateUtilisateur':
        if ($methode === 'GET' && isset($_GET['id']) && $_SESSION['connecte'] === true) {
            $utilisateurController->showUpdateForm((int)$_GET['id']);
        } elseif ($methode === 'POST' && $_SESSION['connecte'] === true) {
            $utilisateurController->saveUpdateUtilisateur();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboard/deleteUtilisateur':
        if ($methode === 'POST' && isset($_POST['Id_Utilisateur']) && $_SESSION['connecte'] === true) {
            $utilisateurController->deleteThisUtilisateur((int)$_POST['Id_Utilisateur']);
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboard/updateCommentaire':
        if ($methode === 'GET' && isset($_GET['Id_Utilisateur']) && isset($_GET['Id_Article']) && $_SESSION['connecte'] === true) {
            $dashboardController->showUpdateForm((int)$_GET['Id_Utilisateur'], (int)$_GET['Id_Article']);
        } elseif ($methode === 'POST' && $_SESSION['connecte'] === true) {
            $dashboardController->saveUpdateCommentaire();
        } else {
            $homeController->afficherLaPageConnexion();
        }
        break;
    case HOME_URL . 'dashboard/deleteCommentaire':
        if ($methode === 'POST' && isset($_POST['Id_Utilisateur']) && $_SESSION['connecte'] === true) {
            $dashboardController->deleteThisCommentaire((int)$_POST['Id_Article'], (int)$_POST['Id_Utilisateur']);
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
