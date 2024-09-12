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

<div class="container" >

    <form class="" method="POST" action="<?= HOME_URL .'inscription' ?>">
        <div class="col-md-6">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" id="prenom" required>
        </div>
        <div class="col-md-6 my-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" id="nom" required>
        </div>
        <div class="col-md-6">
            <label for="mail" class="form-label">Mail</label>
            <input type="email" name="mail" class="form-control" id="mail" required>
        </div>
        <div  class="col-md-6 my-3">
            <label for="motDePasse" class="form-label">Mot de passe</label>
            <input type="password" name="motDePasse" class="form-control" id="motDePasse" required>
        </div>
        <div class="col-md-6">
            <label for="motDePasseConfirme" class="form-label">Confirmation de mot de passe</label>
            <input type="password" name="motDePasseConfirme" class="form-control" id="motDePasseConfirme" required>
        </div>
        <div class="col-md-6 my-3">
            <button type="submit" class="btn btn-primary mt-3">Créer un compte</button>
        </div>
    </form>

    <p class="my-3">J'ai un compte <a href="<?= HOME_URL .'connexion' ?>"> se connecter</a></p>

    </div>

    <?php

    include __DIR__ . '/../Includes/footer.php';

    ?>