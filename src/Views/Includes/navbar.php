<nav class="navbar navbar-expand-lg bg-black">
    <div class="container-fluid">
        <a class="navbar-brand" style="color: #ff8fc3;" href="<?= HOME_URL . 'accueil' ?>">SNK</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link " style="color: #ff8fc3;" href="<?= HOME_URL . 'accueil' ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: #ff8fc3;" href="<?= HOME_URL . 'categorie' ?>">Catégorie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: #ff8fc3;" href="<?= HOME_URL . 'aPropos' ?>">À propos</a>
                </li>

                <?php if (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true): ?>
                    <!-- Si un utilisateur normal est connecté -->
                    <li class="nav-item">
                        <a class="nav-link" style="color: #ff8fc3;" href="<?= HOME_URL . 'dashboard' ?>">Mon compte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #ff8fc3;" href="<?= HOME_URL . 'deconnexion' ?>">Déconnexion</a>
                    </li>
                <?php elseif (isset($_SESSION['adminConnecte']) && $_SESSION['adminConnecte'] === true): ?>
                    <!-- Si un admin est connecté -->
                    <li class="nav-item">
                        <a class="nav-link" style="color: #ff8fc3;" href="<?= HOME_URL . 'dashboardAdmin' ?>">Dashboard admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #ff8fc3;" href="<?= HOME_URL . 'deconnexion' ?>">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <!-- Si personne n'est connecté -->
                    <li class="nav-item">
                        <a class="nav-link" style="color: #ff8fc3;" href="<?= HOME_URL . 'connexion' ?>">Connexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>