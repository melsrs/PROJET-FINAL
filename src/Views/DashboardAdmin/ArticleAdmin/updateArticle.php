<?php

include __DIR__ . '/../../Includes/header.php';
include __DIR__ . '/../../Includes/navbar.php';

use src\Models\Article;
use src\Repositories\CategorieRepository;

$article = new Article();

$categorieRepository = new CategorieRepository();
$categories = $categorieRepository->getAllCategories();

?>

<div class="createArticle">
    <h2> Modifier l'article </h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center">
        <form class="w-50" method="POST" action="<?= HOME_URL . 'dashboardAdmin/updateArticle' ?>">

            <input type="hidden" name="id_article" value="<?= htmlspecialchars($article->getIdArticle()) ?>">

            <div class="mb-3 my-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" id="titre" required value="<?= htmlspecialchars($article->getTitre()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="texte" class="form-label">Texte</label>
                <textarea class="form-control" name="texte" id="texte" style="height: 100px" required><?= htmlspecialchars($article->getTexte()) ?></textarea>
            </div>
            <!-- <div class="mb-3 my-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" id="date" required>
            </div> -->
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Image</label>
                <input type="text" name="image" class="form-control" id="image" value="<?= htmlspecialchars($article->getImage()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="categories" class="form-label">Catégories</label>
                <select class="form-select" id="categories" name="Id_Categorie" aria-label="Sélectionner une catégorie">
                    <option disabled>Sélectionner la catégorie</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= htmlspecialchars($categorie->getIdCategorie()) ?>"
                            <?= $categorie->getIdCategorie() == $article->getIdCategorie() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categorie->getType()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary my-3">Modifier l'article</button>
            </div>
        </form>
    </div>