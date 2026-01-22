<?php
// funzione render per non duplicare codice carousel piatti tra pc e mobile
// scelgo quanti piatti per slide
function renderPiattiCarousel($id, $piatti, $perSlide) {
  $chunks = array_chunk($piatti, $perSlide);
  $colClass = ($perSlide == 2) ? "col-6" : "col-12 col-md-6 col-lg-4";
  ?>

  <div id="<?php echo $id; ?>" class="carousel carousel-dark slide" data-bs-interval="false">

    <div class="carousel-inner">

      <?php foreach ($chunks as $i => $group): ?>
        <div class="carousel-item <?php echo ($i == 0 ? "active" : ""); ?>">
          <div class="row g-3">

            <?php foreach ($group as $p): ?>
              <div class="<?php echo $colClass; ?>">
                <article class="bg-white border p-3 h-100">
                  <img src="img/<?php echo $p["foto"]; ?>"
                      alt="<?php echo $p["nome"]; ?>"
                      class="d-block w-100"
                      style="height:140px; object-fit:cover;">
                  <div class="fw-semibold mt-2"><?php echo $p["nome"]; ?></div>
                  <div class="text-muted small"><?php echo $p["descrizione"]; ?></div>
                  <div class="fw-bold text-danger mt-2">€ <?php echo $p["prezzo"]; ?></div>
                </article>
              </div>
            <?php endforeach; ?>

          </div>
        </div>
      <?php endforeach; ?>

    </div>

<?php if (count($chunks) > 1): ?>
  <button class="carousel-control-prev opacity-20" type="button"
          data-bs-target="#<?php echo $id; ?>"
          data-bs-slide="prev"
          aria-label="Slide precedente"> <span class="bg-white rounded-circle p-2 d-inline-flex shadow-sm" aria-hidden="true">
        <span class="carousel-control-prev-icon"></span>
    </span>
  </button>
  <button class="carousel-control-next opacity-20" type="button"
          data-bs-target="#<?php echo $id; ?>"
          data-bs-slide="next"
          aria-label="Slide successiva"> <span class="bg-white rounded-circle p-2 d-inline-flex shadow-sm" aria-hidden="true">
          <span class="carousel-control-next-icon"></span>
      </span>
<?php endif; ?>

  </div>
  <?php
}
?>
