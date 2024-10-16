<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>

<h2><?= htmlspecialchars($categorie->getType()) ?></h2>


<div class="container">
    <div class="row justify-content-center">
        <?php if (!empty($articles)) : ?>
            <?php foreach ($articles as $article): ?>
                <div class="col-md-3 d-flex justify-content-center mb-3"> 
                    <a href="<?= HOME_URL . 'categorie/' . urlencode($categorie->getType()) . '/article?id=' . urlencode($article->getIdArticle()) ?>">
                        <div class="card w-100" style="border: black;">
                            <?php if (!empty($article->getImage())): ?>
                                <img src="<?= htmlspecialchars($article->getImage()) ?>" class="card-img-top img-fluid" alt="Image de l'article">
                            <?php else: ?>
                                <img src="placeholder_image.jpg" class="card-img-top img-fluid" alt="Image placeholder">
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article trouvé dans cette catégorie.</p>
        <?php endif; ?>
    </div>
</div>



<?php

include __DIR__ . '/../Includes/footer.php';

?>