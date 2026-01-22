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

/* recupero tavolata solo se sono l'organizzatore */
$t = $dbh->getMiaTavolataById($idTavolata, $email);

if (!$t) {
  header("Location: utente.php?err=non_organizzatore_o_tavolata_non_trovata");
  exit;
}

$data = $t["data"];       
$oraInizio = substr($t["ora"], 0, 5);
$nPosti = (int)$t["max_persone"];

$oraFine = date("H:i", strtotime($oraInizio . " +1 hour")); //ora_fine durata fissa (1 ora)

$idTavolo = $dbh->trovaTavoloDisponibile($data, $oraInizio, $oraFine, $nPosti);

if ($idTavolo) {
  $ok = $dbh->inserisciPrenotazione($oraInizio, $oraFine, $data, $nPosti, $email, $idTavolo);

  if ($ok) {
    $dbh->setTavolataPrenotata($idTavolata);
    header("Location: utente.php?msg=prenotazione_creata");
    exit;
  }
}

header("Location: utente.php?err=prenotazione_fallita");
exit;
