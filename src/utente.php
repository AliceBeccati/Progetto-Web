<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Area utente";
$templateParams["nome"]   = "template/utente-home.php";
$templateParams["navbar"] = "user";

$templateParams["piatti"] = $dbh->getPiatto();
$templateParams["tavolate"] = $dbh->getTavolate($_SESSION["user"]["email"]);


require  __DIR__ . '/template/base.php';
