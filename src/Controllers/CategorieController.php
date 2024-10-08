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
}
