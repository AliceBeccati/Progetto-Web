<?php

if (!isset($templateParams)) {
    $templateParams = array();
}

if (!isset($templateParams["titolo"])) {
    $templateParams["titolo"] = "MensaMate";
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $templateParams["titolo"]; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <header class="bg-danger text-white">
        <div class="container py-3 text-center">
            <a href="index.php" class="fw-bold mb-1 text-decoration-none text-white">
                <h1>🍽️ MensaMate</h1>
            </a>
            <p class="mb-0 opacity-45">
                La tua tavolata in compagnia
            </p>
        </div>
    </header>

    <?php if (isset($templateParams["titolo"]) && $templateParams["titolo"] === "Login"): ?>

                <div class="bg-dark text-white text-center mb-4 py-2">
                    <h2 class="fw-bold m-0">Login</h2>
                </div>
    <?php else: ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">

                <a class="navbar-brand d-lg-none fs-4" href="index.php" aria-label="Home">🏠</a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                        aria-controls="mainNavbar" aria-expanded="false" aria-label="Apri menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <?php if (isset($templateParams["navbar"]) && ($templateParams["navbar"] === "user" || $templateParams["navbar"] === "admin")): ?>
                    <div class="d-flex align-items-center ms-auto d-lg-none">
                        <button class="btn btn-outline-light border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuUtente" aria-label="menuUtente">
                            <i class="bi bi-person-circle fs-4"></i>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php
                            // navbar utente
                            if (isset($templateParams["navbar"]) && ($templateParams["navbar"] === "user")){
                                echo '<li class="nav-item">
                                        <a class="nav-link" href="utente.php">DashBoard</a>
                                      </li>';
                                echo '<li class="nav-item">
                                        <a class="nav-link" href="prenotazioni.php">Prenotazioni</a>
                                      </li>';
                                echo '<li class="nav-item">
                                        <a class="nav-link" href="tavolate.php">Tavolate</a>
                                      </li>';
                            }

                            // navbar admin
                            if (isset($templateParams["navbar"]) && ($templateParams["navbar"] === "admin")){
                                echo '<li class="nav-item">
                                        <a class="nav-link" href="admin.php">DashBoard</a>
                                      </li>';
                                echo '<li class="nav-item">
                                        <a class="nav-link" href="gestioneSala.php">Sala</a>
                                      </li>';
                            }
                            // navbar pubblica (home)
                            if (isset($templateParams["navbar"]) && ($templateParams["navbar"] === "public")){
                                echo '<li class="nav-item">
                                        <a class="nav-link" href="index.php">Home</a>
                                    </li>';
                            }
                            
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="chi-siamo.php">Chi siamo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="privacy.php">Privacy</a>
                        </li>
                    </ul>

                    <?php if (isset($templateParams["navbar"]) && ($templateParams["navbar"] === "user" || $templateParams["navbar"] === "admin")): ?>
                        <div class="d-none d-lg-flex align-items-center gap-4 ms-auto">
                            <button class="btn btn-outline-light border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuUtente" aria-label="menuUtente">
                                <i class="bi bi-person-circle fs-4"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    <?php endif; ?>

    <main class="container mb-4 flex-grow-1">

        <?php
        if (isset($templateParams["nome"])) {
            require($templateParams["nome"]);
        } else {
            echo "<div class='alert alert-warning mt-4'>Nessun contenuto da mostrare.</div>";
        }
        ?>

    </main>

    <!-- Offcanvas menu utente -->
    <div class="bg-light offcanvas offcanvas-end" tabindex="-1" id="menuUtente" aria-labelledby="menuUtenteLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title fw-bold" id="menuUtenteLabel">Menu Utente</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
        
            <?php
                if(isset($_SESSION["user"])) {
                    require __DIR__ . '/sidebar-utente.php';
                } else {
                    echo "<p>Effettua il login per vedere i tuoi dati.</p>";
                }
            ?>

        </div>
    </div>
    
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-1">MensaMate – Progetto Web</p>
            <small>Creato da Alice&Matteo.srl • <?php echo date("Y"); ?></small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src="scripts/mod_piatto.js"></script>
    <script src="scripts/prenotazione.js"></script>

</body>
</html>
