<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

use src\Repositories\ArticleRepository;

$articleRepository = new ArticleRepository();
$articles = $articleRepository->getAllArticles();

?>

<h2>Mon compte</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<?php if (isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
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


        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0" style="color: black;">
            <div class="d-flex justify-content-center">
                <a href="<?= HOME_URL . 'dashboardAdmin/createArticle' ?>" class="btn btn-success">Ajouter un article</a>
            </div>
            <div class="container">
                <div class="row">
                    <?php if (isset($articles) && !empty($articles)): ?>
                        <?php foreach ($articles as $article): ?>
                            <div class="col-md-4">
                                <div class="card" style="margin: 20px 0;">
                                    <?php if (!empty($article->getImage())): ?>
                                        <img src="<?= htmlspecialchars($article->getImage()) ?>" class="card-img-top" alt="Image de l'article">
                                    <?php else: ?>
                                        <img src="placeholder_image.jpg" class="card-img-top" alt="Image placeholder">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($article->getTitre()) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars(mb_substr($article->getTexte(), 0, 100)) . (strlen($article->getTexte()) > 50 ? '...' : '') ?></p>
                                        <a class="btn btn-primary" href="<?= HOME_URL . 'dashboardAdmin/updateArticle?id=' . $article->getIdArticle() ?>">Modifier</a>
                                        <form action="<?= HOME_URL . 'dashboardAdmin/deleteArticle' ?>" method="POST" style="display: inline;">
                                            <input type="hidden" name="Id_Article" value="<?= $article->getIdArticle() ?>">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun article trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>


        </div>
        <div class="tab-pane fade" id="v-pills-disabled" role="tabpanel" aria-labelledby="v-pills-disabled-tab" tabindex="0">...</div>
        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">...</div>
        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">...</div>
    </div>
</div>