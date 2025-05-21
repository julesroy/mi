document.getElementById('recherche-utilisateur').addEventListener('input', function () {
    const valeurRecherche = this.value.trim().toLowerCase();

    // Sélectionne uniquement les lignes d'affichage normales (pas celles en édition)
    const lignes = document.querySelectorAll("tbody tr[id^='row-']");

    lignes.forEach((ligne) => {
        const id = ligne.id.replace('row-', '');
        const nomElem = document.getElementById(`nom-${id}`);
        const prenomElem = document.getElementById(`prenom-${id}`);

        const nom = nomElem ? nomElem.textContent.toLowerCase() : '';
        const prenom = prenomElem ? prenomElem.textContent.toLowerCase() : '';

        const correspondance = nom.includes(valeurRecherche) || prenom.includes(valeurRecherche);

        ligne.style.display = correspondance ? '' : 'none';

        const ligneEdition = document.getElementById(`edit-row-${id}`);
        if (ligneEdition) {
            ligneEdition.style.display = correspondance ? 'none' : 'none'; // Toujours masquée
        }
    });
});