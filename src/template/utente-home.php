<div class="row mt-4 g-3">
  <div class="col-md-6">
    <div class="border bg-white p-4 h-100">
      <h3 class="h5 mb-2">Crea una tavolata</h3>
      <p class="text-muted mb-3">Organizza un gruppo e condividi il codice con gli amici.</p>
      <a class="btn btn-primary" href="crea-tavolata.php">Crea tavolata</a>
    </div>
  </div>

  <div class="col-md-6">
    <div class="border bg-white p-4 h-100">
      <h3 class="h5 mb-2">Prenota un tavolo</h3>
      <p class="text-muted mb-3">Scegli giorno, ora e numero persone.</p>
      <a class="btn btn-outline-primary" href="prenota-tavolo.php">Prenota tavolo</a>
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
                $puoiPartecipare = $aperta && !$pieni;
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
                       href="partecipa-tavolata.php?id_tavolata=<?php echo (int)$tavolata["id_tavolata"]; ?>">
                      Partecipa
                    </a>
                  <?php else: ?>
                    <button class="btn btn-sm btn-outline-secondary" disabled>
                      <?php echo $pieni ? "Piena" : "Chiusa"; ?>
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
            $puoiPartecipare = $aperta && !$pieni;
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
                   href="partecipa-tavolata.php?id_tavolata=<?php echo (int)$tavolata["id_tavolata"]; ?>">
                  Partecipa
                </a>
              <?php else: ?>
                <button class="btn btn-outline-secondary btn-sm w-100" disabled>
                  <?php echo $pieni ? "Piena" : "Chiusa"; ?>
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

<!-- PIATTI -->
<div class="row justify-content-center">
  <div class="col-10">
    <div class="row mt-3">
      <?php if(isset($templateParams["piatti"]) && count($templateParams["piatti"]) > 0): ?>
        <?php foreach ($templateParams["piatti"] as $piatto): ?>
          <div class="col-md-6 mb-4">
            <article class="bg-white border p-4 h-100">
              <header>
                <div class="text-center mb-3">
                  <img src="img/<?php echo $piatto['foto']; ?>"
                       alt="<?php echo $piatto['nome']; ?>"
                       style="max-height: 150px; object-fit: cover; width: 100%;">
                </div>
                <h2 class="h4"><?php echo $piatto['nome']; ?></h2>
              </header>

              <section class="flex-grow-1">
                <p class="text-muted"><?php echo $piatto['descrizione']; ?></p>
                <p class="fw-bold text-danger fs-5">€ <?php echo $piatto['prezzo']; ?></p>
              </section>
            </article>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-warning text-center">
            Non ci sono ancora piatti nel menu.
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
