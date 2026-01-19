<div class="row justify-content-center">
    <div class="col-11">
        <h2 class="fw-bold mt-4 mb-4">Prenotazioni Attive</h2>

        <?php if(count($templateParams["prenotazioni"]) > 0): ?>
            <div class="table-responsive bg-white shadow-sm rounded p-3">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Data</th>
                            <th>Orario</th>
                            <th>Tavolo</th>
                            <th>Posti</th>
                            <th>Cliente</th>
                            <th class="text-end">Azione</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($templateParams["prenotazioni"] as $pren): ?>
                            <tr>
                                <td><?php echo $pren["data"]; ?></td>
                                <td><?php echo $pren["ora_inizio"]; ?> - <?php echo $pren["ora_fine"]; ?></td>
                                <td><span class="badge bg-danger text-white">Tavolo <?php echo $pren["id_tavolo"]; ?></span></td>
                                <td><?php echo $pren["nPosti"]; ?></td>
                                <td><?php echo $pren["email"]; ?></td>
                                <td class="text-end">
                                    <form action="gestioneSala.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_pren" value="<?php echo $pren["id_pren"]; ?>">
                                        <input type="hidden" name="azione" value="archivia">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle"></i> Archivia
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Non ci sono prenotazioni attive al momento.
            </div>
        <?php endif; ?>
    </div>
</div>