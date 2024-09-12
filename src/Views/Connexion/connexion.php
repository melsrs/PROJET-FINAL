<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>


<div class="connexion">
    <h2> Connexion </h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo $_GET['error']; ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
    <?php endif; ?>

<div class="container" >
    <form class="" method="POST" action="<?= HOME_URL .'connexion' ?>">
        <div class="form-group">
            <label for="mail">Email</label>
            <input type="email" class="form-control" id="mail" name="mail" required>
        </div>
        <div class="form-group">
            <label for="motDePasse">Mot de passe</label>
            <input type="password" class="form-control" id="motDePasse" name="motDePasse" required>
        </div>
        <button type="submit" class="btn btn-primary my-3">Se connecter</button>
        <p>Je n'ai pas de compte <a href="<?= HOME_URL .'inscription' ?>">s'inscrire</a></p>
    </form>
    </div>
<?php

include __DIR__ . '/../Includes/footer.php';

?>