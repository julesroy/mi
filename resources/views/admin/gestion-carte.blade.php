<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @include("head")
        <title>Gestion de la carte</title>
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

        @php
            $categories = [
                0 => "Ingrédient",
                1 => "Viande",
                2 => "Extra",
                3 => "Snack/Boisson",
            ];
        @endphp

        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Gestion des éléments de la carte</h1>

            <div class="overflow-x-auto min-w-full">
                <!-- Barre de recherche et bouton d'ajout -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center min-w-full mb-4 bg-primaire p-4 rounded gap-3 sticky left-0 top-0 z-10">
                    <form class="flex flex-col sm:flex-row w-full md:w-auto">
                        <input type="text" name="search" id="recherche-utilisateur" placeholder="Rechercher" class="bg-white px-3 py-2 rounded-t sm:rounded-l sm:rounded-t-none border-b sm:border-b-0 sm:border-r-0 border-gray-600 w-full sm:w-auto" />
                    </form>
                    <button id="openAddDialog" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full md:w-auto">+ Ajouter un élément</button>
                </div>

                <!-- Indication du tri actuel -->
                <p class="min-w-full mb-2 text-sm text-black">
                    Trié par
                    <span class="font-semibold text-black" id="type-tri">défaut</span>
                </p>

                <div class="max-h-128 md:max-h-96 overflow-y-auto hide-scrollbar rounded-2xl border-2 border-primaire">
                    <!-- Tableau de gestion de la carte -->
                    <table class="min-w-full table-fixed bg-white text-black border-collapse text-center text-xs sm:text-sm md:text-base">
                        <thead class="bg-primaire text-white sticky z-10">
                            <tr>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b sortable" data-key="nom">Nom</th>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b" data-key="composition">Composition</th>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b" data-key="prix">Prix</th>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b" data-key="prix-serveur">Prix serveur</th>
                                @can("verifier-acces-super-administrateur")
                                    <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b" data-key="prix-estime">Prix estime</th>
                                @endcan

                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b" data-key="categorie">Catégorie</th>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($elementsCarte as $elementCarte)
                                <tr id="row-{{ $elementCarte->idElement }}" class="hover:bg-gray-100">
                                    <td class="py-2 px-4 border-b" id="nom-{{ $elementCarte->idElement }}">{{ $elementCarte->nom }}</td>
                                    <td class="py-2 px-4 border-b max-w-32 overflow-hidden" id="composition-{{ $elementCarte->idElement }}">{{ $elementCarte->ingredientsElements }}</td>
                                    <td class="py-2 px-4 border-b" id="prix-{{ $elementCarte->idElement }}">{{ $elementCarte->prix }}</td>
                                    <td class="py-2 px-4 border-b" id="prix-{{ $elementCarte->idElement }}">{{ $elementCarte->prixServeur }}</td>
                                    @can("verifier-acces-super-administrateur")
                                        <td class="py-2 px-4 border-b" id="prix-estime-{{ $elementCarte->idElement }}">Estimation</td>
                                    @endcan

                                    <td class="py-2 px-4 border-b" id="categorie-{{ $elementCarte->idElement }}">{{ $elementCarte->categoriePlat }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="flex">
                                            <img src="{{ asset("images/icons/edit.svg") }}" alt="Modifier" class="action-icon edit-btn" data-id="{{ $elementCarte->idElement }}" />
                                            <img src="{{ asset("images/icons/delete.svg") }}" alt="Supprimer" class="action-icon delete-btn" data-id="{{ $elementCarte->idElement }}" />
                                        </div>
                                    </td>
                                </tr>
                                <tr id="edit-row-{{ $elementCarte->idElement }}" class="hidden bg-gray-200">
                                    <td class="py-2 px-4 border-b">
                                        <input type="text" class="w-full p-1 border" id="edit-nom-{{ $elementCarte->idElement }}" value="{{ $elementCarte->nom }}" />
                                    </td>
                                    @php
                                        // On récupère la chaîne brute
                                        $composition = $elementCarte->ingredientsElements;
                                        $elements = [];
                                        foreach (explode(";", $composition) as $item) {
                                            if (trim($item) === "") {
                                                continue;
                                            }
                                            [$idIngredient, $quantite, $choix] = explode(",", $item);
                                            $elements[] = [
                                                "idIngredient" => $idIngredient,
                                                "quantite" => $quantite,
                                                "choix" => $choix,
                                            ];
                                        }
                                    @endphp

                                    <td class="py-2 px-4 border-b">
                                        <form id="modifierElementCarte" action="{{ route("admin.gestion-carte.modifier") }}" method="POST">
                                            <div id="edit-compositionContainer-{{ $elementCarte->idElement }}">
                                                @foreach ($elements as $element)
                                                    <div class="composition-group flex items-center mb-2">
                                                        <select name="elementCompositionCarteEdit[]">
                                                            @foreach ($elementsInventaire as $ingredient)
                                                                <option value="{{ $ingredient->idIngredient }}" {{ $element["idIngredient"] == $ingredient->idIngredient ? "selected" : "" }}>
                                                                    {{ $ingredient->nom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <select name="quantiteElementCompositionCarteEdit[]">
                                                            @for ($i = 1; $i <= 8; $i++)
                                                                <option value="{{ $i }}" {{ $element["quantite"] == $i ? "selected" : "" }}>{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                        <select name="choixElementCompositionCarteEdit[]">
                                                            <option value="0" {{ $element["choix"] == 0 ? "selected" : "" }}>Libre</option>
                                                            <option value="1" {{ $element["choix"] == 1 ? "selected" : "" }}>Défaut</option>
                                                            <option value="2" {{ $element["choix"] == 2 ? "selected" : "" }}>Obligatoire</option>
                                                        </select>

                                                        <button type="button" class="remove-group px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 ml-2">Supprimer</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="add-group px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 mt-2" data-id="{{ $elementCarte->idElement }}">Ajouter un groupe</button>
                                            <input type="hidden" id="edit-composition-{{ $elementCarte->idElement }}" name="composition" />
                                        </form>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <input type="text" class="w-full p-1 border" id="edit-prix-{{ $elementCarte->idElement }}" value="{{ $elementCarte->prix }}" />
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <input type="text" class="w-full p-1 border" id="edit-prix-serveur-{{ $elementCarte->idElement }}" value="{{ $elementCarte->prixServeur }}" />
                                    </td>
                                    @can("verifier-acces-super-administrateur")
                                        <td class="py-2 px-4 border-b">
                                            <input type="text" class="w-full p-1 border" id="edit-prix-estime-{{ $elementCarte->idElement }}" value="Rien" />
                                        </td>
                                    @endcan

                                    <td class="py-2 px-4 border-b">
                                        <select class="w-full p-1 border" id="edit-categorie-{{ $elementCarte->idElement }}">
                                            <option value="0" {{ $elementCarte->typePlat == 0 ? "selected" : "" }}>Plat</option>
                                            <option value="1" {{ $elementCarte->typePlat == 1 ? "selected" : "" }}>Snack</option>
                                            <option value="2" {{ $elementCarte->typePlat == 2 ? "selected" : "" }}>Boisson</option>
                                            <option value="3" {{ $elementCarte->typePlat == 3 ? "selected" : "" }}>Menu</option>
                                            <option value="4" {{ $elementCarte->typePlat == 4 ? "selected" : "" }}>Event</option>
                                        </select>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <button class="px-4 py-2 bg-green-600 text-white rounded save-btn w-28" data-id="{{ $elementCarte->idElement }}">Enregistrer</button>
                                        <button class="px-4 py-2 bg-gray-400 text-white rounded cancel-btn w-28 mt-1" data-id="{{ $elementCarte->idElement }}">Annuler</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Dialog pour l'ajout d'un élément à la carte -->
        <dialog id="addElementCarteDialog">
            <h2 class="text-xl font-bold mb-4">Ajouter un élément à la carte</h2>
            <form id="ajouterElementCarte" action="{{ route("admin.gestion-carte.ajouter") }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="nom" class="block mb-1">Nom de l'élément</label>
                        <input type="text" id="nom" name="nom" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required />
                    </div>

                    <div id="compositionContainer"></div>
                    <button type="button" id="addGroup" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 mt-2">Ajouter un groupe</button>

                    <div>
                        <label for="prix" class="block mb-1">Prix</label>
                        <input type="number" id="prix" name="prix" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required />
                    </div>
                    <div>
                        <label for="prixServeur" class="block mb-1">Prix Serveur</label>
                        <input type="number" id="prixServeur" name="prixServeur" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required />
                    </div>

                    <div>
                        <label for="categorieElementCarte" class="block mb-1">Type</label>
                        <select id="categorieElementCarte" name="categorieElementCarte" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                            <option value="0">Plat</option>
                            <option value="1">Snack</option>
                            <option value="2">Boisson</option>
                        </select>
                    </div>

                    <div>
                        <label for="description" class="block mb-1">Description</label>
                        <textarea id="description" name="description" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" rows="3"></textarea>
                    </div>
                </div>
                <select name="categoriePlat" id="categoriePlat">
                    <option value="0">Froid</option>
                    <option value="1">Hot-Dog</option>
                    <option value="2">Chaud</option>
                    <option value="3">Snack/Boisson</option>
                </select>

                <input type="hidden" id="composition" name="composition" />

                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" id="closeDialog" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Annuler</button>
                    <button id="ajouter-element-carte" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Ajouter</button>
                </div>
            </form>
        </dialog>

        <script>
            document.getElementById('ajouter-element-carte').addEventListener('click', function () {
                const groups = document.querySelectorAll('#compositionContainer .composition-group');
                let result = [];

                groups.forEach((group) => {
                    const elementSelect = group.querySelector('select[name="elementCompositionCarte[]"]');
                    const quantiteSelect = group.querySelector('select[name="quantiteElementCompositionCarte[]"]');
                    const choixSelect = group.querySelector('select[name="choixElementCompositionCarte[]"]');

                    // Extraire uniquement l'ID (avant le "|") depuis l'option sélectionnée
                    const valeurElement = elementSelect.value.split('|')[0];
                    const quantite = quantiteSelect.value;
                    const choix = choixSelect.value;

                    if (valeurElement) {
                        result.push(`${valeurElement},${quantite},${choix}`);
                    }
                });

                // On place la valeur dans le champ caché
                document.getElementById('composition').value = result.join(';');

                // On soumet le formulaire
                document.getElementById('ajouterElementCarte').submit();
            });

            // Dialog management
            const addElementCarteDialog = document.getElementById('addElementCarteDialog');
            document.getElementById('openAddDialog').addEventListener('click', () => addElementCarteDialog.showModal());
            document.getElementById('closeDialog').addEventListener('click', () => addElementCarteDialog.close());

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

            // Add ingredient composition groups
            document.addEventListener('DOMContentLoaded', () => {
                const addGroupButton = document.getElementById('addGroup');
                const compositionContainer = document.getElementById('compositionContainer');

                function addGroup() {
                    const group = document.createElement('div');
                    group.className = 'composition-group flex items-center mb-2';
                    group.innerHTML = `
                        <select name="elementCompositionCarte[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                            <option value=""></option>
                            @foreach ($elementsInventaire as $elementInventaire)
                                <option value="{{ $elementInventaire->idIngredient }}|{{ $elementInventaire->categorieIngredient }}">{{ $elementInventaire->nom }}</option>
                            @endforeach
                        </select>
                        <select name="quantiteElementCompositionCarte[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                        <select name="choixElementCompositionCarte[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                            <option value="0">Libre</option>
                            <option value="1">Défaut</option>
                            <option value="2">Obligatoire</option>
                        </select>
                        <button type="button" class="remove-group px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 ml-2">Supprimer</button>
                    `;
                    group.querySelector('.remove-group').addEventListener('click', () => group.remove());
                    compositionContainer.appendChild(group);
                }

                addGroupButton.addEventListener('click', addGroup);
            });
        </script>

        <script>
            // ajout elements lors de la modification
            document.addEventListener('DOMContentLoaded', () => {
                // Ajout d'un groupe dans la ligne d'édition
                document.querySelectorAll('.add-group').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.dataset.id;
                        const container = document.getElementById(`edit-compositionContainer-${id}`);
                        const group = document.createElement('div');
                        group.className = 'composition-group flex items-center mb-2';
                        group.innerHTML = `
                            <select name="elementCompositionCarteEdit[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                                <option value=""></option>
                                @foreach ($elementsInventaire as $elementInventaire)
                                    <option value="{{ $elementInventaire->idIngredient }}|{{ $elementInventaire->categorieIngredient }}">{{ $elementInventaire->nom }}</option>
                                @endforeach
                            </select>
                            <select name="quantiteElementCompositionCarteEdit[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                                @for ($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <select name="choixElementCompositionCarteEdit[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                                <option value="0">Libre</option>
                                <option value="1">Défaut</option>
                                <option value="2">Obligatoire</option>
                            </select>
                            <button type="button" class="remove-group px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 ml-2">Supprimer</button>
                        `;
                        group.querySelector('.remove-group').addEventListener('click', () => group.remove());
                        container.appendChild(group);
                    });
                });

                // Suppression d'un groupe dans la ligne d'édition
                document.querySelectorAll('.remove-group').forEach(button => {
                    button.addEventListener('click', () => {
                        button.parentElement.remove();
                    });
                });
            });

            // maj element
            document.querySelectorAll('.save-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const id = btn.dataset.id;
                    // Récupération des valeurs du formulaire d'édition
                    const nom = document.getElementById(`edit-nom-${id}`).value;
                    const prix = document.getElementById(`edit-prix-${id}`).value;
                    const prixServeur = document.getElementById(`edit-prix-serveur-${id}`).value;
                    const categorieElementCarte = document.getElementById(`edit-categorie-${id}`).value;

                    // Composition
                    const groupsEdit = document.querySelectorAll(`#edit-compositionContainer-${id} .composition-group`);
                    let result = [];
                    groupsEdit.forEach(group => {
                        const idIng = group.querySelector('select[name="elementCompositionCarteEdit[]"]').value.split('|')[0];
                        const quantite = group.querySelector('select[name="quantiteElementCompositionCarteEdit[]"]').value;
                        const choix = group.querySelector('select[name="choixElementCompositionCarteEdit[]"]').value;
                        result.push(`${idIng},${quantite},${choix}`);
                    });
                    const composition = result.join(';');

                    fetch("{{ route('admin.gestion-carte.modifier') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            id,
                            nom,
                            prix,
                            prixServeur,
                            categorieElementCarte,
                            composition,
                            categoriePlat: 0
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Met à jour la ligne du tableau sans recharger
                            document.getElementById(`nom-${id}`).textContent = data.nom;
                            document.getElementById(`prix-${id}`).textContent = data.prix;
                            // Mets à jour les autres champs si besoin
                            document.getElementById(`composition-${id}`).textContent = data.composition;
                            // Cache la ligne d'édition et affiche la ligne normale
                            document.getElementById(`row-${id}`).classList.remove('hidden');
                            document.getElementById(`edit-row-${id}`).classList.add('hidden');
                        } else {
                            alert("Erreur lors de la modification.");
                        }
                    })
                    .catch(error => {
                        error.response?.json?.().then(errData => {
                            alert("Erreur lors de la modification : " + (errData?.message || error.message));
                        }).catch(() => {
                            alert("Erreur lors de la modification : " + error.message);
                        });
                    });
                });
            });
        </script>

        <script>
            // Suppression d'un élément
            document.querySelectorAll('.delete-btn').forEach((btn) => {
                btn.addEventListener('click', function () {
                    if (!confirm('Voulez-vous vraiment supprimer cet élément ?')) return;
                    const id = btn.dataset.id;

                    fetch('{{ route("admin.gestion-carte.supprimer") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ id }),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                // Supprime la ligne du tableau
                                document.getElementById(`row-${id}`).remove();
                                const editRow = document.getElementById(`edit-row-${id}`);
                                if (editRow) editRow.remove();
                            } else {
                                alert('Erreur lors de la suppression.');
                            }
                        })
                        .catch(() => alert('Erreur lors de la suppression.'));
                });
            });
        </script>

        <script src="{{ asset("js/recherche.js") }}"></script>
        <script src="{{ asset("js/tri-tableaux.js") }}"></script>
    </body>
</html>
