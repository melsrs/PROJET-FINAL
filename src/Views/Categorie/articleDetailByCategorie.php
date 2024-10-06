<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

use src\Repositories\ArticleRepository;

$articleRepository = new ArticleRepository();
$article = $articleRepository->getArticleById($Id_Article);

?>

<h2>Actualité</h2>

<div class="container">
    <div class="row justify-content-center">
        <?php if (!empty($article)) : ?>
            <div class="col-md-8 d-flex flex-column justify-content-center" style="margin-top: 20px; margin-bottom: 35px;">

                <?php if (!empty($article->getImage())): ?>
                    <img src="<?= htmlspecialchars($article->getImage()) ?>" class="img-fluid" alt="Image de l'article" style="width: 100%; height: 340px; object-fit: cover; margin-bottom: 20px; border-radius: 10px">
                <?php else: ?>
                    <img src="placeholder_image.jpg" class="img-fluid" alt="Image placeholder" style="width: 100%; height: 200px; object-fit: cover; margin-bottom: 20px;">
                <?php endif; ?>
            </div>

            <div class="card" style="width: 100%; background-color: black; color: white">
                <div>
                    <h4 style="margin-bottom: 15px">
                        <?= htmlspecialchars($article->getTitre()) ?>
                    </h4>
                    <p>
                        <?= htmlspecialchars($article->getTexte()) ?>
                    </p>
                </div>
            </div>
        <?php else: ?>
            <p>Aucun article trouvé.</p>
        <?php endif; ?>
    </div>

    <div style="margin: 60px 0 30px 0">
        <h4>Commentaires</h4>
    </div>

</div>




<?php

include __DIR__ . '/../Includes/footer.php';

?>