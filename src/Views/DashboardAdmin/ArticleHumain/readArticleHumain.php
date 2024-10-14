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
        <div class="card " style="color: black;   width: 400px">
            <div class="card-body">

                <h5>Prénom</h5>
                <p><?= htmlspecialchars_decode($humain->getPrenom()) ?></p>

                <h5>Nom :</h5>
                <p><?= htmlspecialchars_decode($humain->getNom()) ?></p>

                <h5>Age :</h5>
                <p><?= htmlspecialchars($humain->getAge()) ?></p>

                <h5>Anniversaire :</h5>
                <p><?= htmlspecialchars($humain->getAnniversaire()) ?></p>

                <h5>Taille :</h5>
                <p><?= htmlspecialchars($humain->getTaille()) ?></p>

                <h5>Affiliation :</h5>
                <p><?= htmlspecialchars_decode($humain->getAffiliation()) ?></p>

                <div class="d-flex ">
                    <a href="<?= HOME_URL . 'dashboardAdmin' ?>" class="btn btn-primary">Retour</a>
                </div>
            </div>
        </div>
    </div>

</div>