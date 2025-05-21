/**
 * Gestion du tri dynamique des tableaux HTML sur clic des en-têtes de colonnes.
 *
 * Fonctionnement :
 * - Ajoute un curseur pointer sur les <th> ayant la classe 'sortable'.
 * - Trie les lignes du tableau (hors lignes d'édition) selon la colonne cliquée.
 * - Pour les colonnes 'solde' et 'acces', le tri se fait numériquement via l'attribut data-value si présent.
 * - Pour les autres colonnes, le tri se fait alphabétiquement.
 * - Replace les lignes triées dans le <tbody> ainsi que leur ligne d'édition associée.
 * - Met à jour l'indication du tri dans l'élément #type-tri si présent.
 *
 * Prérequis :
 * - Les <th> triables doivent avoir la classe 'sortable' et un data-key correspondant à l'id des <td>.
 * - Les <td> à trier doivent avoir un id de la forme '<key>-<id>'.
 * - Les valeurs numériques doivent être dans l'attribut data-value.
 * - Les lignes d'édition doivent avoir un id 'edit-row-<id>'.
 */

document.querySelectorAll('th.sortable').forEach((th) => {
    th.style.cursor = 'pointer';
});

const table = document.querySelector('table');
const tbody = table.querySelector('tbody');

let sortDirection = {};

document.querySelectorAll('th.sortable').forEach((th, index) => {
    th.addEventListener('click', () => {
        const key = th.dataset.key;
        sortDirection[key] = sortDirection[key] === 'asc' ? 'desc' : 'asc';
        const dir = sortDirection[key];

        // Récupère les lignes du tbody (uniquement les lignes normales, pas celles en édition)
        const rows = Array.from(tbody.querySelectorAll('tr:not(.hidden)')).filter((tr) => !tr.id.startsWith('edit-row-'));

        rows.sort((a, b) => {
            const aCell = a.querySelector(`[id^="${key}-"]`);
            const bCell = b.querySelector(`[id^="${key}-"]`);

            if (!aCell || !bCell) return 0;

            let aValue = aCell.dataset.value ?? aCell.textContent.trim();
            let bValue = bCell.dataset.value ?? bCell.textContent.trim();

            if (['solde', 'acces'].includes(key)) {
                aValue = parseFloat(aValue);
                bValue = parseFloat(bValue);
                return dir === 'asc' ? aValue - bValue : bValue - aValue;
            } else {
                return dir === 'asc' ? aValue.localeCompare(bValue, 'fr', { sensitivity: 'base' }) : bValue.localeCompare(aValue, 'fr', { sensitivity: 'base' });
            }
        });

        // Replace les lignes triées dans le tbody, mais aussi leurs lignes d'édition associées
        rows.forEach((row) => {
            tbody.appendChild(row);
            const editRow = document.getElementById('edit-' + row.id);
            if (editRow) tbody.appendChild(editRow);
        });

        // Met à jour l'indication du tri (optionnel)
        const typeTriSpan = document.getElementById('type-tri');
        if (typeTriSpan) {
            typeTriSpan.textContent = `${key} (${dir === 'asc' ? '▲' : '▼'})`;
        }
    });
});