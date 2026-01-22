<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Registrazione";
$templateParams["navbar"] = "public";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $name     = $_POST["name"] ?? "";
    $bio      = $_POST["bio"] ?? "";

    $esitoRegistrazione = $dbh->registrazione($name, $bio, $email, $password);

    if ($esitoRegistrazione) {
            header("Location: login.php");
    } else {
        $templateParams["errorelogin"] = "Registrazione fallita! Email già presente o errore tecnico.";
    }
    
}

$templateParams["nome"] = "template/reg-form.php";

require  __DIR__ . '/template/base.php';