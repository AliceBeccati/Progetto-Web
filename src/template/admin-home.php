<div class="row justify-content-center">
    <div class="col-10">
        
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <h2 class="fw-bold">Gestione Menu</h2>
            <a href="inserisci-piatto.php" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle-fill"></i> Aggiungi Nuovo Piatto
            </a>
        </div>

        <div class="row">
            <?php
            // Controllo se ci sono piatti
            if(isset($templateParams["piatti"]) && count($templateParams["piatti"]) > 0):
                foreach ($templateParams["piatti"] as $piatto):
            ?>
                <div class="col-md-6 mb-4">
                    <article class="bg-white border p-4 h-100 d-flex flex-column shadow-sm rounded">
                        <header>
                            <div class="text-center mb-3">
                                <img src="img/<?php echo $piatto['foto']; ?>" alt="<?php echo $piatto['nome']; ?>" style="max-height: 150px; object-fit: cover; width: 100%;">
                            </div>
                            <h2 class="h4"><?php echo $piatto['nome']; ?></h2>
                        </header>
                        
                        <section class="flex-grow-1">
                            <p class="text-muted"><?php echo $piatto['descrizione']; ?></p>
                            <p class="fw-bold text-danger fs-5">€ <?php echo $piatto['prezzo']; ?></p>
                        </section>
                        
                        <footer class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                            
                            <a href="modifica-piatto.php?id=<?php echo $piatto['id_piatto']; ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> Modifica
                            </a>

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
            <?php endif; ?>
        </div>
        
    </div>
</div>