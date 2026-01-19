<form action="prenotazioni.php" method="POST">
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="row mt-3">
                <div class="col-md-8 mx-auto">
                    <section class="bg-secondary border p-4" style="--bs-bg-opacity: .5;">
                        <h2 class="h4 mb-3">Nuova Prenotazione</h2>
                        <p>Inserisci le informazioni per la prenotazione.</p>
                        
                        <div class="row col-md-10">

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label" for="ora_inizio">Ora di inizio</label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control bg-secondary" style="--bs-bg-opacity: .4;"
                                        type="time" id="ora_inizio" name="ora_inizio" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label" for="ora_fine">Ora di fine</label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control bg-secondary" style="--bs-bg-opacity: .4;"
                                        type="time" id="ora_fine" name="ora_fine" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label" for="data">Data</label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control bg-secondary" style="--bs-bg-opacity: .4;"
                                        type="date" id="data" name="data" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label" for="n_posti">Numero di posti</label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control bg-secondary" style="--bs-bg-opacity: .4;"
                                        type="number" min="1" id="n_posti" name="n_posti" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12 text-end">
                                    <input class="btn btn-danger" type="submit" name="submit" value="Prenota ora">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</form>