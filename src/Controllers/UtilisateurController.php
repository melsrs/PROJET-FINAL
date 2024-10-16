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

            // if (
            //     empty($utilisateur->getPrenom()) ||
            //     empty($utilisateur->getNom()) ||
            //     empty($utilisateur->getMail()) ||
            //     empty($utilisateur->getMdp()) ||
            //     empty($motDePasseConfirme)
            // ) {
            //     throw new Exception("Veuillez remplir tous les champs.");
            // }

            // if (strlen($utilisateur->getPrenom()) < 2 || strlen($utilisateur->getPrenom()) > 50) {
            //     throw new Exception("Le prénom doit contenir entre 2 et 50 caractères.");
            // }

            // if (strlen($utilisateur->getNom()) < 2 || strlen($utilisateur->getNom()) > 50) {
            //     throw new Exception("Le nom doit contenir entre 2 et 50 caractères.");
            // }

            // if ($utilisateur->getMdp() !== $motDePasseConfirme) {
            //     throw new Exception("Les mots de passe ne correspondent pas.");
            // }

            // if (strlen($utilisateur->getMdp()) < 8) {
            //     throw new Exception("Le mot de passe doit contenir au moins 8 caractères.");
            // }

            // if (!filter_var($utilisateur->getMail(), FILTER_VALIDATE_EMAIL)) {
            //     throw new Exception("Adresse email non valide.");
            // }

            // Initialisation d'un tableau d'erreurs
            $erreurs = [];

            // Validation des champs vides
            if (empty($utilisateur->getPrenom())) {
                $erreurs[] = "Veuillez remplir tous les champs.";
            }

            if (empty($utilisateur->getNom())) {
                $erreurs[] = "Veuillez remplir tous les champs.";
            }

            if (empty($utilisateur->getMail())) {
                $erreurs[] = "Veuillez remplir tous les champs.";
            }

            if (empty($utilisateur->getMdp())) {
                $erreurs[] = "Veuillez remplir tous les champs.";
            }

            if (empty($motDePasseConfirme)) {
                $erreurs[] = "Veuillez remplir tous les champs.";
            }

            // Validation de la longueur du prénom
            switch (true) {
                case (strlen($utilisateur->getPrenom()) < 2):
                    $erreurs[] = "Le prénom doit contenir au moins 2 caractères.";
                    break;
                case (strlen($utilisateur->getPrenom()) > 50):
                    $erreurs[] = "Le prénom doit contenir au maximum 50 caractères.";
                    break;
            }

            // Validation de la longueur du nom
            switch (true) {
                case (strlen($utilisateur->getNom()) < 2):
                    $erreurs[] = "Le nom doit contenir au moins 2 caractères.";
                    break;
                case (strlen($utilisateur->getNom()) > 50):
                    $erreurs[] = "Le nom doit contenir au maximum 50 caractères.";
                    break;
            }

            // Validation de la correspondance des mots de passe
            switch (true) {
                case ($utilisateur->getMdp() !== $motDePasseConfirme):
                    $erreurs[] = "Les mots de passe ne correspondent pas.";
                    break;
                case (strlen($utilisateur->getMdp()) < 8):
                    $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères.";
                    break;
            }

            // Validation de l'email
            switch (true) {
                case (!filter_var($utilisateur->getMail(), FILTER_VALIDATE_EMAIL)):
                    $erreurs[] = "Adresse email non valide.";
                    break;
            }

            // Si des erreurs sont présentes, lève une exception
            if (!empty($erreurs)) {
                throw new Exception(implode(" ", $erreurs));
            }


            $utilisateurRepository = new UtilisateurRepository();

            $mailExist = $utilisateurRepository->isMailExistant($utilisateur->getMail());

            if ($mailExist) {
                throw new Exception("Cette adresse mail est déjà utilisée.");
            }

            $motDePasseHash = password_hash($utilisateur->getMdp(), PASSWORD_DEFAULT);
            $utilisateur->setMdp($motDePasseHash);

            $utilisateurRepository->newUtilisateur($utilisateur);

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

            if (!filter_var($utilisateur->getMail(), FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Adresse email non valide.");
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
                $_SESSION['success'] = "Vous êtes connecté avec succès.";
                header('Location: ' . HOME_URL . 'dashboardAdmin');
            } elseif ($role_type[0] === 'utilisateur') {
                $_SESSION['connecte'] = true;
                $_SESSION['success'] = "Vous êtes connecté avec succès.";
                header('Location: ' . HOME_URL . 'dashboard');
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
        $utilisateurs = $this->utilisateurRepository->getAllUtilisateur();

        include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
    }

    public function showUtilisateurbyId()
    {
        try {
            if (!isset($_SESSION['Id_Utilisateur'])) {
                throw new Exception("Vous devez être connecté pour accéder à cette page.");
            }

            // Récupération de l'ID utilisateur depuis la session
            $Id_Utilisateur = $_SESSION['Id_Utilisateur'];

            // Récupération des informations utilisateur via le repository
            $utilisateur = $this->utilisateurRepository->getUtilisateurById($Id_Utilisateur);

            if (!$utilisateur) {
                throw new Exception("Utilisateur non trouvé.");
            }

            include __DIR__ . '/../Views/DashboardUtilisateur/dashboardUtilisateur.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/Connexion/connexion.php';
            exit;
        }
    }

    public function showUpdateForm()
    {
        try {
            $Id_Utilisateur = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Utilisateur) || !filter_var($Id_Utilisateur, FILTER_VALIDATE_INT) || $Id_Utilisateur <= 0) {
                throw new Exception("L'Id de l'utilisateur est manquant ou invalide.");
            }

            $utilisateur = $this->utilisateurRepository->getUtilisateurById($Id_Utilisateur);

            if (!$utilisateur) {
                throw new Exception("Utilisateur non trouvé.");
            }

            include __DIR__ . '/../Views/DashboardUtilisateur/updateUtilisateur.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardUtilisateur/updateUtilisateur.php';
            exit;
        }
    }

    public function showUpdateFormAdmin()
    {
        try {
            $Id_Utilisateur = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Utilisateur) || !filter_var($Id_Utilisateur, FILTER_VALIDATE_INT) || $Id_Utilisateur <= 0) {
                throw new Exception("L'Id de l'utilisateur est manquant ou invalide.");
            }

            $utilisateur = $this->utilisateurRepository->getUtilisateurById($Id_Utilisateur);

            if (!$utilisateur) {
                throw new Exception("Utilisateur non trouvé.");
            }

            include __DIR__ . '/../Views/DashboardAdmin/UtilisateurAdmin/updateAdmin.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/dashboardAdmin.php';
            exit;
        }
    }

    public function saveUpdateUtilisateur()
    {
        try {

            $idUtilisateur = isset($_POST['Id_Utilisateur']) ? (int)$_POST['Id_Utilisateur'] : (int)$_SESSION['Id_Utilisateur'];

            $utilisateur = $this->utilisateurRepository->getUtilisateurById($idUtilisateur);

            if (!$utilisateur) {
                throw new Exception("Utilisateur non trouvé.");
            }

            $utilisateur->setPrenom(isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : $utilisateur->getPrenom());
            $utilisateur->setNom(isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : $utilisateur->getNom());
            $utilisateur->setMail(isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : $utilisateur->getMail());

            $motDePasse = isset($_POST['motDePasse']) ? htmlspecialchars($_POST['motDePasse']) : null;
            $motDePasseConfirme = isset($_POST['motDePasseConfirme']) ? htmlspecialchars($_POST['motDePasseConfirme']) : null;

            if (!empty($motDePasse)) {
                if (strlen($motDePasse) < 8) {
                    throw new Exception("Le mot de passe doit contenir au moins 8 caractères.");
                }

                if ($motDePasse !== $motDePasseConfirme) {
                    throw new Exception("Les mots de passe ne correspondent pas.");
                }

                $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
                $utilisateur->setMdp($motDePasseHash);
            } else {
                $utilisateur->setMdp($utilisateur->getMdp());
            }

            $utilisateur->setIdRole(isset($_POST['role']) ? (int) $_POST['role'] : $utilisateur->getIdRole());

            if (
                empty($utilisateur->getPrenom()) ||
                empty($utilisateur->getNom()) ||
                empty($utilisateur->getMail()) ||
                empty($utilisateur->getIdRole())
            ) {
                throw new Exception("Veuillez remplir tous les champs obligatoires.");
            }

            if (strlen($utilisateur->getPrenom()) < 2 || strlen($utilisateur->getPrenom()) > 50) {
                throw new Exception("Le prénom doit contenir entre 2 et 50 caractères.");
            }

            if (strlen($utilisateur->getNom()) < 2 || strlen($utilisateur->getNom()) > 50) {
                throw new Exception("Le nom doit contenir entre 2 et 50 caractères.");
            }

            if (!filter_var($utilisateur->getMail(), FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Adresse email non valide.");
            }

            $utilisateur->setIdUtilisateur($idUtilisateur);

            if (empty($utilisateur->getIdUtilisateur())) {
                throw new Exception("L'Id de l'utilisateur est manquant.");
            }

            $this->utilisateurRepository->updateUtilisateur($utilisateur);

            $_SESSION['success'] = "L'utilisateur a bien été modifié.";

            if (isset($_SESSION['adminConnecte']) && $_SESSION['adminConnecte'] === true) {
                header('Location: ' . HOME_URL . 'dashboardAdmin');
            } elseif (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
                header('Location: ' . HOME_URL . 'dashboard');
            }
            exit;
        } catch (\Exception $e) {
            $Id_Utilisateur = isset($_POST['Id_Utilisateur']) ? (int)$_POST['Id_Utilisateur'] : null;
            $_SESSION['error'] = $e->getMessage();

            if (isset($_SESSION['adminConnecte']) && $_SESSION['adminConnecte'] === true) {
                header('Location: ' . HOME_URL . 'dashboardAdmin/updateAdmin?id=' . $Id_Utilisateur);
            } elseif (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
                header('Location: ' . HOME_URL . 'dashboard/updateUtilisateur?id=' . $Id_Utilisateur);
            }
            exit;
        }
    }

    public function deleteThisUtilisateur($Id_Utilisateur)
    {
        try {
            $utilisateur = $this->utilisateurRepository->getUtilisateurById($Id_Utilisateur);

            if (!$utilisateur) {
                throw new Exception("L'utilisateur n'existe pas.");
            }

            $success = $this->utilisateurRepository->deleteUtilisateur($Id_Utilisateur);

            if ($success) {
                $success = "Votre compte a bien été supprimé.";

                if (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
                    // Vider toutes les variables de session
                    $_SESSION = array();
                    session_destroy();
                    include __DIR__ . '/../Views/Connexion/connexion.php';
                    exit();
                } elseif (isset($_SESSION['adminConnecte']) && $_SESSION['adminConnecte'] === true) {
                    $_SESSION['success'] = "L'utilisateur a été supprimé avec succès.";
                    header('Location: ' . HOME_URL . 'dashboardAdmin');
                    exit();
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();

            if (isset($_SESSION['adminConnecte']) && $_SESSION['adminConnecte'] === true) {
                header('Location: ' . HOME_URL . 'dashboardAdmin');
            } elseif (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
                header('Location: ' . HOME_URL . 'dashboard');
            }
            exit();
        }
    }


    public function deconnexion()
    {
        try {
            $_SESSION = [];
            session_destroy();

            $success = "Vous êtes déconnecté avec succès.";
            include __DIR__ . '/../Views/Connexion/connexion.php';
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            throw new Exception("Une erreur est survenue lors de la déconnexion : " . $error);
        }
    }
}
