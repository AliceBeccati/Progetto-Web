<div class="row justify-content-center">
    <div class="col-10">
        <div class="row mt-3">
            <?php

            if(isset($templateParams["piatti"]) && count($templateParams["piatti"]) > 0):
                foreach ($templateParams["piatti"] as $piatto):
            ?>
                <div class="col-md-6 mb-4">
                    <article class="bg-white border p-4 h-100">
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
            <?php endif;
            ?>
        </div>
    </div>
</div>
