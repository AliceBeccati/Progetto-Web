document.addEventListener("DOMContentLoaded", () => {
    const modalT = document.getElementById("modalModificaTavolata");
    if (!modalT) return;

    modalT.addEventListener("show.bs.modal", (event) => {
        const btn = event.relatedTarget;
        if (!btn) return;

        document.getElementById("t-edit-id").value     = btn.getAttribute("data-bs-id") || "";
        document.getElementById("t-edit-titolo").value = btn.getAttribute("data-bs-titolo") || "";
        document.getElementById("t-edit-data").value   = btn.getAttribute("data-bs-data") || "";
        document.getElementById("t-edit-ora").value    = btn.getAttribute("data-bs-ora") || "";
        document.getElementById("t-edit-max").value    = btn.getAttribute("data-bs-max") || 2;
    });
});
