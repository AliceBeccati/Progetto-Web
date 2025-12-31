<?php
require_once 'bootstrap.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$idTavolata = isset($_GET["id_tavolata"]) ? (int)$_GET["id_tavolata"] : 0;
if ($idTavolata <= 0) {
    header("Location: utente.php");
    exit;
}

$email = $_SESSION["user"]["email"];

$ok = $dbh->partecipaTavolata($idTavolata, $email);

header("Location: utente.php");
exit;
