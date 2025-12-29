<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Area utente";
$templateParams["nome"]   = "template/utente-home.php";

$templateParams["piatti"] = $dbh->getPiatto();

require  __DIR__ . '/template/base.php';
