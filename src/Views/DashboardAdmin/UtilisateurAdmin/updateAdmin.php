<?php

include __DIR__ . '/../../Includes/header.php';
include __DIR__ . '/../../Includes/navbar.php';

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
        <form class="w-50" method="POST" action="<?= HOME_URL . 'dashboardAdmin/updateAdmin' ?>">
            <input type="hidden" name="Id_Utilisateur" value="<?= htmlspecialchars($utilisateur->getIdUtilisateur()) ?>">

            <div class="mb-3 my-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" id="prenom" required value="<?= htmlspecialchars($utilisateur->getPrenom()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" id="nom" required value="<?= htmlspecialchars($utilisateur->getNom()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="mail" class="form-label">Mail</label>
                <input type="email" name="mail" class="form-control" id="mail" required value="<?= htmlspecialchars($utilisateur->getMail()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="mdp" class="form-label">Mot de passe</label>
                <input type="password" name="motDePasse" class="form-control" id="motDePasse" value="<?= htmlspecialchars($utilisateur->getMdp()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="motDePasseConfirme" class="form-label">Confirmation de mot de passe</label>
                <input type="password" name="motDePasseConfirme" class="form-control" id="motDePasseConfirme">
            </div>
            <div class="mb-3 my-3">
                <input type="hidden" name="role" class="form-control" id="role" value="<?= htmlspecialchars($utilisateur->getIdRole()) ?>">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary my-3">Enregistrer</button>
            </div>
        </form>
    </div>