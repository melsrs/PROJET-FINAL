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


<div class="bg-white dashboard d-flex align-items-start ">
    <div class="navbarDash nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-account-tab" data-bs-toggle="pill" data-bs-target="#v-pills-account" type="button" role="tab" aria-controls="v-pills-account" aria-selected="false">Mon compte</a>
        <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Utilisateurs</a>
        <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Articles</a>
        <a class="nav-link" id="v-pills-articles-humain-tab" data-bs-toggle="pill" data-bs-target="#v-pills-articles-humain" type="button" role="tab" aria-controls="v-pills-articles-humain" aria-selected="false">Personnages</a>
        <a class="nav-link" id="v-pills-categories-tab" data-bs-toggle="pill" data-bs-target="#v-pills-categories" type="button" role="tab" aria-controls="v-pills-categories" aria-selected="false">Catégories</a>
        <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Commentaires</a>
    </div>

    <!-- Contenu des onglets -->
    <div class="tab-content" id="v-pills-tabContent">


        <div class="tab-pane fade show active" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab" style="color: black;">
            <div class="container">
                <div class="container">
                    <div class="row">
                        <?php if (!empty($utilisateur)): ?>
                            <div class="col-md-15">
                                <div class="card" style="margin: 20px 0; ">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($utilisateur->getPrenom() . ' ' . $utilisateur->getNom()) ?></h5>
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
        </div>

        <!-- Utilisateurs -->
        <div class="tab-pane fade show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0" style="color: black;">
            <div class="container">
                <div class="row">
                    <?php if (isset($utilisateurs) && !empty($utilisateurs)): ?>
                        <?php foreach ($utilisateurs as $utilisateur): ?>
                            <div class="col-md-4">
                                <div class="card" style="margin: 20px 0;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($utilisateur->getPrenom() . ' ' . $utilisateur->getNom()) ?></h5>
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

        <!-- Articles -->
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
                                        <img src="<?= htmlspecialchars($article->getImage()) ?>" class="card-img-top" style="height: 500%" alt="Image de l'article">
                                    <?php else: ?>
                                        <img src="placeholder_image.jpg" class="card-img-top" alt="Image placeholder">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($article->getTitre()) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars(mb_substr($article->getTexte(), 0, 100)) . (strlen($article->getTexte()) > 100 ? '...' : '') ?></p>
                                        <a class="btn btn-secondary" href="<?= HOME_URL . 'dashboardAdmin/readArticle?id=' . $article->getIdArticle() ?>">Voir</a>
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

        <!-- Articles Personnages -->
        <div class="tab-pane fade" id="v-pills-articles-humain" role="tabpanel" aria-labelledby="v-pills-articles-humain-tab" style="color: black;">
            <div class="d-flex justify-content-center">
                <a href="<?= HOME_URL . 'dashboardAdmin/createArticleHumain' ?>" class="btn btn-success me-2">Ajouter un humain</a>
                <a href="<?= HOME_URL . 'dashboardAdmin/createArticleTitan' ?>" class="btn btn-success">Ajouter un titan</a>
            </div>
            <div class="container">
                <div class="row">
                    <?php if (isset($articlesPersonnages) && !empty($articlesPersonnages)): ?>
                        <?php foreach ($articlesPersonnages as $articlesPersonnage): ?>
                            <div class="col-md-4">
                                <div class="card" style="margin: 20px 0;">
                                    <?php if (!empty($articlesPersonnage->getImage())): ?>
                                        <img src="<?= htmlspecialchars($articlesPersonnage->getImage()) ?>" class="card-img-top" style="height: 500%" alt="Image de l'article">
                                    <?php else: ?>
                                        <img src="placeholder_image.jpg" class="card-img-top" alt="Image placeholder">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($articlesPersonnage->getTitre()) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars(mb_substr($articlesPersonnage->getTexte(), 0, 100)) . (strlen($articlesPersonnage->getTexte()) > 100 ? '...' : '') ?></p>
                                        <a class="btn btn-secondary" href="<?= HOME_URL . 'dashboardAdmin/readArticleHumain?id=' . $articlesPersonnage->getIdArticle() ?>">Voir</a>
                                        <a class="btn btn-primary" href="<?= HOME_URL . 'dashboardAdmin/updateArticleHumain?id=' . $articlesPersonnage->getIdArticle() ?>">Modifier</a>
                                        <form action="<?= HOME_URL . 'dashboardAdmin/deleteArticle' ?>" method="POST" style="display: inline;">
                                            <input type="hidden" name="Id_Article" value="<?= $articlesPersonnage->getIdArticle() ?>">
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
                                <div class="card" style="margin: 20px 0;">
                                    <?php if (!empty($categorie->getImage())): ?>
                                        <img src="<?= htmlspecialchars($categorie->getImage()) ?>" class="card-img-top" alt="Image de la catégorie">
                                    <?php else: ?>
                                        <img src="placeholder_image.jpg" class="card-img-top" alt="Image placeholder">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <p class="card-title"><?= htmlspecialchars($categorie->getType()) ?></p>
                                        <!-- <p class="card-text">ID Catégorie : <?= htmlspecialchars($categorie->getIdCategorie()) ?></p> -->
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

        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0" style="color: black;">
            <div class="container">
                <div class="row">
                    <?php if (isset($commentaires) && !empty($commentaires)): ?>
                        <?php foreach ($commentaires as $commentaire): ?>
                            <div class="col-md-4">
                                <div class="card" style="margin: 20px 0;">
                                    <div class="card-body">
                                        <h5 class="card-title">Commentaire</h5>
                                        <p class="card-text">Message : <?= htmlspecialchars($commentaire->getMessage()) ?></p>
                                        <p class="card-text">

                                            <!-- <form action="<?= HOME_URL . 'dashboardAdmin/deleteCommentaire' ?>" method="POST" style="display: inline;">
                                    <input type="hidden" name="Id_Commentaire" value="<?= $commentaire->getIdCommentaire() ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">Supprimer</button>
                                </form> -->
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