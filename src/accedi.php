<?php
require_once 'bootstrap.php';

if (isset($_SESSION["user"])) {
    if (isset($_SESSION["user"]["ruolo"]) && $_SESSION["user"]["ruolo"] === "admin") {
        header("Location: admin.php");
    } else {
        header("Location: utente.php");
    }
    exit;
}

header("Location: login.php");
exit;
