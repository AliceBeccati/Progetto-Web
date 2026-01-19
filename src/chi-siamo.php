<?php
require_once __DIR__ . '/bootstrap.php';

$templateParams["navbar"] = "public";
$templateParams["titolo"] = "Chi siamo | MensaMate";
$templateParams["nome"] = __DIR__ . '/template/chi-siamo-page.php';

require_once __DIR__ . '/template/base.php';
?>