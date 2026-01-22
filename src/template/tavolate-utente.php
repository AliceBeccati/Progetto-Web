<?php
$edit = $templateParams["tavolataEdit"] ?? null;
?>

<div class="row justify-content-center mt-4">
  <div class="col-10 col-lg-7">

    <?php if(isset($_GET["save"]) && $_GET["save"] === "ok"): ?>
      <div class="alert alert-success">Tavolata salvata.</div>
    <?php endif; ?>

    <?php if(!empty($templateParams["errore"])): ?>
      <div class="alert alert-danger"><?php echo $templateParams["errore"]; ?></div>
    <?php endif; ?>

    <div class="border bg-white p-4 mb-4">
      <h2 class="h5 mb-3"><?php echo $edit ? "Modifica tavolata" : "Crea nuova tavolata"; ?></h2>

      <form action="tavolate.php" method="POST" class="row g-3">
        <?php if($edit): ?>
          <input type="hidden" name="id_tavolata" value="<?php echo (int)$edit["id_tavolata"]; ?>">
        <?php endif; ?>

        <div class="col-12">
            <label class="form-label" for="titolo">Titolo</label>
            <input class="form-control" id="titolo" name="titolo" required value="<?php echo $edit["titolo"] ?? ""; ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label" for="data_tav">Data</label>
            <input type="date" class="form-control" id="data_tav" name="data" required value="<?php echo $edit["data"] ?? ""; ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label" for="ora_tav">Ora</label>
            <input type="time" class="form-control" id="ora_tav" name="ora" required value="<?php echo isset($edit["ora"]) ? substr($edit["ora"], 0, 5) : ""; ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label" for="max_p">Max persone</label>
            <input type="number" min="1" class="form-control" id="max_p" name="max_persone" required value="<?php echo $edit["max_persone"] ?? 2; ?>">
        </div>

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-danger" type="submit">
            <?php echo $edit ? "Salva modifiche" : "Crea tavolata"; ?>
          </button>

          <?php if($edit): ?>
            <a class="btn btn-outline-secondary" href="tavolate.php">Annulla</a>
          <?php endif; ?>
        </div>
      </form>
    </div>

    <div class="border bg-white p-4">
      <h3 class="h6 mb-3">Le mie tavolate (organizzatore)</h3>

      <?php if(!empty($templateParams["mieTavolate"])): ?>
        <div class="list-group">
          <?php foreach($templateParams["mieTavolate"] as $t): ?>
            <div class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold"><?php echo $t["titolo"]; ?></div>
                <div class="text-muted small">
                  <?php echo $t["data"]; ?> • <?php echo substr($t["ora"],0,5); ?> • Stato: <?php echo $t["stato"]; ?>
                </div>
              </div>
              <button type="button"
        class="btn btn-sm btn-outline-dark"
        data-bs-toggle="modal"
        data-bs-target="#modalModificaTavolata"
        data-bs-id="<?php echo (int)$t['id_tavolata']; ?>"
        data-bs-titolo="<?php echo $t['titolo']; ?>"
        data-bs-data="<?php echo $t['data']; ?>"
        data-bs-ora="<?php echo substr($t['ora'], 0, 5); ?>"
        data-bs-max="<?php echo (int)$t['max_persone']; ?>">
  Modifica
</button>

            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-secondary mb-0">Non hai ancora creato tavolate.</div>
      <?php endif; ?>
    </div>

  </div>
</div>

<div class="modal fade" id="modalModificaTavolata" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <div class="modal-header bg-danger text-white">
      <h3 class="modal-title">Modifica Tavolata</h3>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Chiudi"></button>
    </div>

      <form action="tavolate.php" method="POST">
        <div class="modal-body">
          <input type="hidden" name="id_tavolata" id="t-edit-id">

          <div class="mb-3">
              <label class="form-label" for="t-edit-titolo">Titolo</label>
              <input class="form-control" name="titolo" id="t-edit-titolo" required>
          </div>

          <div class="row g-2">
              <div class="col-md-6">
                  <label class="form-label" for="t-edit-data">Data</label>
                  <input type="date" class="form-control" name="data" id="t-edit-data" required>
              </div>
              <div class="col-md-6">
                  <label class="form-label" for="t-edit-ora">Ora</label>
                  <input type="time" class="form-control" name="ora" id="t-edit-ora" required>
              </div>
          </div>

          <div class="mt-3">
              <label class="form-label" for="t-edit-max">Max persone</label>
              <input type="number" min="1" class="form-control" name="max_persone" id="t-edit-max" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Salva</button>
        </div>
      </form>

    </div>
  </div>
</div>
<script>
  const modalT = document.getElementById('modalModificaTavolata');

  modalT.addEventListener('show.bs.modal', event => {
    const btn = event.relatedTarget;

    document.getElementById('t-edit-id').value     = btn.getAttribute('data-bs-id');
    document.getElementById('t-edit-titolo').value = btn.getAttribute('data-bs-titolo') || '';
    document.getElementById('t-edit-data').value   = btn.getAttribute('data-bs-data') || '';
    document.getElementById('t-edit-ora').value    = btn.getAttribute('data-bs-ora') || '';
    document.getElementById('t-edit-max').value    = btn.getAttribute('data-bs-max') || 2;
  });
</script>

