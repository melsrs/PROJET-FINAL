<?php

namespace src\Controllers;

use Exception;
use src\Repositories\ArticleRepository;

class ArticleController
{
    public function createArticle()
    {
        // var_dump($_SESSION);
        // die();

        try {
            $titre = isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : null;
            $texte = isset($_POST['texte']) ? htmlspecialchars($_POST['texte']) : null;
            $date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : null;
            $image = isset($_POST['image']) ? htmlspecialchars($_POST['image']) : null;
            // $id_categorie = isset($_POST['id_categorie']) ? htmlspecialchars($_POST['id_categorie']) : null;

            if (empty($titre) || empty($texte) || empty($date) || empty($image)) {
                throw new Exception("Veuillez remplir tous les champs.");
            }

            // if (empty($titre) || empty($texte) || empty($date) || empty($image) || empty($id_categorie)) {
            //     throw new Exception("Veuillez remplir tous les champs.");
            // }

            // Récupération de l'ID de l'utilisateur à partir de la session
            $Id_Utilisateur = isset($_SESSION['Id_Utilisateur']) ? $_SESSION['Id_Utilisateur'] : null;

            // Vérification si l'utilisateur est connecté
            if (empty($Id_Utilisateur)) {
                throw new Exception("L'utilisateur n'est pas connecté.");
            }

            $articleRepository = new ArticleRepository();
            $articleRepository->createArticle($titre, $texte, $date, $image, 1, $Id_Utilisateur);

            header('Location:' . HOME_URL . 'dashboardAdmin?success=Votre article a bien été créé.');

        } catch (Exception $e) {
            header('Location:' . HOME_URL . 'createArticle?error=' . $e->getMessage());
        }
    }
}
