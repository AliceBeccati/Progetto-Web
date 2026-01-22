<?php
require_once __DIR__ . '/bootstrap.php';

$templateParams["titolo"] = "Chi siamo | MensaMate";
$templateParams["nome"] = __DIR__ . '/template/chi-siamo-page.php';

if (!isset($_SESSION)) {
    session_start();
}

// chi-siamo è sempre visibile e navbar si deve adattare al ruolo
if (!isset($_SESSION["user"])) {
    $templateParams["navbar"] = "public";
} else {
    $ruolo = strtolower(trim($_SESSION["user"]["ruolo"] ?? ""));

    if ($ruolo === "admin") {
        $templateParams["navbar"] = "admin";
    } else {
        $templateParams["navbar"] = "user";
    }
}

require_once __DIR__ . '/template/base.php';
?>