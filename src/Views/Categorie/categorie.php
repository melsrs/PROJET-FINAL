<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>

<h2>Catégorie</h2>

<div class="container">
  <div class="row justify-content-center">
    <?php if (!empty($categories)) : ?>
      <?php foreach ($categories as $categorie): ?>
        <a href="<?= HOME_URL . 'categorie/' . urlencode($categorie->getType()) . '?id=' . urlencode($categorie->getIdCategorie()) ?>"
          class="col-md-4 d-flex justify-content-center mb-5 mt-3">
          <div class="card position-relative col-md-7" style="border: black;">
            <?php if (!empty($categorie->getImage())): ?>
              <img src="<?= htmlspecialchars($categorie->getImage()) ?>" class="card-img-top" alt="Image de la catégorie">
            <?php else: ?>
              <img src="placeholder_image.jpg" class="card-img-top" alt="Image placeholder">
            <?php endif; ?>
            <div class="card-body text-center bg-black" style="border: black;">
              <h3 class="position-absolute">
                <?= htmlspecialchars($categorie->getType()) ?>
              </h3>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucune catégorie trouvée.</p>
    <?php endif; ?>
  </div>
</div>


<?php

include __DIR__ . '/../Includes/footer.php';

?>