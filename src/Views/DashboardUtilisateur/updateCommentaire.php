<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>

<div class="createArticle">
    <h2> Modifier mes informations</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']);
        ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
        <?php unset($_SESSION['success']);
        ?>
    <?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center">
        <form class="w-50" method="POST" action="<?= HOME_URL . 'dashboard/updateCommentaire?Id_Utilisateur=' . $commentaire->getIdUtilisateur() . '&Id_Article=' . $commentaire->getIdArticle() ?>">
            <input type="hidden" name="Id_Article" value="<?= htmlspecialchars($commentaire->getIdArticle()) ?>">
            <input type="hidden" name="Id_Utilisateur" value="<?= htmlspecialchars($commentaire->getIdUtilisateur()) ?>">
            <input type="hidden" name="valide" value="<?= htmlspecialchars($commentaire->isValide()) ?>">

            <div class="mb-3 my-3">
                <label for="prenom" class="form-label">Commentaire</label>
                <input type="text" name="message" class="form-control" id="message" required value="<?= htmlspecialchars($commentaire->getMessage()) ?>">
            </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary my-3">Enregistrer</button>
                </div>
        </form>
    </div>