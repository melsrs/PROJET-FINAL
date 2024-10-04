<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

use src\Repositories\ArticleRepository;

$articleRepository = new ArticleRepository();
$articles = $articleRepository->findArticleByCategorie($Id_Categorie);

?>

<h2>Actualité</h2>

<div class="container" style="color: black;">
    <div class="row justify-content-center">
        <?php if (!empty($articles)) : ?>
            <?php foreach ($articles as $article): ?>
                <a href="<?= HOME_URL . ('categorie/actualite/detail?id=' . urlencode($article->getIdArticle())) ?>" class="col-md-4 d-flex justify-content-center" style="text-decoration: none; color: inherit; margin-top: 10px; margin-bottom: 30px;"> <!-- Espacement vertical réduit -->
                    <div class="card" style="width: 100%; margin: 0 5px;"> 
                        <?php if (!empty($article->getImage())): ?>
                            <img src="<?= htmlspecialchars($article->getImage()) ?>" class="card-img-top" alt="Image de l'article" style="height: 180px; object-fit: cover;"> <!-- Hauteur de l'image réduite -->
                        <?php else: ?>
                            <img src="placeholder_image.jpg" class="card-img-top" alt="Image placeholder" style="height: 180px; object-fit: cover;"> <!-- Hauteur de l'image réduite -->
                        <?php endif; ?>
                        <div class="card-body" style="padding: 10px;">
                            <h5 style="font-size: 1rem;"> 
                                <?= htmlspecialchars($article->getTitre()) ?>
                            </h5>
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