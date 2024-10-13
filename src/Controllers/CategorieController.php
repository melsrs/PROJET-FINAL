<?php

namespace src\Controllers;

use Exception;
use src\Models\Categorie;
use src\Repositories\CategorieRepository;

class CategorieController
{

    private $categorieRepository;
    public function __construct()
    {
        $this->categorieRepository = new CategorieRepository;
    }

    public function showAllCategories() {

        $categories = $this->categorieRepository->getAllCategories();

        include __DIR__ . '/../Views/Categorie/categorie.php';

    }


    public function showUpdateFormCategorie()
    {
        try {
            $Id_Categorie = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($Id_Categorie) || !filter_var($Id_Categorie, FILTER_VALIDATE_INT) || $Id_Categorie <= 0) {
                throw new Exception("L'Id de l'article est manquant ou invalide.");
            }

            $categorie = $this->categorieRepository->getCategorieById($Id_Categorie);

            if (!$categorie) {
                throw new Exception("Categorie non trouvé.");
            }

            include __DIR__ . '/../Views/DashboardAdmin/CategorieAdmin/updateCategorie.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/DashboardAdmin/CategorieAdmin/updateCategorie';
            exit;
        }
    }


    public function saveUpdateCategorie()
    {
        try {
            $categorie = new Categorie();
            $categorie->setImage(isset($_POST['image']) ? htmlspecialchars($_POST['image']) : null);
            $categorie->setType(isset($_POST['type']) ? htmlspecialchars($_POST['type']) : null);

            $categorie->setIdCategorie(isset($_POST['Id_Categorie']) ? (int) $_POST['Id_Categorie'] : null);

            if (
                empty($categorie->getImage()) ||
                empty($categorie->getType())
            ) {
                throw new Exception("Veuillez remplir tous les champs.");
            }

            $categorie->setIdCategorie(isset($_POST['Id_Categorie']) ? (int) $_POST['Id_Categorie'] : null);

            if (empty($categorie->getIdCategorie())) {
                throw new Exception("L'ID de la categorie est manquant.");
            }

            $this->categorieRepository->updateCategorie($categorie);

            $_SESSION['success'] = "La catégorie a bien été modifiée.";

            header('Location: ' . HOME_URL . 'dashboardAdmin');
            exit;
        } catch (\Exception $e) {
            $Id_Categorie = isset($_POST['Id_Categorie']) ? (int)$_POST['Id_Categorie'] : null;
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . HOME_URL . 'dashboardAdmin/updateCategorie?id=' . $Id_Categorie);
            exit;
        }
    }


    
}
