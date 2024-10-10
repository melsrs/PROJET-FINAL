<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>

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


<div class="connexion">
    <h2> Connexion </h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center">
        <form class="w-100" style="max-width: 500px;" method="POST" action="<?= HOME_URL . 'connexion' ?>">
            <div class="mb-3 my-3">
                <label for="mail">Email</label>
                <input type="email" class="form-control" id="mail" name="mail" required>
            </div>
            <div class="mb-3 my-3">
                <label for="motDePasse">Mot de passe</label>
                <input type="password" class="form-control" id="motDePasse" name="motDePasse" required>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary my-3 boutonConnexion">Se connecter</button>
            </div>
            <div class="d-flex justify-content-center">
                <p class="mt-3 ">Je n'ai pas de compte <a href="<?= HOME_URL . 'inscription' ?>" class="lien">S'inscrire</a></p>
            </div>
        </form>
    </div>

    <?php

    include __DIR__ . '/../Includes/footer.php';

    ?>