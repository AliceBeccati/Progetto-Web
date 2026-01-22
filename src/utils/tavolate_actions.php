<?php
// funzione render per i bottoni di azione tavolate
// variant: desktop, mobile
function renderTavolataAction(array $t, string $variant = "desktop"): void
{
    $aperta    = (strtolower($t["stato"] ?? "") === "aperta");
    $pieni     = ((int)($t["num_persone_partecipanti"] ?? 0) >= (int)($t["max_persone"] ?? 0));
    $giaDentro = ((int)($t["gia_partecipa"] ?? 0) === 1);

    $mioRuolo  = strtolower(trim($t["mio_ruolo"] ?? ""));
    $prenotata = ((int)($t["prenotata"] ?? 0) === 1);

    $puoiAnnullare   = $giaDentro && ($mioRuolo !== "organizzatore");
    $puoiPartecipare = $aperta && !$pieni && !$giaDentro;
    $puoiPrenotare   = ($mioRuolo === "organizzatore") && $pieni && !$prenotata;

    $id = (int)($t["id_tavolata"] ?? 0);

    $full = ($variant === "mobile") ? " w-100" : "";
    $btnBase = "btn btn-sm";
    $btnDark = $btnBase . " btn-dark" . $full;
    $btnDangerOutline = $btnBase . " btn-outline-danger" . $full;
    $btnDisabled = $btnBase . " btn-outline-secondary" . $full;

    if ($puoiPartecipare) {
        echo '<a class="'.$btnDark.'" href="partecipazione-tavolata.php?action=join&id_tavolata='.$id.'">Partecipa</a>';
        return;
    }

    if ($puoiAnnullare) {
        echo '<a class="'.$btnDangerOutline.'" href="partecipazione-tavolata.php?action=leave&id_tavolata='.$id.'">Annulla</a>';
        return;
    }

    if ($prenotata) {
        echo '<button class="'.$btnDisabled.'" disabled>Prenota</button>';
        return;
    }

    if ($puoiPrenotare) {
        echo '<form method="post" action="prenota-da-tavolata.php" class="d-inline">
                <input type="hidden" name="id_tavolata" value="'.$id.'">
                <button class="'.$btnDark.'" type="submit">Prenota</button>
            </form>';
        return;
    }

    $label = $giaDentro ? "Già dentro" : ($pieni ? "Piena" : "Chiusa");
    echo '<button class="'.$btnDisabled.'" disabled>'.$label.'</button>';
}
