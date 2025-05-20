<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        @include("head")
        <title>Gestion des comptes</title>
        <style>
            dialog {
                background-color: #2a2a2a;
                color: white;
                border: 2px solid #4a4a4a;
                border-radius: 8px;
                padding: 20px;
                max-width: 500px;
            }
            dialog::backdrop {
                background-color: rgba(0, 0, 0, 0.7);
            }
            .action-icon {
                cursor: pointer;
                width: 20px;
                height: 20px;
                margin: 0 5px;
            }
        </style>
    </head>
    <body class="pt-28 md:pt-60">
        @include("header")

        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Gestion des comptes</h1>

            <div class="overflow-x-auto min-w-full">
                <!-- Barre de recherche -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center min-w-full mb-4 bg-primaire p-4 rounded gap-3 sticky left-0 top-0 z-10">
                    <form class="flex flex-col sm:flex-row w-full md:w-auto">
                        <input type="text" name="search" id="recherche-utilisateur" placeholder="Rechercher" class="bg-white px-3 py-2 rounded-t sm:rounded-l sm:rounded-t-none border-b sm:border-b-0 sm:border-r-0 border-gray-600 w-full sm:w-auto"/>
                    </form>
                </div>

                <!-- Indication du tri actuel -->
                <p class="min-w-full mb-2 text-sm text-black">
                    Trié
                    par
                    <span class="font-semibold text-black" id="type-tri">
                        défaut
                    </span>

                <!-- Tableau de gestion des comptes -->
                <div class="max-h-128 md:max-h-96 overflow-y-auto hide-scrollbar rounded-2xl border-2 border-primaire">
                    <table class="min-w-full table-fixed bg-white text-black border-collapse text-center text-xs sm:text-sm md:text-base">
                        <thead class="bg-primaire text-white sticky z-10">
                            <tr>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b" data-key="numeroCompte">
                                Numéro de compte
                                </th>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b sortable" data-key="nom">
                                Nom
                                </th>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b sortable" data-key="prenom">
                                Prénom
                                </th>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b">
                                Email
                                </th>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b sortable" data-key="solde">
                                Solde
                                </th>
                                @if (Auth::user() && Auth::user()->acces == 3)
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b sortable" data-key="acces">
                                    Accès
                                </th>
                                @endif
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($utilisateurs as $donneesUtilisateur)
                                <tr id="row-{{ $donneesUtilisateur->numeroCompte }}" class="hover:bg-gray-100">
                                    <td class="w-1/6 py-2 px-4 border-b" id="id-{{ $donneesUtilisateur->numeroCompte }}" data-value="{{ $donneesUtilisateur->numeroCompte }}">{{ $donneesUtilisateur->numeroCompte }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="nom-{{ $donneesUtilisateur->numeroCompte }}">{{ $donneesUtilisateur->nom }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="prenom-{{ $donneesUtilisateur->numeroCompte }}">{{ $donneesUtilisateur->prenom }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="email-{{ $donneesUtilisateur->numeroCompte }}">{{ $donneesUtilisateur->email }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="solde-{{ $donneesUtilisateur->numeroCompte }}" data-value="{{ $donneesUtilisateur->solde }}">{{ $donneesUtilisateur->solde }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="acces-{{ $donneesUtilisateur->numeroCompte }}" data-value="{{ $donneesUtilisateur->acces }}">
                                        @php
                                            $accesLabels = [
                                                0 => 'Client',
                                                1 => 'Serveur',
                                                2 => 'Admin',
                                                3 => 'Super-Admin'
                                            ];
                                        @endphp
                                        {{ $accesLabels[$donneesUtilisateur->acces] ?? $donneesUtilisateur->acces }}
                                    </td>

                                    <td class="w-1/6 py-2 px-4 border-b text-center">
                                        <div class="flex justify-center">
                                            <img src="{{ asset('images/icons/edit.svg') }}" alt="Modifier"
                                                class="action-icon edit-btn"
                                                data-id="{{ $donneesUtilisateur->numeroCompte }}" />
                                        </div>
                                    </td>
                                    
                                </tr>
                                <tr id="edit-row-{{ $donneesUtilisateur->numeroCompte }}" class="hidden bg-gray-200">
                                    <td class="w-1/6 py-2 px-4 border-b">
                                        <p class="w-full p-1 border">{{ $donneesUtilisateur->numeroCompte }}</p>
                                    </td>
                                    <td class="w-1/6 py-2 px-4 border-b">
                                        <input type="text" class="w-full p-1 border" id="edit-nom-{{ $donneesUtilisateur->numeroCompte }}" value="{{ $donneesUtilisateur->nom }}" />
                                    </td>
                                    <td class="w-1/6 py-2 px-4 border-b">
                                        <input type="text" class="w-full p-1 border" id="edit-prenom-{{ $donneesUtilisateur->numeroCompte }}" value="{{ $donneesUtilisateur->prenom }}" />
                                    </td>
                                    <td class="w-1/6 py-2 px-4 border-b">
                                        <input type="text" class="w-full p-1 border" id="edit-email-{{ $donneesUtilisateur->numeroCompte }}" value="{{ $donneesUtilisateur->email }}" />
                                    </td>
                                    <td class="w-1/6 py-2 px-4 border-b">
                                        <input type="text" class="w-full p-1 border" id="edit-solde-{{ $donneesUtilisateur->numeroCompte }}" value="{{ $donneesUtilisateur->solde }}" />
                                    </td>
                                    <td class="w-1/6 py-2 px-4 border-b">
                                        <select id="edit-acces-{{ $donneesUtilisateur->numeroCompte }}" class="w-full p-1 border">
                                            <option value="0" {{ $donneesUtilisateur->acces == 0 ? 'selected' : '' }}>Client</option>
                                            <option value="1" {{ $donneesUtilisateur->acces == 1 ? 'selected' : '' }}>Serveur</option>
                                            <option value="2" {{ $donneesUtilisateur->acces == 2 ? 'selected' : '' }}>Admin</option>
                                            <option value="3" {{ $donneesUtilisateur->acces == 3 ? 'selected' : '' }}>Super-Admin</option>
                                        </select>
                                    </td>

                                    <td class="text-center w-1/6 py-2 px-4 border-b">
                                        <button class="px-4 py-2 bg-green-600 text-white rounded save-btn w-28" data-id="{{ $donneesUtilisateur->numeroCompte }}">Enregistrer</button>
                                        <button class="px-4 py-2 bg-gray-400 text-white rounded cancel-btn w-28 mt-1" data-id="{{ $donneesUtilisateur->numeroCompte }}">Annuler</button>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Modale -->
                            <dialog id="commentDialog" class="backdrop:bg-gray-800/80 p-6 rounded-lg shadow-lg">
                                <div class="min-w-[300px]">
                                    <h3 class="text-xl font-bold mb-4" id="dialogTitle"></h3>
                                    <p class="mb-4 bg-gray-100 p-3 rounded text-black" id="dialogContent"></p>
                                    <div class="flex justify-end">
                                        <button onclick="commentDialog.close()" 
                                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                            Fermer
                                        </button>
                                    </div>
                                </div>
                            </dialog>

                            <script>
                            const commentDialog = document.getElementById('commentDialog');

                            function showComment(nom, commentaire) {
                                document.getElementById('dialogTitle').textContent = nom;
                                document.getElementById('dialogContent').textContent = commentaire;
                                commentDialog.showModal();
                            }

                            // Fermer la modale en cliquant à l'extérieur
                            commentDialog.addEventListener('click', (e) => {
                                const dialogDimensions = commentDialog.getBoundingClientRect();
                                if (
                                    e.clientX < dialogDimensions.left ||
                                    e.clientX > dialogDimensions.right ||
                                    e.clientY < dialogDimensions.top ||
                                    e.clientY > dialogDimensions.bottom
                                ) {
                                    commentDialog.close();
                                }
                            });
                            </script>
                        </tbody>
                    </table>
                </div>

                <style>
                    .hide-scrollbar {
                        scrollbar-width: none; /* Firefox */
                        -ms-overflow-style: none; /* IE/Edge */
                    }
                    .hide-scrollbar::-webkit-scrollbar {
                        display: none; /* Chrome/Safari/Webkit */
                    }
                </style>
            </div>
        </div>

        <script>
            const deleteDialog = document.getElementById('deleteDialog');

            // Gestion de l'édition des lignes
            document.querySelectorAll('.edit-btn').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const ligneAffichage = document.getElementById(`row-${id}`);
                    const ligneEdition = document.getElementById(`edit-row-${id}`);

                    // Cache la ligne normale (ajoute hidden ET display none)
                    ligneAffichage.classList.add('hidden');
                    ligneAffichage.style.display = 'none';

                    // Affiche la ligne d’édition (retire hidden ET force le display block)
                    ligneEdition.classList.remove('hidden');
                    ligneEdition.style.display = '';
                });
            });

            // Annuler l'édition
            document.querySelectorAll('.cancel-btn').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const ligneAffichage = document.getElementById(`row-${id}`);
                    const ligneEdition = document.getElementById(`edit-row-${id}`);

                    // Affiche la ligne normale
                    ligneAffichage.classList.remove('hidden');
                    ligneAffichage.style.display = '';

                    // Cache la ligne d’édition
                    ligneEdition.classList.add('hidden');
                    ligneEdition.style.display = 'none';
                });
            });

            const accesNum = {
                0: 'Client',
                1: 'Serveur',
                2: 'Admin',
                3: 'Super-Admin',
            };

            // Sauvegarder l'édition
            document.querySelectorAll('.save-btn').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');

                    // Récupère les valeurs des champs d'édition
                    const nom = document.getElementById('edit-nom-' + id).value;
                    const prenom = document.getElementById('edit-prenom-' + id).value;
                    const email = document.getElementById('edit-email-' + id).value;
                    const solde = document.getElementById('edit-solde-' + id).value;
                    const acces = document.getElementById('edit-acces-' + id).value;

                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('nom', nom);
                    formData.append('prenom', prenom);
                    formData.append('email', email);
                    formData.append('solde', solde);
                    formData.append('acces', acces);

                    fetch('/admin/gestion-comptes/update', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: formData,
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                // Met à jour les cellules de la ligne avec les nouvelles valeurs
                                document.getElementById('id-' + id).textContent = id;
                                document.getElementById('nom-' + id).textContent = nom;
                                document.getElementById('prenom-' + id).textContent = prenom;
                                document.getElementById('email-' + id).textContent = email;
                                document.getElementById('solde-' + id).textContent = solde;
                                document.getElementById('acces-' + id).textContent = accesNum[parseInt(acces)] || acces;

                                // Masque la ligne d'édition et affiche la ligne normale
                                document.getElementById('row-' + id).classList.remove('hidden');
                                document.getElementById('row-' + id).style.display = '';
                                document.getElementById('edit-row-' + id).classList.add('hidden');
                            } else {
                                alert('Erreur lors de la modification');
                            }
                        });
                });
            });
        </script>

        <script>
            document.getElementById("recherche-utilisateur").addEventListener("input", function () {
                const valeurRecherche = this.value.trim().toLowerCase();

                // Sélectionne uniquement les lignes d'affichage normales (pas celles en édition)
                const lignes = document.querySelectorAll("tbody tr[id^='row-']");

                lignes.forEach(ligne => {
                    const id = ligne.id.replace("row-", "");
                    const nom = document.getElementById(`nom-${id}`).textContent.toLowerCase();
                    const prenom = document.getElementById(`prenom-${id}`).textContent.toLowerCase();

                    const correspondance = nom.includes(valeurRecherche) || prenom.includes(valeurRecherche);

                    ligne.style.display = correspondance ? "" : "none";

                    const ligneEdition = document.getElementById(`edit-row-${id}`);
                    if (ligneEdition) {
                        ligneEdition.style.display = correspondance ? "none" : "none"; // Toujours masquée
                    }
                });
            });
        </script>

        <script>
            // Ajoute un curseur pointer sur les th triables
            document.querySelectorAll('th.sortable').forEach(th => {
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
                    const rows = Array.from(tbody.querySelectorAll('tr:not(.hidden)'))
                    .filter(tr => !tr.id.startsWith('edit-row-'));

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
                            return dir === 'asc' 
                                ? aValue.localeCompare(bValue, 'fr', { sensitivity: 'base' }) 
                                : bValue.localeCompare(aValue, 'fr', { sensitivity: 'base' });
                        }
                    });

                    // Replace les lignes triées dans le tbody, mais aussi leurs lignes d'édition associées
                    rows.forEach(row => {
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
        </script>
    </body>
</html>
