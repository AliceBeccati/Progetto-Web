<?php

require_once 'bootstrap.php';

if (!isset($_SESSION["user"]) || $_SESSION["user"]["ruolo"] != "admin") {
    header("Location: login.php");
    exit;
}

$templateParams["titolo"] = "Area Amministrazione";
$templateParams["nome"] = "template/admin-home.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["azione"]) && $_POST["azione"] === "elimina") {
        $idPiatto = $_POST["id_piatto"];
        $dbh->deletePiatto($idPiatto);
    }
}

if (isset($_POST["azione"]) && $_POST["azione"] === "modifica") {
    $id = $_POST["id_piatto"];
    $nome = $_POST["nome"];
    $desc = $_POST["descrizione"];
    $prezzo = $_POST["prezzo"];
    
    $dbh->updatePiatto($id, $nome, $desc, $prezzo);
}

$templateParams["piatti"] = $dbh->getPiatto();

require 'template/base.php';
?>