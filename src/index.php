<?php
require_once 'bootstrap.php';

if (isset($_SESSION["user"])) {
  if ($_SESSION["user"]["ruolo"] === "admin") header("Location: admin.php");
  else header("Location: utente.php");
}

$templateParams["titolo"] = "MensaMate";
$templateParams["nome"]   = "template/home.php";
$templateParams["navbar"] = "public";

require  __DIR__ . '/template/base.php';
