<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

use src\Repositories\ArticleRepository;

$articleRepository = new ArticleRepository();
$articles = $articleRepository->getAllArticles();

?>

<h2>Mon compte</h2>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?php echo $_GET['error']; ?></div>
<?php endif; ?>
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
<?php endif; ?>

<div class="bg-white dashboard d-flex align-items-start ">
    <div class="navbarDash nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Utilisateurs</a>
        <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Articles</a>
        <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Catégories</a>
        <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Commentaires</a>
    </div>
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">

            jljh

        </div>


        <!-- <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0" style="color: black;">
            <div class="d-flex justify-content-center">
                <a href="<?= HOME_URL . 'createArticle' ?>" class="btn btn-success">Ajouter un article</a>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <button type="button" class="btn btn-primary" href="">Modifier</button>
                    <button type="button" class="btn btn-danger">Supprimer</button>

                </div>
            </div> -->

        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0" style="color: black;">
            <div class="d-flex justify-content-center">
                <a href="<?= HOME_URL . 'createArticle' ?>" class="btn btn-success">Ajouter un article</a>
            </div>

            <!-- Vérifiez que $articles est bien défini et qu'il contient des articles -->
            <?php if (isset($articles) && !empty($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <div class="card" style="width: 18rem; margin: 20px auto;">
                        <!-- Afficher l'image si elle existe -->
                        <?php if (!empty($article['image'])): ?>
                            <img src="<?= $article['image'] ?>" class="card-img-top" alt="Image de l'article">
                        <?php else: ?>
                            <img src="placeholder_image.jpg" class="card-img-top" alt="Image placeholder">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($article['titre']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($article['texte']) ?></p>
                            <a class="btn btn-primary" href="<?= HOME_URL . 'editArticle/' . $article['Id_Article'] ?>">Modifier</a>
                            <button type="button" class="btn btn-danger" href="<?= HOME_URL . 'deleteArticle/' . $article['Id_Article'] ?>">Supprimer</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun article trouvé.</p>
            <?php endif; ?>
        </div>





    </div>
    <div class="tab-pane fade" id="v-pills-disabled" role="tabpanel" aria-labelledby="v-pills-disabled-tab" tabindex="0">...</div>
    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">...</div>
    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">...</div>
</div>
</div>