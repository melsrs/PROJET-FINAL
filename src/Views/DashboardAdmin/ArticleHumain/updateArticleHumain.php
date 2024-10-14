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
            <input type="hidden" name="Id_Article" value="<?= htmlspecialchars($humain->getIdArticle()) ?>">
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Prenom</label>
                <input type="text" name="prenom" class="form-control" id="prenom" value="<?= htmlspecialchars_decode($humain->getPrenom()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" id="nom" value="<?= htmlspecialchars_decode($humain->getNom()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Age</label>
                <input type="text" name="age" class="form-control" id="age" value="<?= htmlspecialchars_decode($humain->getAge()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Anniversaire</label>
                <input type="text" name="anniversaire" class="form-control" id="anniversaire" value="<?= htmlspecialchars_decode($humain->getAnniversaire()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Taille</label>
                <input type="text" name="taille" class="form-control" id="taille" value="<?= htmlspecialchars_decode($humain->getTaille()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Affiliation</label>
                <input type="text" name="affiliation" class="form-control" id="affiliation" value="<?= htmlspecialchars_decode($humain->getAffiliation()) ?>">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary my-3">Modifier</button>
            </div>
        </form>
    </div>