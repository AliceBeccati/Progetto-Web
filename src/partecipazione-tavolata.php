<?php
require_once 'bootstrap.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

$action = $_GET["action"] ?? "";
$idTavolata = isset($_GET["id_tavolata"]) ? (int)$_GET["id_tavolata"] : 0;
if ($idTavolata <= 0 || ($action !== "join" && $action !== "leave")) {
    header("Location: utente.php");
}

$email = $_SESSION["user"]["email"];

$ok = false;
if ($action === "join") {
    $ok = $dbh->partecipaTavolata($idTavolata, $email);
} else { // leave
    $ok = $dbh->annullaPartecipazione($idTavolata, $email);
}

header("Location: utente.php?" . $action . "=" . ($ok ? "ok" : "fail"));
