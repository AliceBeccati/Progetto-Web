<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Area utente";
$templateParams["nome"]   = "template/utente-home.php";

$templateParams["piatti"] = $dbh->getPiatto();
$templateParams["tavolate"] = $dbh->getTavolate();

require  __DIR__ . '/template/base.php';
