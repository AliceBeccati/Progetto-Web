<?php
require_once 'bootstrap.php';

$templateParams["navbar"] = "public";
$templateParams["titolo"] = "Informativa sulla Privacy";
$templateParams["nome"]   = "template/privacy-page.php";

require  __DIR__ . '/template/base.php';
