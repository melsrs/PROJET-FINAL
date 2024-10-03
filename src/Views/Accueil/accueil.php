<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>
<div class="accueil">
    <div class="texteAccueil">
        <h1>Bienvenue</h1>
        <p>Bienvenue dans notre sanctuaire dédié à L'Attaque des Titans, où nous explorons les profondeurs de cette saga titanesque, de ses personnages complexes à ses rebondissements bouleversants.</p>
        <a href="<?= HOME_URL . 'categorie' ?>" class="lien">Explorer le site</a>
    </div>
    <div class="imageAccueil">
        <img class="imgAccueil" src="assets/image/imageAccueil.jpg" alt="Eren et Mikasa au pied d'un arbre">
    </div>
</div>


<?php

include __DIR__ . '/../Includes/footer.php';

?>