<?php

include __DIR__ . '/../../Includes/header.php';
include __DIR__ . '/../../Includes/navbar.php';

use src\Repositories\CategorieRepository;

?>

<div class="createArticle">
    <h2> Créer un article </h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo $_GET['error']; ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
    <?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center">
        <form class="w-50" method="POST" action="<?= HOME_URL . 'createArticle' ?>">
            <div class="mb-3 my-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" id="titre" required>
            </div>
            <div class="mb-3 my-3">
                <label for="texte" class="form-label">Texte</label>
                <textarea class="form-control" name="texte" id="texte" style="height: 100px" required></textarea>
            </div>
            <div class="mb-3 my-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" id="date" required>
            </div>
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Image</label>
                <input type="text" name="image" class="form-control" id="image">
            </div>

            <div class="mb-3 my-3">
                <label for="categorie" class="form-label">Catégorie</label>
                <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                    <option selected>Sélectionner la catégorie</option>
                    
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= $categorie['Id_Categorie'] ?></option>
                        <?php endforeach; ?>

                </select>
            </div>


                <button type=" submit" class="btn btn-primary">Créer l'article</button>
        </form>

        </form>
    </div>


    <?php

    include __DIR__ . '/../../Includes/footer.php';

    ?>