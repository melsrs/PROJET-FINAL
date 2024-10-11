<?php
include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';
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
        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Mon compte</a>
        <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Commentaires</a>
    </div>
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0" style="color: black;">
            <div class="container">
                <div class="row">
                    <?php if (!empty($utilisateur)): ?>
                        <div class="col-md-8">
                            <div class="card" style="margin: 20px 0; ">
                                <div class="card-body">
                                    <h5 class="card-title">Prénom : <?= htmlspecialchars($utilisateur->getPrenom()) ?></h5>
                                    <p class="card-text">Nom : <?= htmlspecialchars($utilisateur->getNom()) ?></p>
                                    <p class="card-text">Email : <?= htmlspecialchars($utilisateur->getMail()) ?></p>
                                    <a class="btn btn-primary" href="<?= HOME_URL . 'dashboard/updateUtilisateur?id=' . $utilisateur->getIdUtilisateur() ?>">Modifier</a>
                                    <form action="<?= HOME_URL . 'dashboard/deleteUtilisateur' ?>" method="POST" style="display: inline;">
                                        <input type="hidden" name="Id_Utilisateur" value="<?= $utilisateur->getIdUtilisateur() ?>">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>Aucun utilisateur trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0" style="color: black;">
            <div class="container">
                <div class="row">
                    <?php if (!empty($commentaires)): ?>
                        <div class="col-md-8">
                            <?php foreach ($commentaires as $commentaire): ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <p class="card-text"><?= htmlspecialchars($commentaire->getMessage()) ?></p>
                                        <a href="<?= HOME_URL . 'dashboard/updateCommentaire?Id_Utilisateur=' . $commentaire->getIdUtilisateur() . '&Id_Article=' . $commentaire->getIdArticle() ?>" class="btn btn-sm btn-primary">Modifier</a>
                                        <form action="<?= HOME_URL . 'dashboard/deleteCommentaire' ?>" method="POST" style="display: inline;">
                                            <input type="hidden" name="Id_Article" value="<?= htmlspecialchars($commentaire->getIdArticle()) ?>">
                                            <input type="hidden" name="Id_Utilisateur" value="<?= htmlspecialchars($commentaire->getIdUtilisateur()) ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">Supprimer</button>
                                        </form>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>Aucun commentaire trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>