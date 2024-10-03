<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

use src\Repositories\CategorieRepository;

$categorieRepository = new CategorieRepository();
$categories = $categorieRepository->getAllCategories();

?>

<?php if (!empty($categories)) : ?>
    <ul>
        <?php foreach ($categories as $categorie) : ?>
            <li><?= htmlspecialchars($categorie->getType()) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>Aucune catégorie trouvée.</p>
<?php endif; ?>

<?php

include __DIR__ . '/../Includes/footer.php';

?>