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

<body class="bg-light">

    <header class="bg-danger text-white">
        <div class="container py-3 text-center">
            <h1 class="fw-bold mb-1">
                🍽️ MensaMate
            </h1>
            <p class="mb-0 opacity-75">
                La tua tavolata in compagnia
            </p>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <!-- Bottone mobile -->
           <a class="navbar-brand d-lg-none fs-4" href="index.php" aria-label="Home">🏠</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false" aria-label="Apri menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Voci menu -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="chi-siamo.php">Chi siamo</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="privacy.php">Privacy</a>
                    </li>

                </ul>

                <!-- Bottone Login a destra -->
                <div class="d-flex">
                    <a href="login.php" class="btn btn-outline-light">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>



    <main class="container mb-5">

        <?php
        if (isset($templateParams["nome"])) {
            require($templateParams["nome"]);
        } else {
            echo "<div class='alert alert-warning'>Nessun contenuto da mostrare.</div>";
        }
        ?>

    </main>

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
