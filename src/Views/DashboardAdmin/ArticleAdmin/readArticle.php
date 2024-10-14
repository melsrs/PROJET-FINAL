<?php

include __DIR__ . '/../../Includes/header.php';
include __DIR__ . '/../../Includes/navbar.php';

?>

<div class="createArticle">
    <h2>Consulter l'article</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="card" style="color: black;">
            <img src="<?= htmlspecialchars($article->getImage()) ?>" class="card-img-top" style="width: 20%" alt="Image de l'article">
            <div class="card-body">

                <h5>Titre :</h5>
                <p><?= htmlspecialchars_decode($article->getTitre()) ?></p>

                <h5>Texte :</h5>
                <p><?= htmlspecialchars_decode($article->getTexte()) ?></p>
                <?php
                foreach ($categories as $categorie) {
                    if ($categorie->getIdCategorie() == $categorieId) {
                        $categorieType = $categorie->getType();
                        break;
                    }
                }
                ?>
                <h5>Catégorie :</h5>

                </h5>
                <p><?= htmlspecialchars($categorieType ?? 'Inconnue') ?></p>

                <div class="d-flex ">
                    <a href="<?= HOME_URL . 'dashboardAdmin/updateArticle?id=' . htmlspecialchars($article->getIdArticle()) ?>" class="btn btn-primary">Modifier l'article</a>
                    <form action="<?= HOME_URL . 'dashboardAdmin/deleteArticle' ?>" method="POST" style="display: inline;">
                        <input type="hidden" name="Id_Article" value="<?= htmlspecialchars($article->getIdArticle()) ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>