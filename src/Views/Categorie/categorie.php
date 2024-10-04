<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

use src\Repositories\CategorieRepository;

$categorieRepository = new CategorieRepository();
$categories = $categorieRepository->getCategories();

?>

<div class="container" style="color: black;">
  <div class="row">
    <?php if (!empty($categories) && !empty($categories)) : ?>
      <?php foreach ($categories as $categorie): ?>
        <div class="col-md-4">
        <?php if (!empty($categorie->getImage())): ?>
              <img src="<?= htmlspecialchars($categorie->getImage()) ?>" class="card-img-top" alt="Image de la catégorie">
            <?php else: ?>
          <div class="card" style="margin: 20px 0;">
              <img src="placeholder_image.jpg" class="card-img-top" alt="Image placeholder">
            <?php endif; ?>
            <div class="card-body">
              <?= htmlspecialchars($categorie->getType()) ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucune catégorie trouvée.</p>
    <?php endif; ?>
  </div>
</div>


<?php

include __DIR__ . '/../Includes/footer.php';

?>