<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>

<h2>Dashboard Admin</h2>

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

<div class="bg-white dashboard d-flex align-items-start">
    <div class="navbarDash nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-articles-tab" data-bs-toggle="pill" data-bs-target="#v-pills-articles" type="button" role="tab" aria-controls="v-pills-articles" aria-selected="true">Articles</a>
        <a class="nav-link" id="v-pills-account-tab" data-bs-toggle="pill" data-bs-target="#v-pills-account" type="button" role="tab" aria-controls="v-pills-account" aria-selected="false">Mon compte</a>
        <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false">Utilisateurs</a>
        <a class="nav-link" id="v-pills-articles-humain-tab" data-bs-toggle="pill" data-bs-target="#v-pills-articles-humain" type="button" role="tab" aria-controls="v-pills-articles-humain" aria-selected="false">Articles Humains</a>
        <a class="nav-link" id="v-pills-categories-tab" data-bs-toggle="pill" data-bs-target="#v-pills-categories" type="button" role="tab" aria-controls="v-pills-categories" aria-selected="false">Catégories</a>
        <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Commentaires</a>
    </div>

    <div class="tab-content" id="v-pills-tabContent">

        <!-- Articles -->
        <div class="tab-pane fade show active" id="v-pills-articles" role="tabpanel" aria-labelledby="v-pills-articles-tab" tabindex="0" style="color: black;">
            <div class="d-flex justify-content-center">
                <a href="<?= HOME_URL . 'dashboardAdmin/createArticle' ?>" class="btn btn-success">Ajouter un article</a>
            </div>
            <div class="container">
                <div class="row">
                    <?php if (isset($articles) && !empty($articles)): ?>
                        <?php foreach ($articles as $article): ?>
                            <div class="col-md-4" id="article-<?= $article->getIdArticle() ?>">
                                <div class="card mt-4">
                                    <?php if (!empty($article->getImage())): ?>
                                        <img src="<?= htmlspecialchars($article->getImage()) ?>" class="card-img-top img-dashboard" alt="Image de l'article">
                                    <?php else: ?>
                                        <img src="placeholder_image.jpg" class="card-img-top" alt="Image placeholder">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5>
                                            <?= htmlspecialchars_decode(mb_substr($article->getTitre(), 0, 20)) . (mb_strlen($article->getTitre()) > 20 ? '...' : '') ?>
                                        </h5>
                                        <p class="card-text"><?= htmlspecialchars_decode(mb_substr($article->getTexte(), 0, 100)) . (strlen($article->getTexte()) > 100 ? '...' : '') ?></p>
                                        <a class="btn btn-secondary" href="<?= HOME_URL . 'dashboardAdmin/readArticle?id=' . $article->getIdArticle() ?>">Voir</a>
                                        <a class="btn btn-primary" href="<?= HOME_URL . 'dashboardAdmin/updateArticle?id=' . $article->getIdArticle() ?>">Modifier</a>
                                        <form class="delete-form" method="POST" data-article-id="<?= $article->getIdArticle() ?>" style="display: inline;">
                                            <input type="hidden" name="Id_Article" value="<?= $article->getIdArticle() ?>">
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
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

        <!-- Mon compte -->
        <div class="tab-pane fade" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab" style="color: black;">
            <div class="container">
                <div class="row">
                    <?php if (!empty($utilisateur)): ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars_decode($utilisateur->getPrenom() . ' ' . $utilisateur->getNom()) ?></h5>
                                    <p class="card-text">Email : <?= htmlspecialchars($utilisateur->getMail()) ?></p>
                                    <p class="card-text">Rôle : <?= htmlspecialchars($utilisateur->getIdRole()) ?></p>
                                    <a class="btn btn-primary" href="<?= HOME_URL . 'dashboardAdmin/updateAdmin?id=' . $utilisateur->getIdUtilisateur() ?>">Modifier</a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>Aucun utilisateur trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Utilisateurs -->
        <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0" style="color: black;">
            <div class="container">
                <div class="row">
                    <?php if (isset($utilisateurs) && !empty($utilisateurs)): ?>
                        <?php foreach ($utilisateurs as $utilisateur): ?>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars_decode($utilisateur->getPrenom() . ' ' . $utilisateur->getNom()) ?></h5>
                                        <p class="card-text">Email : <?= htmlspecialchars($utilisateur->getMail()) ?></p>
                                        <p class="card-text">Rôle : <?= htmlspecialchars($utilisateur->getIdRole()) ?></p>
                                        <form action="<?= HOME_URL . 'dashboardAdmin/deleteUtilisateur' ?>" method="POST" style="display: inline;">
                                            <input type="hidden" name="Id_Utilisateur" value="<?= $utilisateur->getIdUtilisateur() ?>">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun utilisateur trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Articles Humains -->
        <div class="tab-pane fade" id="v-pills-articles-humain" role="tabpanel" aria-labelledby="v-pills-articles-humain-tab" style="color: black;">
            <div class="d-flex justify-content-center">
                <a href="<?= HOME_URL . 'dashboardAdmin/createArticleHumain' ?>" class="btn btn-success me-2">Ajouter un humain</a>
            </div>
            <div class="container">
                <div class="row">
                    <?php if (isset($humains) && !empty($humains)): ?>
                        <?php foreach ($humains as $humain): ?>
                            <div class="col-md-6">
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars_decode($humain->getPrenom()) . ' ' . htmlspecialchars_decode($humain->getNom()) ?></h5>
                                        <p class="card-text">Age : <?= htmlspecialchars($humain->getAge()) ?></p>
                                        <p class="card-text">Date anniversaire : <?= htmlspecialchars($humain->getAnniversaire()) ?></p>
                                        <a href="<?= HOME_URL . 'dashboardAdmin/readArticleHumain?id=' . $humain->getIdHumain() ?>" class="btn btn-secondary">Voir</a>
                                        <a href="<?= HOME_URL . 'dashboardAdmin/updateArticleHumain?id=' . $humain->getIdHumain() ?>" class="btn btn-primary">Modifier</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun humain trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>


        <!-- Catégories -->
        <div class="tab-pane fade" id="v-pills-categories" role="tabpanel" aria-labelledby="v-pills-categories-tab" tabindex="0" style="color: black;">
            <div class="d-flex justify-content-center">
                <a href="<?= HOME_URL . 'dashboardAdmin/createCategorie' ?>" class="btn btn-success">Ajouter une catégorie</a>
            </div>
            <div class="container">
                <div class="row">
                    <?php if (isset($categories) && !empty($categories)): ?>
                        <?php foreach ($categories as $categorie): ?>
                            <div class="col-md-4">
                                <div class="card mt-4">
                                    <?php if (!empty($categorie->getImage())): ?>
                                        <img src="<?= htmlspecialchars($categorie->getImage()) ?>" class="card-img-top img-dashboard" alt="Image de la catégorie">
                                    <?php else: ?>
                                        <img src="placeholder_image.jpg" class="card-img-top" alt="Image placeholder">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <p class="card-title"><?= htmlspecialchars($categorie->getType()) ?></p>
                                        <a class="btn btn-primary" href="<?= HOME_URL . 'dashboardAdmin/updateCategorie?id=' . $categorie->getIdCategorie() ?>">Modifier</a>
                                        <form action="<?= HOME_URL . 'dashboardAdmin/deleteCategorie' ?>" method="POST" style="display: inline;">
                                            <input type="hidden" name="Id_Categorie" value="<?= $categorie->getIdCategorie() ?>">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucune catégorie trouvée.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Commentaires -->
        <div class="tab-pane fade text-black flex-wrap" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
            <div class="container">
                <div class="row">
                    <?php if (isset($commentaires) && !empty($commentaires)): ?>
                        <?php foreach ($commentaires as $commentaire): ?>
                            <div class="col-md-6">
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <p class="card-text"><?= htmlspecialchars_decode(mb_substr($commentaire->getMessage(), 0, 50)) . (strlen($article->getTexte()) > 50 ? '...' : '') ?></p>
                                        <a class="btn btn-secondary" href="<?= HOME_URL . 'dashboardAdmin/readCommentaire?Id_Utilisateur=' . $commentaire->getIdUtilisateur() . '&Id_Article=' . $commentaire->getIdArticle() ?>">Voir</a>
                                        <a class="btn btn-primary" href="<?= HOME_URL . 'dashboardAdmin/updateCommentaire?Id_Utilisateur=' . $commentaire->getIdUtilisateur() . '&Id_Article=' . $commentaire->getIdArticle() ?>">Modifier</a>
                                        <form action="<?= HOME_URL . 'dashboardAdmin/deleteCommentaire' ?>" method="POST" style="display: inline;">
                                            <input type="hidden" name="Id_Article" value="<?= htmlspecialchars($commentaire->getIdArticle()) ?>">
                                            <input type="hidden" name="Id_Utilisateur" value="<?= htmlspecialchars($commentaire->getIdUtilisateur()) ?>">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">Supprimer</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun commentaire trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php

include __DIR__ . '/../Includes/footer.php';

?>