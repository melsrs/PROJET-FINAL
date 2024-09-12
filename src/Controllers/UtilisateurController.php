<?php

namespace src\Controllers;

use Exception;
use src\Repositories\UtilisateurRepository;

class UtilisateurController
{

    public function createUtilisateur()
    {

        try {
            $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : null;
            $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : null;
            $mail = isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : null;
            $motDePasse = isset($_POST['motDePasse']) ? htmlspecialchars($_POST['motDePasse']) : null;
            $motDePasseConfirmation = isset($_POST['motDePasseConfirme']) ? htmlspecialchars($_POST['motDePasseConfirme']) : null;

            $motDePasseHash = password_hash($_POST['motDePasse'], PASSWORD_DEFAULT);
            if (empty($prenom) || empty($nom) || empty($mail) || empty($motDePasse) || empty($motDePasseConfirmation)) {
                throw new Exception("Veuillez remplir tous les champs.");
            }

            if ($motDePasse !== $motDePasseConfirmation) {
                throw new Exception("Les mots de passe ne correspondent pas.");
            }
            $utilisateurRepository = new UtilisateurRepository;

            $mailExist = $utilisateurRepository->isMailExistant($mail);

            if ($mailExist) {
                throw new Exception("Cette adresse mail est déjà utilisée.");
            }

            $utilisateurRepository->createUtilisateur($prenom, $nom, $mail, $motDePasseHash);

            // ici redirection ic vers la page connexion d'utilisateur
            header('Location:' . HOME_URL . 'connexion?success=Votre compte a bien été créé.');
        } catch (Exception $e) {

            // ici on rest sur la meme page avec un message d'erreur

            header('Location:' . HOME_URL . 'inscription?error=' . $e->getMessage());
        }
    }

    public function TraitementConnexion()
    {
        try {
            $mail = isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : null;
            $motDePasse = isset($_POST['motDePasse']) ? htmlspecialchars($_POST['motDePasse']) : null;

            if (empty($mail) || empty($motDePasse)) {
                throw new Exception("Veuillez remplir tous les champs.");
            }
            $utilisateurRepository = new UtilisateurRepository;
            $utilisateur = $utilisateurRepository->getUtilisateurByMail($mail);
            // var_dump($utilisateur);
            // die();
            if (!$utilisateur) {
                throw new Exception("le mail ou Le mot de passe est incorrect.");
            }
            if (!password_verify($motDePasse, $utilisateur['mdp'])) {
                throw new Exception("le mail ou Le mot de passe est incorrect.");
            }

            // ici on stocke les données de l'utilisateur en session
            $_SESSION['prenom'] = $utilisateur['prenom'];
            $_SESSION['nom'] = $utilisateur['nom'];
            $_SESSION['mail'] = $utilisateur['mail'];
            $Id_Role =  $utilisateur['Id_Role'];
            $role_type =  $utilisateurRepository->getRoleType($Id_Role);
            $_SESSION['role'] = $role_type;

            // var_dump($_SESSION);
            // die();

            // ici redirection icvers la page d'accueil
            if ($role_type === 'admin') {
                $_SESSION['adminConnecte'] = true;
                header('Location:' . HOME_URL . 'admin?success=Vous êtes connecté avec succès administrateur.');
            } elseif ($role_type === 'utilisteur') {
                $_SESSION['connecte'] = true;
                header('Location:' . HOME_URL . 'accueil?success=Vous êtes connecté avec succès.');
            }
        } catch (Exception $e) {
            // ici on rest sur la meme page avec un message d'erreur
            header('Location:' . HOME_URL . 'connexion?error=' . $e->getMessage());
        }
    }
}
