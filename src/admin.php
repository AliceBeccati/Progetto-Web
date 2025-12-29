<?php

require_once 'bootstrap.php';

if (!isset($_SESSION["user"]) || $_SESSION["user"]["ruolo"] != "admin") {
    header("Location: login.php");
    exit;
}

$templateParams["titolo"] = "Area Amministrazione";
$templateParams["nome"] = "template/admin-home.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["azione"]) && $_POST["azione"] === "inserisci") {
        $nome = $_POST["nome"];
        $desc = $_POST["descrizione"];
        $prezzo = $_POST["prezzo"];
        $emailAdmin = $_SESSION["user"]["email"];
        
        $fotoNome = "";
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
            $fotoNome = basename($_FILES["foto"]["name"]);
            move_uploaded_file($_FILES["foto"]["tmp_name"], "img/" . $fotoNome);
        }

        $dbh->inserisciPiatto($nome, $desc, $prezzo, $fotoNome, $emailAdmin);
    }

    if (isset($_POST["azione"]) && $_POST["azione"] === "elimina") {
        $idPiatto = $_POST["id_piatto"];
        $dbh->deletePiatto($idPiatto);
    }
}


$templateParams["piatti"] = $dbh->getPiatto();

require 'template/base.php';
?>