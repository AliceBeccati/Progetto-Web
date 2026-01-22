document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="prenotazioni.php"]');
    const oraInizioInput = document.getElementById('ora_inizio');
    const oraFineInput = document.getElementById('ora_fine');

    if (form && oraInizioInput && oraFineInput) {
        form.addEventListener('submit', function(event) {
            const oraInizio = oraInizioInput.value;
            const oraFine = oraFineInput.value;

            if (oraInizio && oraFine && oraFine <= oraInizio) {
                // Blocca l'invio
                event.preventDefault();
                
                // Aggiunge lo stile di errore di Bootstrap
                oraFineInput.classList.add('is-invalid');
                oraFineInput.focus(); // Porta il cursore sul campo sbagliato
            } else {
                // Rimuove l'errore se l'utente ha corretto i dati
                oraFineInput.classList.remove('is-invalid');
            }
        });

        // Opzionale: Rimuove il rosso appena l'utente cambia l'orario
        oraFineInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    }
});