<div class="row justify-content-center mt-4 g-3">
  <div class="col-md-5">
    <div class="border bg-white p-3 h-100 text-center"> <h3 class="h6 mb-2 fw-bold">Crea una tavolata</h3>
      <p class="text-muted small mb-3">Organizza e gestisci le tue tavolate.</p>
      <a class="btn btn-danger btn-sm" href="tavolate.php">Crea tavolata</a>
    </div>
  </div>

  <div class="col-md-5">
    <div class="border bg-white p-3 h-100 text-center"> <h3 class="h6 mb-2 fw-bold">Prenota un tavolo</h3>
      <p class="text-muted small mb-3">Scegli giorno, ora e numero persone.</p>
      <a class="btn btn-danger btn-sm" href="prenotazioni.php">Prenota tavolo</a>
    </div>
  </div>
</div>

<!-- TAVOLATE DI OGGI -->
<div class="row justify-content-center mt-4">
  <div class="col-10">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="h5 mb-0">Tavolate di oggi</h2>
    </div>

    <?php if(isset($templateParams["tavolate"]) && count($templateParams["tavolate"]) > 0): ?>

      <!-- DESKTOP/TABLET -->
      <div class="d-none d-md-block">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <div></div>
              <th>Titolo</th>
              <th>Ora</th>
              <th>Stato</th>
              <th>Partecipanti</th>
              <th>Organizzatore</th>
              <th class="text-end">Quantità</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($templateParams["tavolate"] as $tavolata): ?>
              <?php
                $aperta = (strtolower($tavolata["stato"]) === "aperta");
                $pieni  = ((int)$tavolata["num_persone_partecipanti"] >= (int)$tavolata["max_persone"]);
                $giaDentro = ((int)$tavolata["gia_partecipa"] === 1);

                $mioRuolo = strtolower(trim($tavolata["mio_ruolo"] ?? ""));
                $puoiAnnullare = $giaDentro && ($mioRuolo !== "organizzatore");

                $puoiPartecipare = $aperta && !$pieni && !$giaDentro;
                $puoiPrenotare = ($mioRuolo === "organizzatore") && $pieni;
              ?>
              <tr>
                <td class="fw-semibold"><?php echo $tavolata["titolo"]; ?></td>
                <td><?php echo substr($tavolata["ora"], 0, 5); ?></td>
                <td><?php echo $tavolata["stato"]; ?></td>
                <td><?php echo (int)$tavolata["num_persone_partecipanti"]; ?> / <?php echo (int)$tavolata["max_persone"]; ?></td>
                <td><?php echo $tavolata["organizzatore"] ?? "-"; ?></td>

                <td class="text-end">
                  <?php if($puoiPartecipare): ?>
                    <a class="btn btn-sm btn-dark"
                       href="partecipazione-tavolata.php?action=join&id_tavolata=<?php echo (int)$tavolata["id_tavolata"]; ?>">
                      Partecipa
                    </a>

                  <?php elseif($puoiAnnullare): ?>
                    <a class="btn btn-sm btn-outline-danger"
                       href="partecipazione-tavolata.php?action=leave&id_tavolata=<?php echo (int)$tavolata["id_tavolata"]; ?>">
                      Annulla
                    </a>

                  <?php elseif($puoiPrenotare): ?>
                    <form method="post" action="prenota-da-tavolata.php" class="d-inline">
                      <input type="hidden" name="id_tavolata" value="<?php echo (int)$tavolata["id_tavolata"]; ?>">
                      <button class="btn btn-sm btn-primary" type="submit">Prenota</button>
                    </form>

                  <?php else: ?>
                    <button class="btn btn-sm btn-outline-secondary" disabled>
                      <?php
                        if ($giaDentro) echo "Già dentro";
                        else echo ($pieni ? "Piena" : "Chiusa");
                      ?>
                    </button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- MOBILE -->
      <div class="d-md-none">
        <?php foreach($templateParams["tavolate"] as $tavolata): ?>
          <?php
            $aperta = (strtolower($tavolata["stato"]) === "aperta");
            $pieni  = ((int)$tavolata["num_persone_partecipanti"] >= (int)$tavolata["max_persone"]);
            $giaDentro = ((int)$tavolata["gia_partecipa"] === 1);

            $mioRuolo = strtolower(trim($tavolata["mio_ruolo"] ?? ""));
            $puoiAnnullare = $giaDentro && ($mioRuolo !== "organizzatore");

            $puoiPartecipare = $aperta && !$pieni && !$giaDentro;
            $puoiPrenotare = ($mioRuolo === "organizzatore") && $pieni;
          ?>
          <div class="border bg-white p-3 mb-3">
            <div class="d-flex justify-content-between align-items-start gap-2">
              <div class="fw-semibold"><?php echo $tavolata["titolo"]; ?></div>
              <span class="badge bg-light text-dark border">
                <?php echo substr($tavolata["ora"], 0, 5); ?>
              </span>
            </div>

            <div class="text-muted small mt-1">
              Organizzatore: <?php echo $tavolata["organizzatore"] ?? "-"; ?>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-2">
              <span class="badge <?php echo $aperta ? 'bg-success' : 'bg-secondary'; ?>">
                <?php echo $tavolata["stato"]; ?>
              </span>
              <div class="fw-semibold">
                <?php echo (int)$tavolata["num_persone_partecipanti"]; ?> / <?php echo (int)$tavolata["max_persone"]; ?>
              </div>
            </div>

            <div class="mt-3">
              <?php if($puoiPartecipare): ?>
                <a class="btn btn-dark btn-sm w-100"
                   href="partecipazione-tavolata.php?action=join&id_tavolata=<?php echo (int)$tavolata["id_tavolata"]; ?>">
                  Partecipa
                </a>

              <?php elseif($puoiAnnullare): ?>
                <a class="btn btn-outline-danger btn-sm w-100"
                   href="partecipazione-tavolata.php?action=leave&id_tavolata=<?php echo (int)$tavolata["id_tavolata"]; ?>">
                  Annulla
                </a>

              <?php elseif($puoiPrenotare): ?>
                <form method="post" action="prenota-da-tavolata.php">
                  <input type="hidden" name="id_tavolata" value="<?php echo (int)$tavolata["id_tavolata"]; ?>">
                  <button class="btn btn-primary btn-sm w-100" type="submit">Prenota</button>
                </form>

              <?php else: ?>
                <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                  <?php
                    if ($giaDentro) echo "Già dentro";
                    else echo ($pieni ? "Piena" : "Chiusa");
                  ?>
                </button>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    <?php else: ?>
      <div class="alert alert-secondary">
        Oggi non ci sono tavolate.
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- PRENOTAZIONI -->
<div class="row justify-content-center mt-4">
  <div class="col-10">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="h5 mb-0">Le mie prenotazioni</h2>
    </div>

    <?php if(isset($templateParams["mie_prenotazioni"]) && count($templateParams["mie_prenotazioni"]) > 0): ?>

      <!-- DESKTOP/TABLET -->
      <div class="d-none d-md-block">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th>Data</th>
              <th>Orario</th>
              <th>Posti</th>
              <th>Tavolo</th>
              <th>Stato</th>
              <th class="text-end">Elimina</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($templateParams["mie_prenotazioni"] as $pren): ?>
              <tr>
                <td><?php echo date("d/m/Y", strtotime($pren["data"])); ?></td>
                <td><?php echo substr($pren["ora_inizio"], 0, 5); ?> - <?php echo substr($pren["ora_fine"], 0, 5); ?></td>
                <td><?php echo (int)$pren["nPosti"]; ?></td>
                <td>Tavolo <?php echo $pren["id_tavolo"]; ?></td>
                <td>
                  <span class="badge <?php echo ($pren['stato'] === 'attiva' ? 'bg-success' : 'bg-secondary'); ?>">
                    <?php echo ucfirst($pren["stato"]); ?>
                  </span>
                </td>
                <td class="text-end">
                  <form action="utente.php" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare la prenotazione?');">
                    <input type="hidden" name="id_pren" value="<?php echo (int)$pren["id_pren"]; ?>">
                    <input type="hidden" name="azione" value="elimina prenotazione">
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="bi bi-trash"></i> Elimina
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- MOBILE -->
      <div class="d-md-none">
        <?php foreach($templateParams["mie_prenotazioni"] as $pren): ?>
          <div class="border bg-white p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="fw-bold"><?php echo date("d/m/Y", strtotime($pren["data"])); ?></span>
              <span class="badge <?php echo ($pren['stato'] === 'attiva' ? 'bg-success' : 'bg-secondary'); ?>">
                <?php echo ucfirst($pren["stato"]); ?>
              </span>
            </div>
            <div class="text-muted small">
              <i class="bi bi-clock"></i> <?php echo substr($pren["ora_inizio"], 0, 5); ?> - <?php echo substr($pren["ora_fine"], 0, 5); ?>
            </div>
            <div class="text-muted small">
              <i class="bi bi-people"></i> <?php echo (int)$pren["nPosti"]; ?> persone
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
              <span class="fw-semibold small text-primary">Tavolo <?php echo $pren["id_tavolo"]; ?></span>

              <form action="utente.php" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare la prenotazione?');">
                <input type="hidden" name="id_pren" value="<?php echo (int)$pren["id_pren"]; ?>">
                <input type="hidden" name="azione" value="elimina prenotazione">
                <button type="submit" class="btn btn-sm btn-danger">
                  <i class="bi bi-trash"></i> Elimina
                </button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    <?php else: ?>
      <div class="alert alert-secondary">
        Non hai ancora effettuato prenotazioni.
      </div>
    <?php endif; ?>

  </div>
</div>



<!-- PIATTI DEL GIORNO -->
 <?php require_once __DIR__ . "/../utils/piatti_carousel.php"; ?>

<div class="row justify-content-center mt-5">
  <div class="col-10">
  
    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
      <h2 class="h5 mb-0">Piatti del giorno</h2>
    </div>

    <?php if(!empty($templateParams["piatti"])): ?>
    <?php $piatti = $templateParams["piatti"]; ?>

    <div class="d-md-none"><?php renderPiattiCarousel("piattiCarouselMobile", $piatti, 1); ?></div>
    <div class="d-none d-md-block"><?php renderPiattiCarousel("piattiCarouselDesktop", $piatti, 3); ?></div>

  <?php else: ?>
    <div class="alert alert-warning text-center mt-3">Non ci sono ancora piatti nel menu.</div>
  <?php endif; ?>

  </div>
</div>
