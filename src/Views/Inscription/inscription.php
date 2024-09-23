<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>


<div class="inscription">
    <h2> Inscription </h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo $_GET['error']; ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
    <?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center">
        <form class="w-100" style="max-width: 500px;" method="POST" action="<?= HOME_URL . 'inscription' ?>">
            <div class="mb-3 my-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" id="prenom" required>
            </div>
            <div class="mb-3 my-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" id="nom" required>
            </div>
            <div class="mb-3 my-3">
                <label for="mail" class="form-label">Mail</label>
                <input type="email" name="mail" class="form-control" id="mail" required>
            </div>
            <div class="mb-3 my-3">
                <label for="motDePasse" class="form-label">Mot de passe</label>
                <input type="password" name="motDePasse" class="form-control" id="motDePasse" required>
            </div>
            <div class="mb-3 my-3">
                <label for="motDePasseConfirme" class="form-label">Confirmation de mot de passe</label>
                <input type="password" name="motDePasseConfirme" class="form-control" id="motDePasseConfirme" required>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary mt-3 boutonConnexion">Créer un compte</button>
            </div>
            <div class="d-flex justify-content-center">
                <p class="my-3">J'ai un compte <a href="<?= HOME_URL . 'connexion' ?>" class="lien">Se connecter</a></p>
            </div>
        </form>
    </div>

    <?php

    include __DIR__ . '/../Includes/footer.php';

    ?>