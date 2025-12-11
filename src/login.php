<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Login";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $user = $dbh->checkLogin($email, $password);

    if ($user) {
        $_SESSION["user"] = $user;
        if ($user["ruolo"] === "admin") {
            header("Location: admin.php");
        } else {
            header("Location: utente.php");
        }
        exit;
    } else {
        $templateParams["errorelogin"] = "Credenziali non valide.";
    }
}

$templateParams["nome"] = "template/login-form.php";

require  __DIR__ . '/template/base.php';
