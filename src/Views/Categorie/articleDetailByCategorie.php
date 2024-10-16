<?php

include __DIR__ . '/../Includes/header.php';
include __DIR__ . '/../Includes/navbar.php';

?>

<h2><?= htmlspecialchars($categorie->getType()) ?></h2>


<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="container">
    <div class="row justify-content-center">
        <?php if (!empty($article)) : ?>
            <div class="col-md-8 d-flex flex-column justify-content-center mt-5 mb-5">

                <?php if (!empty($article->getImage())): ?>
                    <img src="<?= htmlspecialchars($article->getImage()) ?>" class="img-fluid img-perso" alt="Image de l'article">
                <?php else: ?>
                    <img src="placeholder_image.jpg" class="img-fluid img-perso" alt="Image placeholder">
                <?php endif; ?>
            </div>

            <div class="card w-100 bg-black text-white">
                <div>
                    <h5 class="mb-3">
                        <?= htmlspecialchars_decode($article->getTitre()) ?>
                    </h5>
                    <p class="mb-5">
                        <?= htmlspecialchars_decode($article->getTexte()) ?>
                    </p>
                </div>
            </div>
        <?php else: ?>
            <p>Aucun article trouvé.</p>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-center">
        <div class="bar">
            <p>____________________________________________________________________</p>
        </div>
    </div>

    <div class="mt-3 mb-5">
        <h6>Commentaires</h6>
        <?php if (isset($utilisateur)) { ?>
            <form action="<?= HOME_URL . 'categorie/' . urlencode($categorie->getType()) . '/article?id=' . $article->getIdArticle(); ?>" method="POST">
                <div class="mb-3 my-3">
                    <label for="texte" class="form-label">Ajoutez un commentaire</label>
                    <textarea class="form-control" name="commentaire" id="commentaire"></textarea>

                    <input type="hidden" name="Id_Utilisateur" value="<?= isset($utilisateur) ? $utilisateur->getIdUtilisateur() : null; ?>">
                    <input type="hidden" name="Id_Article" value="<?= $article->getIdArticle(); ?>">

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary my-3 boutonConnexion">Publier</button>
                    </div>
                </div>
            </form>
        <?php } else { ?>
            <p>Pour laisser un commentaire, vous devez vous <a href="<?= HOME_URL . 'connexion' ?>" class="lien">connecter</a>.</p>
        <?php } ?>

        <?php if (!empty($commentairesAvecUtilisateurs)): ?>
            <div class="mt-4">
                <?php foreach ($commentairesAvecUtilisateurs as $item): ?>
                    <?php $commentaire = $item['commentaire']; ?>
                    <?php $utilisateur = $item['utilisateur']; ?>

                    <div class="card mb-3 bg-black text-white">
                        <div class="mb-3 my-3">
                            <p class="card-title fw-bold">
                                <?= htmlspecialchars_decode($utilisateur->getPrenom()) . ' ' . htmlspecialchars_decode($utilisateur->getNom()) ?>
                            </p>
                            <p class="card-text"><?= htmlspecialchars_decode($commentaire->getMessage()) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p></p>
        <?php endif; ?>
    </div>



    <?php

    include __DIR__ . '/../Includes/footer.php';

    ?>