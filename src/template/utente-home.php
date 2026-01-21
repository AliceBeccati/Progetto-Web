<div class="row mt-4 g-3">
  <div class="col-md-6">
    <div class="border bg-white p-4 h-100">
      <h3 class="h5 mb-2">Crea una tavolata</h3>
      <p class="text-muted mb-3">Organizza un gruppo e condividi il codice con gli amici.</p>
      <a class="btn btn-primary" href="tavolate.php">Crea tavolata</a>
    </div>
  </div>

  <div class="col-md-6">
    <div class="border bg-white p-4 h-100">
      <h3 class="h5 mb-2">Prenota un tavolo</h3>
      <p class="text-muted mb-3">Scegli giorno, ora e numero persone.</p>
      <a class="btn btn-outline-primary" href="prenotazioni.php">Prenota tavolo</a>
    </div>
  </div>
</div>

<!-- TAVOLATE DI OGGI: tabella su desktop, card su mobile (no scroll) -->
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
              <th>Titolo</th>
              <th>Ora</th>
              <th>Stato</th>
              <th>Partecipanti</th>
              <th>Organizzatore</th>
              <th class="text-end">Azione</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($templateParams["tavolate"] as $tavolata): ?>
              <?php
                $aperta = (strtolower($tavolata["stato"]) === "aperta");
                $pieni  = ((int)$tavolata["num_persone_partecipanti"] >= (int)$tavolata["max_persone"]);
                $giaDentro = ((int)$tavolata["gia_partecipa"] === 1);

                // se stai usando anche mio_ruolo nella query:
                $mioRuolo = strtolower($tavolata["mio_ruolo"] ?? "");
                $puoiAnnullare = $giaDentro && ($mioRuolo !== "organizzatore");

                $puoiPartecipare = $aperta && !$pieni && !$giaDentro;
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

            $mioRuolo = strtolower($tavolata["mio_ruolo"] ?? "");
            $puoiAnnullare = $giaDentro && ($mioRuolo !== "organizzatore");

            $puoiPartecipare = $aperta && !$pieni && !$giaDentro;
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
<!-- Prenotazioni -->
<div class="row justify-content-center mt-4">
  <div class="col-10">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="h5 mb-0">Le mie prenotazioni</h2>
    </div>

    <?php if(isset($templateParams["mie_prenotazioni"]) && count($templateParams["mie_prenotazioni"]) > 0): ?>

      <div class="d-none d-md-block">
        <div class="bg-white border">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Data</th>
                <th>Orario</th>
                <th>Posti</th>
                <th>Tavolo</th>
                <th>Stato</th>
                <th>Elimina</th>
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
                  <td>
                      <form action="utente.php" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare la prenotazione?');">
                          <input type="hidden" name="id_pren" value="<?php echo $pren["id_pren"]; ?>">
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
      </div>

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
            <div class="mt-2 fw-semibold small text-primary">
              Tavolo <?php echo $pren["id_tavolo"]; ?>
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

<!-- PIATTI DEL GIORNO - BOOTSTRAP CAROUSEL (solo HTML/PHP, niente CSS) -->
<div class="row justify-content-center">
  <div class="col-10">

    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
      <h2 class="h5 mb-0">Piatti del giorno</h2>
    </div>

    <?php if(isset($templateParams["piatti"]) && count($templateParams["piatti"]) > 0): ?>
      <?php
        $piatti = $templateParams["piatti"];
        $perSlide = 3; // quante card per slide (desktop)
        $chunks = array_chunk($piatti, $perSlide);
      ?>

      <div id="piattiCarousel" class="carousel slide" data-bs-ride="false" data-bs-interval="false">
        <?php if(count($chunks) > 1): ?>
          <div class="carousel-indicators">
            <?php for($i=0; $i<count($chunks); $i++): ?>
              <button type="button"
                      data-bs-target="#piattiCarousel"
                      data-bs-slide-to="<?php echo $i; ?>"
                      class="<?php echo ($i===0 ? 'active' : ''); ?>"
                      aria-label="Slide <?php echo $i+1; ?>"></button>
            <?php endfor; ?>
          </div>
        <?php endif; ?>

        <div class="carousel-inner">

          <?php foreach($chunks as $i => $group): ?>
            <div class="carousel-item <?php echo ($i === 0 ? 'active' : ''); ?>">
              <div class="row g-3">
                <?php foreach($group as $piatto): ?>
                  <div class="col-12 col-md-6 col-lg-4">
                    <article class="bg-white border p-3 h-100">
                      <div class="mb-2">
                        <img src="img/<?php echo $piatto['foto']; ?>"
                             alt="<?php echo $piatto['nome']; ?>"
                             class="w-100"
                             style="height:140px; object-fit:cover;">
                      </div>

                      <div class="fw-semibold"><?php echo $piatto['nome']; ?></div>
                      <div class="text-muted small"><?php echo $piatto['descrizione']; ?></div>
                      <div class="fw-bold text-danger mt-2">€ <?php echo $piatto['prezzo']; ?></div>
                    </article>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>

        </div>

        <?php if(count($chunks) > 1): ?>
          <button class="carousel-control-prev" type="button" data-bs-target="#piattiCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Precedente</span>
          </button>

          <button class="carousel-control-next" type="button" data-bs-target="#piattiCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Successivo</span>
          </button>
        <?php endif; ?>

      </div>

    <?php else: ?>
      <div class="alert alert-warning text-center mt-3">
        Non ci sono ancora piatti nel menu.
      </div>
    <?php endif; ?>

  </div>
</div>

