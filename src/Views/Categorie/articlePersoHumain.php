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
            <div class="col-md-8 d-flex flex-column justify-content-center" style="margin-top: 20px; margin-bottom: 35px;">

                <?php if (!empty($article->getImage())): ?>
                    <img src="<?= htmlspecialchars($article->getImage()) ?>" class="img-fluid" alt="Image de l'article" style="width: 100%; height: 340px; object-fit: cover; margin-bottom: 20px;">
                <?php else: ?>
                    <img src="placeholder_image.jpg" class="img-fluid" alt="Image placeholder" style="width: 100%; height: 200px; object-fit: cover; margin-bottom: 20px;">
                <?php endif; ?>
            </div>

            <div class="card" style="width: 100%; background-color: black; color: white">
                <div>
                    <h4 style="margin-bottom: 15px">
                        <?= htmlspecialchars($article->getTitre()) ?>
                    </h4>
                    <p style="margin: 0 0 60px 0">
                        <?= htmlspecialchars($article->getTexte()) ?>
                    </p>
                </div>

                <?php if (!empty($humain)) : ?>
                    <div class="d-flex flex-column justify-content-center align-items-center" style="width: 100%; background-color: black; color: white;">
                        <h4>Fiche personnage</h4>
                        <div class="p-5 m-4" style=" border: 2px solid #FF8FC3; border-radius: 5px;">
                            <p>Prénom : <?= htmlspecialchars($humain->getPrenom()) ?> </p>
                            <p>Nom : <?= htmlspecialchars($humain->getNom()) ?></p>
                            <p>Âge : <?= htmlspecialchars($humain->getAge()) ?></p>
                            <p>Taille : <?= htmlspecialchars($humain->getTaille()) ?></p>
                            <p>Anniversaire : <?= htmlspecialchars($humain->getAnniversaire()) ?></p>
                            <p>Affiliation : <?= htmlspecialchars($humain->getAffiliation()) ?></p>
                        </div>
                    </div>


                <?php endif; ?>

            </div>
        <?php else: ?>
            <p>Aucun article trouvé.</p>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-center">
        <div class="bar m-5">
            <p>____________________________________________________________________</p>
        </div>
    </div>

    <div style="margin: 30px 0 30px 0">
        <h4>Commentaires</h4>
        <?php if (isset($utilisateur)) { ?>
            <form action="<?= HOME_URL . 'categorie/' . urlencode($categorie->getType()) . '/article?id=' . $article->getIdArticle(); ?>" method="POST">
                <div class="mb-3 my-3">
                    <label for="texte" class="form-label">Ajoutez un commentaire</label>
                    <textarea class="form-control" name="commentaire" id="commentaire" style="height: 80px;"></textarea>

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

                    <div class="card mb-3" style="background-color: black; color: white;">
                        <div class="mb-3 my-3">
                            <p class="card-title" style="font-weight: bold">
                                <?= htmlspecialchars($utilisateur->getPrenom()) . ' ' . htmlspecialchars($utilisateur->getNom()) ?>
                            </p>
                            <p class="card-text"><?= htmlspecialchars($commentaire->getMessage()) ?></p>
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