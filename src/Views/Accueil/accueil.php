<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>

<body class="bg-black text-white">
    <div class="accueil">
        <div class="texteAccueil">
            <h1>Bienvenue</h1>
            <p>Bienvenue dans notre sanctuaire dédié à L'Attaque des Titans, où nous explorons les profondeurs de cette saga titanesque, de ses personnages complexes à ses rebondissements bouleversants.</p>
            <a href="/categorie">Explorer le site</a>
        </div>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo $_GET['error']; ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
        <?php endif; ?>
        <div class="imageAccueil">
            <img class="imgAccueil" src="assets/image/imageAccueil.jpg" alt="Eren et Mikasa au pied d'un arbre">
        </div>
    </div>
</body>

<?php

include __DIR__ . '/../Includes/footer.php';

?>