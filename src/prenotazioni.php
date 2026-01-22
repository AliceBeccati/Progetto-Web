<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Prenotazione";
$templateParams["navbar"] = "user";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = $_POST["data"];
    $oraInizio = $_POST["ora_inizio"];
    $oraFine = $_POST["ora_fine"];
    $nPosti = $_POST["n_posti"];
    $emailAdmin = $_SESSION["user"]["email"]; // Email dell'admin loggato

    // 1. Cerchiamo un tavolo libero
    $idTavolo = $dbh->trovaTavoloDisponibile($data, $oraInizio, $oraFine, $nPosti);

if ($idTavolo) {
    // Assicurati che l'ordine dei parametri sia lo stesso definito in database.php
    $successo = $dbh->inserisciPrenotazione($oraInizio, $oraFine, $data, $nPosti, $emailAdmin, $idTavolo);
    
    if ($successo) {
        // Usa utente-home.php se l'utente è un cliente standard
        header("Location: utente.php");
        exit;
    } else {
        $templateParams["errore_pren"] = "Errore durante il salvataggio dei dati.";
    }
} else {
    $templateParams["errore_pren"] = "Nessun tavolo disponibile per i posti e l'orario richiesti.";
}
}

$templateParams["nome"] = "template/prenotazione-form.php";

require  __DIR__ . '/template/base.php';