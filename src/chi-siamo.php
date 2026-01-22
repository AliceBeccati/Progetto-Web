<?php
require_once __DIR__ . '/bootstrap.php';

$templateParams["titolo"] = "Chi siamo | MensaMate";
$templateParams["nome"] = __DIR__ . '/template/chi-siamo-page.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["user"])) {
    $templateParams["navbar"] = "public";
} else {
    // adatta la chiave al tuo array di sessione: "ruolo" / "role" / "tipo" / ecc.
    $ruolo = strtolower(trim($_SESSION["user"]["ruolo"] ?? ""));

    if ($ruolo === "admin") {
        $templateParams["navbar"] = "admin";
    } else {
        $templateParams["navbar"] = "user";
    }
}

require_once __DIR__ . '/template/base.php';
?>