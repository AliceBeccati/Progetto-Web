<?php
require_once 'bootstrap.php';

// LOGOUT
if (isset($_GET["logout"])) {
    session_unset();
    session_destroy();

    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }

    header("Location: index.php");
}

// CHECK LOGIN
if (isset($_SESSION["user"])) {
    if (isset($_SESSION["user"]["ruolo"]) && $_SESSION["user"]["ruolo"] === "admin") {
        header("Location: admin.php");
    } else {
        header("Location: utente.php");
    }
}

header("Location: login.php");
