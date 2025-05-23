/**
 * Ajoute un écouteur d'événement sur le champ de recherche utilisateur.
 * À chaque saisie, filtre dynamiquement les lignes du tableau des utilisateurs
 * en fonction du nom ou du prénom (si présents).
 * 
 * - Les lignes dont le nom ou le prénom contient la valeur recherchée restent visibles.
 * - Les autres lignes sont masquées.
 * - Les lignes d'édition associées sont toujours masquées.
 * 
 * Prérequis :
 * - Un champ input avec l'id 'recherche-utilisateur'
 * - Des lignes de tableau avec des id de la forme 'row-<id>'
 * - Des cellules avec des id 'nom-<id>' et 'prenom-<id>' (optionnelles)
 * - Des lignes d'édition avec des id 'edit-row-<id>'
 */
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