<?php

include __DIR__ . '/../../Includes/header.php';
include __DIR__ . '/../../Includes/navbar.php';

use src\Repositories\CategorieRepository;

$categorieRepository = new CategorieRepository();
$categories = $categorieRepository->getCategorieById();

?>

<div class="createArticle">
    <h2> Créer un article </h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center">
        <form class="w-50" method="POST" action="<?= HOME_URL . 'dashboardAdmin/createArticle' ?>">
            <div class="mb-3 my-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" id="titre" required>
            </div>
            <div class="mb-3 my-3">
                <label for="texte" class="form-label">Texte</label>
                <textarea class="form-control" name="texte" id="texte" style="height: 100px" required></textarea>
            </div>
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Image</label>
                <input type="text" name="image" class="form-control" id="image">
            </div>
            <div class="mb-3 my-3">
                <label for="categories" class="form-label">Catégories</label>
                <select class="form-select" id="categories" name="Id_Categorie" aria-label="Sélectionner une catégorie">
                    <option selected disabled>Sélectionner la catégorie</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= htmlspecialchars($categorie->getIdCategorie()) ?>">
                            <?= htmlspecialchars($categorie->getType()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary my-3">Créer un article</button>
            </div>
        </form>
    </div>