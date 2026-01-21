document.addEventListener('DOMContentLoaded', function() {
    // Cerchiamo il form specifico della prenotazione
    const formPrenotazione = document.querySelector('form[action="prenotazioni.php"]');

    if (formPrenotazione) {
        formPrenotazione.addEventListener('submit', function(event) {
            const oraInizioInput = document.getElementById('ora_inizio');
            const oraFineInput = document.getElementById('ora_fine');

            // Verifichiamo che gli elementi esistano nella pagina corrente
            if (oraInizioInput && oraFineInput) {
                const oraInizio = oraInizioInput.value;
                const oraFine = oraFineInput.value;

                if (oraInizio && oraFine && oraFine <= oraInizio) {
                    event.preventDefault(); // Blocca l'invio del form
                    alert("Attenzione: l'ora di fine deve essere successiva all'ora di inizio.");
                }
            }
        });
    }
});