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
            $_SESSION['Id_Utilisateur'] = $utilisateurBDD->getIdUtilisateur();
            $_SESSION['prenom'] = $utilisateurBDD->getPrenom();
            $_SESSION['nom'] = $utilisateurBDD->getNom();
            $_SESSION['mail'] = $utilisateurBDD->getMail();

            $role_type = $this->utilisateurRepository->getRoleType($utilisateurBDD->getIdRole());
            $_SESSION['role'] = $role_type;

            if ($role_type[0] === 'admin') {
                $_SESSION['adminConnecte'] = true;

                $success = "Vous êtes connecté avec succès.";
                include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';

            } elseif ($role_type[0] === 'utilisateur') {
                $_SESSION['connecte'] = true;
                $success = "Vous êtes connecté avec succès.";
                include __DIR__ . '/../Views/DashboardUtilisateur/dashboardUtilisateur.php';
                exit;
            }

        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/Connexion/connexion.php';
            exit;
        }
    }

    public function showAllUtilisateur()
    {
        $this->utilisateurRepository->getAllUtilisateur();

        include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
    }
}
