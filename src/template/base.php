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
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <header class="bg-danger text-white">
        <div class="container py-3 text-center">
            <a href="index.php" class="fw-bold mb-1 text-decoration-none text-white">
                <h1>🍽️ MensaMate</h1>
            </a>
            <p class="mb-0 opacity-75">
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

                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="chi-siamo.php">Chi siamo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="privacy.php">Privacy</a>
                        </li>
                    </ul>

                    <?php if (isset($templateParams["titolo"]) && ($templateParams["titolo"] === "Area utente" || $templateParams["titolo"] === "Area Amministrazione")): ?>
                        <div class="d-flex">
                            <a href="login.php" class="btn btn-outline-light">
                                Logout
                            </a>
                        </div>
                        <?php /*
                        <button class="btn btn-outline-light border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuUtente" aria-controls="menuUtente">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
    </svg>
</button>*/ ?>
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
            <?php
            /*
                <div class="offcanvas offcanvas-end" tabindex="-1" id="menuUtente" aria-labelledby="menuUtenteLabel">
            
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold" id="menuUtenteLabel">Menu Utente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                
                <p>Benvenuto!</p>
                <hr>
                
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="profilo.php" class="text-decoration-none text-dark fs-5">👤 Il mio Profilo</a></li>
                    <li class="mb-3"><a href="ordini.php" class="text-decoration-none text-dark fs-5">📦 I miei Ordini</a></li>
                    <li class="mb-3"><a href="impostazioni.php" class="text-decoration-none text-dark fs-5">⚙️ Impostazioni</a></li>
                </ul>

                <hr>
                <a href="logout.php" class="btn btn-danger w-100">Logout</a>

            </div>
            </div>*/
            ?>
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-1">MensaMate – Progetto Web</p>
            <small>Creato da Alice&Matteo.srl • <?php echo date("Y"); ?></small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>
</html>
