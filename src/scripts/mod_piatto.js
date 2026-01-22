document.addEventListener('DOMContentLoaded', function() {
    const modalModifica = document.getElementById('modalModifica');
    if (modalModifica) {
        modalModifica.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget; // tasto cliccato
            const id = button.getAttribute('data-bs-id');
            const inputId = modalModifica.querySelector('#edit-id');
            if (inputId) {
                inputId.value = id; // inserimento l'id nel form
            }
        });
    }
});