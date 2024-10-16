<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>

<h2><?= htmlspecialchars($categorie->getType()) ?></h2>


<div class="container">
    <div class="row justify-content-center">
        <?php if (!empty($articles)) : ?>
            <?php foreach ($articles as $article): ?>
                <a href="<?= HOME_URL . 'categorie/' . urlencode($categorie->getType()) . '/article?id=' . urlencode($article->getIdArticle()) ?>" class="col-md-4 d-flex justify-content-center" style="text-decoration: none; color: inherit; margin-top: 10px; margin-bottom: 30px;">
                    <div class="card w-100" style="border: black;">
                        <?php if (!empty($article->getImage())): ?>
                            <img src="<?= htmlspecialchars($article->getImage()) ?>" class="card-img-top img-custom" alt="Image de l'article">
                        <?php else: ?>
                            <img src="placeholder_image.jpg" class="card-img-top img-custom" alt="Image placeholder">
                        <?php endif; ?>
                        <div class="card-body bg-black" style="border: black;">
                            <h4>
                                <?= htmlspecialchars_decode($article->getTitre()) ?>
                            </h4>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article trouvé dans cette catégorie.</p>
        <?php endif; ?>
    </div>
</div>


<?php

include __DIR__ . '/../Includes/footer.php';

?>