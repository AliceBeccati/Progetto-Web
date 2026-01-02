<?php
require_once 'bootstrap.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

$email = $_SESSION["user"]["email"];
$templateParams["titolo"] = "Gestione Tavolate";
$templateParams["nome"]   = "template/tavolate-utente.php";
$templateParams["navbar"] = "user";

// POST: crea o modifica
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $idTavolata = isset($_POST["id_tavolata"]) ? (int)$_POST["id_tavolata"] : 0;
    $titolo     = $_POST["titolo"] ?? "";
    $data       = $_POST["data"] ?? "";
    $ora        = $_POST["ora"] ?? "";
    $maxPersone = isset($_POST["max_persone"]) ? (int)$_POST["max_persone"] : 0;

    $ok = false;

    if ($titolo !== "" && $data !== "" && $ora !== "" && $maxPersone > 0) {
        if ($idTavolata > 0) {
            $ok = $dbh->aggiornaTavolata($idTavolata, $titolo, $data, $ora, $maxPersone, $email);
        } else {
            $ok = $dbh->creaTavolata($titolo, $data, $ora, $maxPersone, $email);
        }
    }

    if ($ok) {
        header("Location: tavolate.php?save=ok");
        exit;
    } else {
        $templateParams["errore"] = "Salvataggio tavolata fallito.";
        // NON faccio redirect: voglio mostrare l'errore sotto al form
    }
}

// GET: dati per mostrare pagina
$editId = isset($_GET["edit"]) ? (int)$_GET["edit"] : 0;
$templateParams["tavolataEdit"] = null;

if ($editId > 0) {
    $templateParams["tavolataEdit"] = $dbh->getMiaTavolataById($editId, $email);
}

$templateParams["mieTavolate"] = $dbh->getMieTavolateOrganizzatore($email);

require __DIR__ . '/template/base.php';
