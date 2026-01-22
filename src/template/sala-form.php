<div class="row justify-content-center">
    <div class="col-11">
        <h2 class="fw-bold mt-4 mb-4">Prenotazioni Attive</h2>

        <?php if(count($templateParams["prenotazioni"]) > 0): ?>
            
            <!-- Desktop  -->
            <div class="d-none d-md-block table-responsive bg-white shadow-sm rounded p-3">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Data</th>
                            <th>Orario</th>
                            <th>Tavolo</th>
                            <th>Posti</th>
                            <th>Cliente</th>
                            <th>Archivia</th>
                            <th>Elimina</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($templateParams["prenotazioni"] as $pren): ?>
                            <tr>
                                <td><?php echo date("d/m/Y", strtotime($pren["data"])); ?></td>
                                <td><?php echo substr($pren["ora_inizio"], 0, 5); ?> - <?php echo substr($pren["ora_fine"], 0, 5); ?></td>
                                <td><span class="badge bg-danger text-white">Tavolo <?php echo $pren["id_tavolo"]; ?></span></td>
                                <td><?php echo $pren["nPosti"]; ?></td>
                                <td><?php echo $pren["email"]; ?></td>
                                <td>
                                    <form action="gestioneSala.php" method="POST">
                                        <input type="hidden" name="id_pren" value="<?php echo $pren["id_pren"]; ?>">
                                        <input type="hidden" name="azione" value="archivia">
                                        <button type="submit" class="btn btn-sm btn-success">Archivia</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="gestioneSala.php" method="POST" onsubmit="return confirm('Sei sicuro?');">
                                        <input type="hidden" name="id_pren" value="<?php echo $pren["id_pren"]; ?>">
                                        <input type="hidden" name="azione" value="elimina prenotazione">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Elimina</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile -->
            <div class="d-md-none">
                <?php foreach($templateParams["prenotazioni"] as $pren): ?>
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0 fw-bold"><?php echo date("d/m/Y", strtotime($pren["data"])); ?></h5>
                                <span class="badge bg-danger">Tavolo <?php echo $pren["id_tavolo"]; ?></span>
                            </div>
                            
                            <p class="card-text mb-1 text-muted">
                                <i class="bi bi-clock"></i> <?php echo substr($pren["ora_inizio"], 0, 5); ?> - <?php echo substr($pren["ora_fine"], 0, 5); ?>
                            </p>
                            <p class="card-text mb-1">
                                <i class="bi bi-people"></i> <strong>Posti:</strong> <?php echo $pren["nPosti"]; ?>
                            </p>
                            <p class="card-text small text-truncate">
                                <i class="bi bi-envelope"></i> <?php echo $pren["email"]; ?>
                            </p>
                            
                            <div class="d-grid gap-2 mt-3">
                                <form action="gestioneSala.php" method="POST">
                                    <input type="hidden" name="id_pren" value="<?php echo $pren["id_pren"]; ?>">
                                    <input type="hidden" name="azione" value="archivia">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-check-circle"></i> Archivia
                                    </button>
                                </form>
                                <form action="gestioneSala.php" method="POST" onsubmit="return confirm('Eliminare?');">
                                    <input type="hidden" name="id_pren" value="<?php echo $pren["id_pren"]; ?>">
                                    <input type="hidden" name="azione" value="elimina prenotazione">
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="bi bi-trash"></i> Elimina
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="alert alert-info text-center">Non ci sono prenotazioni attive.</div>
        <?php endif; ?>
    </div>
</div>