<?php
require_once 'bootstrap.php';

// if (!isset($_SESSION["user"]) || $_SESSION["user"]["ruolo"] !== "admin")
$templateParams["titolo"] = "Area amministratore";
$templateParams["nome"]   = "template/admin-home.php";

require  __DIR__ . '/template/base.php';
