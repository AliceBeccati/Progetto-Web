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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">

    <header class="bg-danger text-white py-3 mb-4 shadow-sm">
        <div class="container text-center">
            <h1 class="fw-bold">🍽 MensaMate</h1>
            <p class="mb-0">Prenotazioni – Tavolate – Piatti del Giorno</p>
        </div>
    </header>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <div class="container">

            <a class="navbar-brand" href="index.php">Home</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>"
                           href="login.php">Login</a>
                    </li>

                    <?php if (isset($_SESSION["user"])) : ?>
                        
                        <?php if ($_SESSION["user"]["ruolo"] === "admin") : ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active' : ''; ?>"
                                   href="admin.php">Area Admin</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'utente.php' ? 'active' : ''; ?>"
                                   href="utente.php">Area Utente</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link text-warning" href="logout.php">Logout</a>
                        </li>

                    <?php endif; ?>

                </ul>
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

    <script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
