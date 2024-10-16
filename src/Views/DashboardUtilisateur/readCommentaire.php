<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>

<div class="createArticle">
    <h2> Lire le commentaire</h2>

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
        <div class="card text-black w-100">
            <div class="card-body">
                <h5>Commentaire :</h5>
                <p><?= htmlspecialchars_decode($commentaire->getMessage()) ?></p>
                <div class="d-flex justify-content-center">
                    <a href="<?= HOME_URL . 'dashboard/updateCommentaire?Id_Utilisateur=' . $commentaire->getIdUtilisateur() . '&Id_Article=' . $commentaire->getIdArticle() ?>" class="btn btn-primary my-3">Modifier le commentaire</a>
                    <form action="<?= HOME_URL . 'dashboard/deleteCommentaire' ?>" method="POST" style="display: inline;">
                        <input type="hidden" name="Id_Article" value="<?= htmlspecialchars($commentaire->getIdArticle()) ?>">
                        <input type="hidden" name="Id_Utilisateur" value="<?= htmlspecialchars($commentaire->getIdUtilisateur()) ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>