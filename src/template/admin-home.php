<div class="row justify-content-center mt-4 g-3">
    <div class="col-md-5">
        <div class="border bg-white p-3 h-100 text-center"> <h2 class="h6 mb-2 fw-bold">Aggiungi un nuovo piatto</h2>
            <p class="text-muted small mb-3">Aggiungi un nuovo piatto al menu del giorno.</p>
            <a href="inserisci-piatto.php" class="btn btn-danger">
                <i class=" bi bi-plus-circle-fill"></i> Aggiungi Piatto
            </a>
        </div>
    </div>

    <div class="col-md-5">
        <div class="border bg-white p-3 h-100 text-center"> <h2 class="h6 mb-2 fw-bold">Gestisci la sala</h2>
        <p class="text-muted small mb-3">Gestisci e archivia le prenotazioni dei tavoli.</p>
        <a class="btn btn-danger" href="gestioneSala.php">Gestione sala</a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-10">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <h2 class="fw-bold">Gestione Menu</h2>

        </div>

        <div class="row">
            <?php
            if(isset($templateParams["piatti"]) && count($templateParams["piatti"]) > 0):
                foreach ($templateParams["piatti"] as $piatto):
            ?>
                <div class="col-md-6 mb-4">
                    <article class="bg-white border p-4 h-100 d-flex flex-column shadow-sm rounded">
                        <header>
                            <div class="text-center mb-3">
                                <img src="img/<?php echo $piatto['foto']; ?>" alt="<?php echo $piatto['nome']; ?>" style="max-height: 150px; object-fit: cover; width: 100%;">
                            </div>
                            <h3 class="h3"><?php echo $piatto['nome']; ?></h3>
                        </header>
                        
                        <section class="flex-grow-1">
                            <p class="text-muted"><?php echo $piatto['descrizione']; ?></p>
                            <h4 class="h4 text-danger"><?php echo $piatto['prezzo']; ?>€</h4>
                        </section>
                        
                        <footer class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                            
                            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalModifica"
                                    data-bs-id="<?php echo $piatto['id_piatto']; ?>">
                                Modifica
                            </button>

                            <form action="admin.php" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare <?php echo $piatto['nome']; ?>?');">
                                <input type="hidden" name="id_piatto" value="<?php echo $piatto['id_piatto']; ?>">
                                <input type="hidden" name="azione" value="elimina">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Elimina
                                </button>
                            </form>

                        </footer>
                    </article>
                </div>
            <?php
                endforeach;
            else:
            ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Non ci sono ancora piatti nel menu. Clicca su "Aggiungi" per iniziare!
                    </div>
                </div>
            <?php
            endif;
            ?>

            <!-- creazione modal modifica piatto -->
            <div class="modal fade" id="modalModifica" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h3 class="modal-title">Modifica Piatto</h3>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="admin.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="azione" value="modifica">
                                
                                <input type="hidden" name="id_piatto" id="edit-id">

                                <div class="mb-3">
                                    <label for="edit-nome" class="form-label">Nome Piatto</label>
                                    <input type="text" class="form-control" id="edit-nome" name="nome" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-desc" class="form-label">Descrizione</label>
                                    <textarea class="form-control" id="edit-desc" name="descrizione" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="edit-prezzo" class="form-label">Prezzo (€)</label>
                                    <input type="number" step="0.01" class="form-control" id="edit-prezzo" name="prezzo" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Salva Modifiche</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

