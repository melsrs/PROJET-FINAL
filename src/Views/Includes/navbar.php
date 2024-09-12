<nav class="navbar navbar-expand-lg bg-black">
    <div class="container-fluid">
        <a class="navbar-brand" style="color: #ff8fc3;" href="/">SNK</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" style="color: #ff8fc3;" href="/">ACCUEIL</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"style="color: #ff8fc3;" href="/categorie">CATEGORIE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: #ff8fc3;" href="/aPropos">À PROPOS</a>
                </li>
               <?php if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] === false|| $_SESSION['adminConnecte'] === false):?>
                <li class="nav-item">
                    <a class="nav-link" style="color: #ff8fc3;" href="/connexion">CONNEXION</a>
                </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #ff8fc3;" href="/monCompte">MON COMPTE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #ff8fc3;" href="/deconnexion">DÉCONNEXION</a>
                    </li>

                <?php endif;?>
            </ul>
        </div>
    </div>
</nav>
