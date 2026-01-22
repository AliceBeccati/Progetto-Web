<?php
require_once 'bootstrap.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

$templateParams["titolo"] = "Inserisci Nuovo Piatto";
$templateParams["navbar"] = "admin";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $nome = $_POST["nome"];
    $descrizione = $_POST["descrizione"];
    $prezzo = $_POST["prezzo"];
    $foto = $_POST["foto"];
    $emailAdmin = $_SESSION["user"]["email"];

    $esitoInserimento = $dbh->inserisciPiatto($nome, $descrizione, $prezzo, $foto, $emailAdmin);
    
    if ($esitoInserimento) {
        header("Location: admin.php");
    } else {
        $templateParams["errorelogin"] = "Inserimento piatto fallito! Errore tecnico.";
    }
    
}

$templateParams["nome"] = "template/inserisci-piatto-form.php";

require  __DIR__ . '/template/base.php';
