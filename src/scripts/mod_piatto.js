document.addEventListener('DOMContentLoaded', function() {
    const modalModifica = document.getElementById('modalModifica');
    if (modalModifica) {
        modalModifica.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget; // Il tasto cliccato
            const id = button.getAttribute('data-bs-id'); // Legge l'ID
            const inputId = modalModifica.querySelector('#edit-id'); // Trova il campo hidden
            if (inputId) {
                inputId.value = id; // Inserisce l'ID nel form
            }
        });
    }
});