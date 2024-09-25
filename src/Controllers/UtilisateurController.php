<?php

namespace src\Controllers;

use Exception;
use src\Models\Utilisateur;
use src\Repositories\UtilisateurRepository;

class UtilisateurController
{

    private $utilisateurRepository;
    public function __construct()
    {
        $this->utilisateurRepository = new UtilisateurRepository();
    }

    public function createUtilisateur()
    {
        try {
            $utilisateur = new Utilisateur();
            $utilisateur->setPrenom(isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : null);
            $utilisateur->setNom(isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : null);
            $utilisateur->setMail(isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : null);
            $utilisateur->setMdp(isset($_POST['motDePasse']) ? $_POST['motDePasse'] : null);

            $motDePasseConfirme = isset($_POST['motDePasseConfirme']) ? $_POST['motDePasseConfirme'] : null;

            if (
                empty($utilisateur->getPrenom()) ||
                empty($utilisateur->getNom()) ||
                empty($utilisateur->getMail()) ||
                empty($utilisateur->getMdp()) ||
                empty($motDePasseConfirme)
            ) {
                throw new Exception("Veuillez remplir tous les champs.");
            }

            if ($utilisateur->getMdp() !== $motDePasseConfirme) {
                throw new Exception("Les mots de passe ne correspondent pas.");
            }

            $utilisateurRepository = new UtilisateurRepository();

            $mailExist = $utilisateurRepository->isMailExistant($utilisateur->getMail());

            if ($mailExist) {
                throw new Exception("Cette adresse mail est déjà utilisée.");
            }

            $motDePasseHash = password_hash($utilisateur->getMdp(), PASSWORD_DEFAULT);
            $utilisateur->setMdp($motDePasseHash);

            $utilisateurRepository->createUtilisateur($utilisateur);

            $success = "Votre compte a bien été créé.";
            include __DIR__ . '/../Views/Connexion/connexion.php';
            exit;

        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/Inscription/inscription.php';
            exit;
        }
    }

    // public function TraitementConnexion()
    // {
    //     try {
    //         $mail = isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : null;
    //         $motDePasse = isset($_POST['motDePasse']) ? htmlspecialchars($_POST['motDePasse']) : null;

    //         if (empty($mail) || empty($motDePasse)) {
    //             throw new Exception("Veuillez remplir tous les champs.");
    //         }
    //         $utilisateurRepository = new UtilisateurRepository;
    //         $utilisateur = $utilisateurRepository->getUtilisateurByMail($mail);

    //         if (!$utilisateur) {
    //             throw new Exception("Le mail ou le mot de passe est incorrect.");
    //         }
    //         if (!password_verify($motDePasse, $utilisateur['mdp'])) {
    //             throw new Exception("Le mail ou le mot de passe est incorrect.");
    //         }

    //         // ici on stocke les données de l'utilisateur en session
    //         $_SESSION['Id_Utilisateur'] = $utilisateur['Id_Utilisateur'];
    //         $_SESSION['prenom'] = $utilisateur['prenom'];
    //         $_SESSION['nom'] = $utilisateur['nom'];
    //         $_SESSION['mail'] = $utilisateur['mail'];
    //         $Id_Role =  $utilisateur['Id_Role'];
    //         $role_type =  $utilisateurRepository->getRoleType($Id_Role);
    //         $_SESSION['role'] = $role_type;

    //         if ($role_type === 'admin') {
    //             $_SESSION['adminConnecte'] = true;
    //             header('Location:' . HOME_URL . 'dashboardAdmin?success=Vous êtes connecté avec succès.');
    //         } elseif ($role_type === 'utilisateur') {
    //             $_SESSION['connecte'] = true;
    //             header('Location:' . HOME_URL . 'dashboard?success=Vous êtes connecté avec succès.');
    //         }
    //     } catch (Exception $e) {
    //         header('Location:' . HOME_URL . 'connexion?error=' . $e->getMessage());
    //     }
    // }


    public function TraitementConnexion()
    {
        try {
            $utilisateur = new Utilisateur();
            $utilisateur->setMail(isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : null);
            $utilisateur->setMdp(isset($_POST['motDePasse']) ? $_POST['motDePasse'] : null);
    
            if (empty($utilisateur->getMail()) || empty($utilisateur->getMdp())) {
                throw new Exception("Veuillez remplir tous les champs.");
            }
            
            $utilisateurBDD = $this->utilisateurRepository->getUtilisateurByMail($utilisateur->getMail());
    
            if (!$utilisateurBDD) {
                throw new Exception("Le mail ou le mot de passe est incorrect.");
            }
    
            if (!password_verify($utilisateur->getMdp(), $utilisateurBDD->getMdp())) {
                throw new Exception("Le mail ou le mot de passe est incorrect.");
            }
    
            // Stockage des données de l'utilisateur en session
            $_SESSION['Id_Utilisateur'] = $utilisateur->getIdUtilisateur();
            $_SESSION['prenom'] = $utilisateur->getPrenom();
            $_SESSION['nom'] = $utilisateur->getNom();
            $_SESSION['mail'] = $utilisateur->getMail();
            
            $role_type = $this->utilisateurRepository->getRoleType($utilisateur->getIdRole());
            $_SESSION['role'] = $role_type;
    
            if ($role_type === 'admin') {
                $_SESSION['adminConnecte'] = true;
                header('Location:' . HOME_URL . 'dashboardAdmin?success=' . urlencode('Vous êtes connecté avec succès.'));
            } elseif ($role_type === 'utilisateur') {
                $_SESSION['connecte'] = true;
                header('Location:' . HOME_URL . 'dashboard?success=' . urlencode('Vous êtes connecté avec succès.'));
            }
            exit();
        } catch (Exception $e) {
            header('Location:' . HOME_URL . 'connexion?error=' . urlencode($e->getMessage()));
            exit();
        }
    }
}
