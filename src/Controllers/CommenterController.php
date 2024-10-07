<?php

namespace src\Controllers;

use DateTime;
use Exception;
use src\Models\Article;
use src\Models\Commenter;
use src\Repositories\CommenterRepository;
use src\Repositories\UtilisateurRepository;

class CommenterController
{
    private $commenterRepository;
    public function __construct()
    {
        $this->commenterRepository = new CommenterRepository();
    }

    public function createCommentaire()
    {
        try {
            if (!isset($_SESSION['Id_Utilisateur'])) {
                throw new Exception("L'utilisateur n'est pas connecté.");
            }
    
            // Récupération de l'utilisateur
            $Id_Utilisateur = $_SESSION['Id_Utilisateur'];
            $utilisateurRepository = new UtilisateurRepository();
            $utilisateur = $utilisateurRepository->getUtilisateurById($Id_Utilisateur);
    
            if (!$utilisateur) {
                throw new Exception("Cet utilisateur n'existe pas.");
            }
    
            // Récupérer l'article
            $article = new Article();
            $article->setIdArticle(isset($_POST['Id_Article']) ? (int)$_POST['Id_Article'] : null);
    
            // Vérifier si l'Id de l'article est valide
            if (empty($article->getIdArticle())) {
                throw new Exception("Id de l'article manquant ou invalide.");
            }
    
            // Création du commentaire
            $commentaire = new Commenter();
            $commentaire->setMessage(isset($_POST['commentaire']) ? htmlspecialchars($_POST['commentaire']) : null);
            $commentaire->setDateCommentaire(new DateTime('now'));
    
            if (empty($commentaire->getMessage())) {
                throw new Exception("Veuillez remplir le champ commentaire.");
            }
    
            // Associer l'Id utilisateur et l'Id article au commentaire
            $commentaire->setIdUtilisateur($utilisateur->getIdUtilisateur());
            $commentaire->setIdArticle($article->getIdArticle());
    
            $this->commenterRepository->newCommentaire($commentaire);
    
            $_SESSION['success'] = "Votre commentaire a bien été pris en compte.";
            header('Location: ' . HOME_URL . 'categorie/actualite/article?id=' . urlencode($article->getIdArticle()));
            exit;
    
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . HOME_URL . 'categorie/actualite/article?id=' . urlencode($article->getIdArticle()));
            exit;
        }
    }
    
    
}
