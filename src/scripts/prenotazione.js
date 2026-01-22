document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="prenotazioni.php"]');
    const oraInizioInput = document.getElementById('ora_inizio');
    const oraFineInput = document.getElementById('ora_fine');

    if (form && oraInizioInput && oraFineInput) {
        form.addEventListener('submit', function(event) {
            const oraInizio = oraInizioInput.value;
            const oraFine = oraFineInput.value;

            if (oraInizio && oraFine && oraFine <= oraInizio) {
                // blocca invio
                event.preventDefault();
                oraFineInput.classList.add('is-invalid');
                oraFineInput.focus(); // cursore su campo sbagliato
            } else {
                // utente corregge i dati
                oraFineInput.classList.remove('is-invalid');
            }
        });

        //utente corregge l'orario
        oraFineInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    }
});