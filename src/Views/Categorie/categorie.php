<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>

<h2>Catégorie</h2>

<div class="container" style="color: black;">
  <div class="row justify-content-center">
    <?php if (!empty($categories)) : ?>
      <?php foreach ($categories as $categorie): ?>
        <a href="<?= HOME_URL . 'categorie/' . urlencode($categorie->getType()) . '?id=' . urlencode($categorie->getIdCategorie()) ?>" 
           class="col-md-4 d-flex justify-content-center" 
           style="text-decoration: none; color: inherit; margin-top: 20px; margin-bottom: 50px;">
          <div class="card" style="max-width: 60%; margin: 0 10px;">
            <?php if (!empty($categorie->getImage())): ?>
              <img src="<?= htmlspecialchars($categorie->getImage()) ?>" class="card-img-top" alt="Image de la catégorie">
            <?php else: ?>
              <img src="placeholder_image.jpg" class="card-img-top" alt="Image placeholder">
            <?php endif; ?>
            <div class="card-body">
              <?= htmlspecialchars($categorie->getType()) ?>
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