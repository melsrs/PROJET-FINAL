<?php

include __DIR__ . '/../../Includes/header.php';
include __DIR__ . '/../../Includes/navbar.php';

?>

<div class="createArticle">
    <h2> Modifier l'article </h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center">
        <form class="w-50" method="POST" action="<?= HOME_URL . 'dashboardAdmin/updateArticleHumain' ?>">
            <input type="hidden" name="Id_Humain" value="<?= htmlspecialchars($humain->getIdHumain()) ?>">
            <input type="hidden" name="Id_Article" value="<?= htmlspecialchars($article->getIdArticle()) ?>">

            <!-- Champs pour l'article -->
            <div class="mb-3 my-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" id="titre" value="<?= htmlspecialchars_decode($article->getTitre()) ?>">
            </div>

            <div class="mb-3 my-3">
                <label for="texte" class="form-label">Texte</label>
                <textarea name="texte" class="form-control" id="texte"><?= htmlspecialchars_decode($article->getTexte()) ?></textarea>
            </div>

            <div class="mb-3 my-3">
                <label for="image" class="form-label">Image (URL)</label>
                <input type="text" name="image" class="form-control" id="image" value="<?= htmlspecialchars_decode($article->getImage()) ?>">
            </div>

            <div class="mb-3 my-3">
                <label for="Id_categorie" class="form-label">Catégorie</label>
                <input type="text" name="Id_Categorie" class="form-control" id="Id_Categorie" value="<?= htmlspecialchars_decode($article->getIdCategorie()) ?>">
            </div>

            <!-- Champs pour l'humain -->
            <div class="mb-3 my-3">
                <label for="prenom" class="form-label">Prenom</label>
                <input type="text" name="prenom" class="form-control" id="prenom" value="<?= htmlspecialchars_decode($humain->getPrenom()) ?>">
            </div>

            <div class="mb-3 my-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" id="nom" value="<?= htmlspecialchars_decode($humain->getNom()) ?>">
            </div>

            <div class="mb-3 my-3">
                <label for="age" class="form-label">Age</label>
                <input type="text" name="age" class="form-control" id="age" value="<?= htmlspecialchars_decode($humain->getAge()) ?>">
            </div>

            <div class="mb-3 my-3">
                <label for="anniversaire" class="form-label">Anniversaire</label>
                <input type="text" name="anniversaire" class="form-control" id="anniversaire" value="<?= htmlspecialchars_decode($humain->getAnniversaire()) ?>">
            </div>

            <div class="mb-3 my-3">
                <label for="taille" class="form-label">Taille</label>
                <input type="text" name="taille" class="form-control" id="taille" value="<?= htmlspecialchars_decode($humain->getTaille()) ?>">
            </div>

            <div class="mb-3 my-3">
                <label for="affiliation" class="form-label">Affiliation</label>
                <input type="text" name="affiliation" class="form-control" id="affiliation" value="<?= htmlspecialchars_decode($humain->getAffiliation()) ?>">
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary my-3">Modifier</button>
            </div>
        </form>
    </div>
