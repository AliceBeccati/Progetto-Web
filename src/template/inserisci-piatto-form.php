<?php if (!empty($templateParams["errorelogin"])): ?>
    <div class="alert alert-danger mt-3">
        <?php echo $templateParams["errorelogin"]; ?>
    </div>
<?php endif; ?>

<form action="inserisci-piatto.php" method="POST">
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="row mt-3">
                <div class="col-md-8 mx-auto">
                    <section class="bg-secondary border p-4" style="--bs-bg-opacity: .5;">
                        <p>Inserisci i dati del nuovo piatto.</p>
                        <div class="row col-md-8">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label" for="nome">Nome del piatto</label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control bg-secondary" style="--bs-bg-opacity: .4;"
                                        type="text" id="nome" name="nome" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label" for="descrizione">Descrizione</label>
                                </div>
                                <div class="col-6">
                                    <textarea class="form-control bg-secondary" style="--bs-bg-opacity: .4;"
                                        id="descrizione" name="descrizione" required></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label" for="prezzo">Prezzo</label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control bg-secondary" style="--bs-bg-opacity: .4;"
                                        type="number" step="0.01" id="prezzo" name="prezzo" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label" for="foto">Nome dell'immagine e formato (.jpg)</label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control bg-secondary" style="--bs-bg-opacity: .4;"
                                        type="text" id="foto" name="foto" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12 text-end">
                                    <input class="btn btn-danger" type="submit" id="submit" value="Invia">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</form>
