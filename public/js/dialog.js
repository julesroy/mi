document.addEventListener('DOMContentLoaded', function () {
    const openButtons = document.querySelectorAll('.openDialogBtn');
    const closeButtons = document.querySelectorAll('.closeDialogBtn');
    const mainContainer = document.getElementById('main-container');
    const carteBlock = document.getElementById('carte-block');
    const panierBlock = document.getElementById('panier-block');

    openButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const dialog = document.getElementById(targetId)
                dialog.showModal();
        });
    });

    closeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const dialog = this.closest('dialog');
            if (dialog) {
                dialog.close();
            }
        });
    });

    // Fermer le dialog en cliquant à l'extérieur
    document.querySelectorAll('dialog').forEach(dialog => {
        dialog.addEventListener('click', function (e) {
            const rect = dialog.getBoundingClientRect();
            const clickedInDialog = (
                e.clientX >= rect.left &&
                e.clientX <= rect.right &&
                e.clientY >= rect.top &&
                e.clientY <= rect.bottom
            );
            if (!clickedInDialog) {
                dialog.close();
            }
        });
    });
});