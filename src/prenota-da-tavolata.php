<?php
require_once 'bootstrap.php';

if (!isset($_SESSION["user"]["email"])) {
  header("Location: gestioneLogin.php");
  exit;
}

$email = $_SESSION["user"]["email"];

if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_POST["id_tavolata"])) {
  header("Location: utente.php");
  exit;
}

$idTavolata = (int)$_POST["id_tavolata"];

/* 1) Recupero tavolata (solo se io sono l'organizzatore) */
$t = $dbh->getMiaTavolataById($idTavolata, $email);

if (!$t) {
  header("Location: utente.php?err=non_organizzatore_o_tavolata_non_trovata");
  exit;
}

/* 2) Dati prenotazione dalla tavolata */
$data = $t["data"];                 // in TAVOLATA c'è
$oraInizio = substr($t["ora"], 0, 5);
$nPosti = (int)$t["max_persone"];

/* Se non hai ora_fine nella tavolata, scegli durata fissa (es. 1 ora) */
$oraFine = date("H:i", strtotime($oraInizio . " +1 hour"));

/* 3) Trova tavolo libero + inserisci prenotazione (come prenotazioni.php) */
$idTavolo = $dbh->trovaTavoloDisponibile($data, $oraInizio, $oraFine, $nPosti);

if ($idTavolo) {
  $ok = $dbh->inserisciPrenotazione($oraInizio, $oraFine, $data, $nPosti, $email, $idTavolo);

  if ($ok) {
    header("Location: utente.php?msg=prenotazione_creata");
    exit;
  }
}

header("Location: utente.php?err=prenotazione_fallita");
exit;
