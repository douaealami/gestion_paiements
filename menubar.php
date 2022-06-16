<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-university"></i> Gestion des Paiements</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <?php if(isset($_SESSION["user_id"]) ) { ?>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-2x fa-user-circle"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <label class="dropdown-item disabled"><?php echo $_SESSION["user_username"] ?></b></label>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php"><i class="fas fa-user-logout"></i>
                                Déconnexion</a>
                        </div>
                    </li>


                </ul>
            </div>
        <?php
        }
        ?>
    </div>
</nav>
<br>