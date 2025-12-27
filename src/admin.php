<?php
require_once 'bootstrap.php';

// if (!isset($_SESSION["user"])) { header("Location: login.php"); exit; }

$templateParams["titolo"] = "Area Amministrazione";
$templateParams["nome"]   = "template/admin-home.php";

require  __DIR__ . '/template/base.php';
