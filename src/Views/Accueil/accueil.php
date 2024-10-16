<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>
<div class="container accueil py-5">
    <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start mb-5">
            <h1>Bienvenue</h1>
            <p>Bienvenue dans notre sanctuaire dédié à L'Attaque des Titans, où nous explorons les profondeurs de cette saga titanesque, de ses personnages complexes à ses rebondissements bouleversants.</p>
            <a href="<?= HOME_URL . 'categorie' ?>" class="lien">Explorer le site</a>
        </div>

        <div class="col-md-6 text-center">
        <img class="img-fluid w-75" src="assets/image/imageAccueil.jpg" alt="Eren et Mikasa au pied d'un arbre">

        </div>
    </div>
</div>



<?php

include __DIR__ . '/../Includes/footer.php';

?>