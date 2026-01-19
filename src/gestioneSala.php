<?php

require_once 'bootstrap.php';

if (!isset($_SESSION["user"]) || $_SESSION["user"]["ruolo"] != "admin") {
    header("Location: login.php");
}

// Gestione dell'archiviazione
if (isset($_POST["azione"]) && $_POST["azione"] === "archivia") {
    $idPren = $_POST["id_pren"];
    $dbh->archiviaPrenotazione($idPren);
}

$templateParams["titolo"] = "Gestione Sala";
$templateParams["prenotazioni"] = $dbh->getPrenotazioniAttive();
$templateParams["nome"] = "template/sala-form.php";
$templateParams["navbar"] = "admin";

require 'template/base.php';
?>
