<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @include('head')
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

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-60">
        @include('header')

        @php
            $categories = [
                0 => 'Ingrédient',
                1 => 'Viande',
                2 => 'Extra',
                3 => 'Snack/Boisson',
            ];
        @endphp

        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Gestion de la carte</h1>

            <div class="overflow-x-auto min-w-full">
                <!-- Barre de recherche et bouton d'ajout -->
                <div class="flex flex-col md:flex-row md:justify-between items-center min-w-full mb-4 bg-gray-800 p-4 rounded gap-3 sticky top-0 z-10">
                    <form method="GET" action="{{ url()->current() }}" class="flex flex-col sm:flex-row w-full md:w-auto">
                        <input type="text" name="search" placeholder="Rechercher" class="px-3 py-2 bg-gray-700 text-white rounded-t sm:rounded-l border-gray-600 w-full sm:w-auto" value="{{ request('search') }}" />
                        <select name="categorie" class="px-3 py-2 bg-gray-700 text-white border-gray-600 w-full sm:w-auto">
                            <option value="">Toutes catégories</option>
                            @foreach ($categories as $key => $label)
                                <option value="{{ $key }}" {{ request('categorie') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 w-full sm:w-auto mt-2 sm:mt-0">Rechercher</button>
                    </form>
                    <button id="openAddDialog" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full md:w-auto">+ Ajouter un élément</button>
                </div>

                <!-- Indication du tri actuel -->
                <p class="min-w-full mb-2 text-sm text-gray-400">@if (request("sort"))
                    Trié
                    par
                    <span class="font-semibold text-white">
                        {{
                            request("sort") == "nom"
                                ? "Nom"
                                : (request("sort") == "quantite"
                                    ? "Quantité"
                                    : (request("sort") == "marque"
                                        ? "Marque"
                                        : (request("sort") == "estimationPrix"
                                            ? "Prix"
                                            : (request("sort") == "categorieIngredient"
                                                ? "Catégorie"
                                                : "Nom"
                                            )
                                        )
                                    )
                                )
                        }}
                    </span>
                    
                    ({{ request("direction", "asc") === "asc" ? "croissant" : "décroissant" }})
                @else
                    Tri
                    par
                    défaut
                @endif</p>

                <!-- Tableau de gestion de la carte -->
                <table class="min-w-full bg-white text-black rounded shadow">
                    <thead>
                        <tr class="bg-gray-700 text-white">
                            <th class="py-2 px-4 border-b">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'nom', 'direction' => request('sort') === 'nom' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 text-white">Nom {!! request('sort') === 'nom' ? (request('direction') === 'asc' ? '▲' : '▼') : '' !!}</a>
                            </th>
                            <th class="py-2 px-4 border-b">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'quantite', 'direction' => request('sort') === 'quantite' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 text-white">Prix {!! request('sort') === 'quantite' ? (request('direction') === 'asc' ? '▲' : '▼') : '' !!}</a>
                            </th>
                            <th class="py-2 px-4 border-b">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'marque', 'direction' => request('sort') === 'marque' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 text-white">Prix serveur {!! request('sort') === 'marque' ? (request('direction') === 'asc' ? '▲' : '▼') : '' !!}</a>
                            </th>
                            @if (Auth::user() && Auth::user()->acces == 3)
                                    <th class="py-2 px-4 border-b">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'estimationPrix', 'direction' => request('sort') === 'estimationPrix' && request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 text-white">Prix estimé {!! request('sort') === 'estimationPrix' ? (request('direction') === 'asc' ? '▲' : '▼') : '' !!}</a>
                                    </th>
                            @endif

                            <th class="bg-gray-700 sticky top-0 w-1/6 py-2 px-4 border-b text-left">
                                <a href="{{
                                    request()->fullUrlWithQuery([
                                        "sort" => "categorieIngredient",
                                        "direction" => request("sort") === "categorieIngredient" && request("direction") === "asc" ? "desc" : "asc",
                                    ])
                                }}" class="flex items-center gap-1 text-white">
                                    Catégorie
                                    {!! request("sort") === "categorieIngredient" ? (request("direction") === "asc" ? "▲" : "▼") : "" !!}
                                </a>
                            </th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($elementsCarte as $elementCarte)
                            <tr id="row-{{ $elementCarte->idElement }}" class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b" id="nom-{{ $elementCarte->idElement }}">{{ $elementCarte->nom }}</td>
                                <td class="py-2 px-4 border-b" id="nom-{{ $elementCarte->idElement }}">{{ $elementCarte->prix }}</td>
                                <td class="py-2 px-4 border-b" id="nom-{{ $elementCarte->idElement }}">{{ $elementCarte->prixServeur }}</td>
                                <td class="py-2 px-4 border-b">
                                    <div class="flex">
                                        <img src="{{ asset('images/icons/edit.svg') }}" alt="Modifier" class="action-icon edit-btn" data-id="{{ $elementCarte->idElement }}" />
                                        <img src="{{ asset('images/icons/delete.svg') }}" alt="Supprimer" class="action-icon delete-btn" data-id="{{ $elementCarte->idElement }}" />
                                    </div>
                                </td>
                            </tr>
                            <tr id="edit-row-{{ $elementCarte->idElement }}" class="hidden bg-gray-200">
                                <td class="py-2 px-4 border-b">
                                    <input type="text" class="w-full p-1 border" id="edit-nom-{{ $elementCarte->idElement }}" value="{{ $elementCarte->nom }}" />
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <select class="w-full p-1 border" id="edit-categorie-{{ $elementCarte->idElement }}">
                                        <option value="0" {{ $elementCarte->typePlat == 0 ? 'selected' : '' }}>Plat</option>
                                        <option value="1" {{ $elementCarte->typePlat == 1 ? 'selected' : '' }}>Snack</option>
                                        <option value="2" {{ $elementCarte->typePlat == 2 ? 'selected' : '' }}>Boisson</option>
                                        <option value="3" {{ $elementCarte->typePlat == 3 ? 'selected' : '' }}>Menu</option>
                                        <option value="4" {{ $elementCarte->typePlat == 4 ? 'selected' : '' }}>Event</option>
                                    </select>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    @php
                                        $donneesJson = $elementCarte->ingredientsElements;
                                        $elements = json_decode($donneesJson, true)['elements'];
                                    @endphp

                                    <div id="edit-compositionContainer-{{ $elementCarte->idElement }}" class="mb-2">
                                        @foreach ($elements as $index => $element)
                                            <div class="composition-group flex items-center mb-2">
                                                <select name="elementCompositionCarte[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                                                    <option value=""></option>
                                                    @foreach ($elementsMenus as $elementMenus)
                                                        <option value="{{ $elementMenus->idElementMenu }}" {{ $element['nomIngredient'] === $elementMenus->nom ? 'selected' : '' }}>
                                                            {{ $elementMenus->nom }}
                                                        </option>
                                                    @endforeach

                                                    @foreach ($elementsInventaire as $elementInventaire)
                                                        <option value="{{ $elementInventaire->idIngredient }}|{{ $elementInventaire->categorieIngredient }}" {{ $element['nomIngredient'] === $elementInventaire->nom ? 'selected' : '' }}>
                                                            {{ $elementInventaire->nom }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <select name="quantiteElementCompositionCarte[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                                                    @for ($i = 1; $i <= 8; $i++)
                                                        <option value="{{ $i }}" {{ $element['quantite'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <select name="choixElementCompositionCarte[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                                                    <option value="0" {{ $element['choix'] == 0 ? 'selected' : '' }}>Libre</option>
                                                    <option value="1" {{ $element['choix'] == 1 ? 'selected' : '' }}>Défaut</option>
                                                    <option value="2" {{ $element['choix'] == 2 ? 'selected' : '' }}>Obligatoire</option>
                                                </select>
                                                <button type="button" class="remove-group px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 ml-2">Supprimer</button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="add-group px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 mt-2" data-id="{{ $elementCarte->idElement }}">Ajouter un groupe</button>
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

        @include('footer')

        <!-- Dialog pour l'ajout d'un ingrédient -->
        <dialog id="addDialog">
            <h2 class="text-xl font-bold mb-4">Ajouter un élément à la carte</h2>
            <form id="ajouterElementCarte">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="nom" class="block mb-1">Nom de l'élément</label>
                        <input type="text" id="nom" name="nom" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required />
                    </div>
                    <div>
                        <label for="categorieElementCarte" class="block mb-1">Type</label>
                        <select id="categorieElementCarte" name="categorieElementCarte" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                            <option value="0">Plat</option>
                            <option value="1">Snack</option>
                            <option value="2">Boisson</option>
                            <option value="3">Menu</option>
                            <option value="4">Menu Event</option>
                        </select>
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
                        <label for="description" class="block mb-1">Description</label>
                        <textarea id="description" name="description" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" rows="3"></textarea>
                    </div>
                </div>
                <input type="hidden" id="composition" name="composition" />
                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" id="closeDialog" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Ajouter</button>
                </div>
            </form>
        </dialog>

        <script>
            // Dialog management
                                    const addDialog = document.getElementById('addDialog');
                                    document.getElementById('openAddDialog').addEventListener('click', () => addDialog.showModal());
                                    document.getElementById('closeDialog').addEventListener('click', () => addDialog.close());

                                    // Event listeners for editing rows
                                    document.querySelectorAll('.edit-btn').forEach(btn => {
                                        btn.addEventListener('click', () => {
                                            const id = btn.dataset.id;
                                            document.getElementById(`row-${id}`).classList.add('hidden');
                                            document.getElementById(`edit-row-${id}`).classList.remove('hidden');
                                        });
                                    });

                                    document.querySelectorAll('.cancel-btn').forEach(btn =>
                                        btn.addEventListener('click', () => {
                                            const id = btn.dataset.id;
                                            document.getElementById(`row-${id}`).classList.remove('hidden');
                                            document.getElementById(`edit-row-${id}`).classList.add('hidden');
                                        })
                                    );

                                    document.querySelectorAll('.save-btn').forEach(btn =>
                                        btn.addEventListener('click', () => {
                                            const id = btn.dataset.id;
                                            const formData = new FormData();
                                            formData.append('id', id);
                                            formData.append('nom', document.getElementById(`edit-nom-${id}`).value);
                                            formData.append('categorieIngredient', document.getElementById(`edit-categorie-${id}`).value);

                                            fetch('/admin/ingredients/update', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                },
                                                body: formData,
                                            })
                                                .then(res => res.json())
                                                .then(data => {
                                                    if (data.success) location.reload();
                                                    else alert('Erreur lors de la modification');
                                                });
                                        })
                                    );

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
                                                    @foreach ($elementsMenus as $elementMenus)
                                                        <option value="{{ $elementMenus->idElementMenu }}">{{ $elementMenus->nom }}</option>
                                                    @endforeach
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

                                    // Submit the form
                        document.getElementById('ajouterElementCarte').addEventListener('submit', e => {
                            e.preventDefault();
                            const elements = Array.from(document.querySelectorAll('#compositionContainer .composition-group')).map(group => {
                                const selectedOption = group.querySelector('select[name="elementCompositionCarte[]"] option:checked');
                                const [idIngredient, categorieIngredient] = selectedOption.value.split('|');
                                return {
                                    idIngredient: idIngredient,
                                    categorieIngredient: categorieIngredient || null,
                                    nomIngredient: selectedOption.textContent.trim(),
                                    quantite: group.querySelector('select[name="quantiteElementCompositionCarte[]"]').value,
                                    choix: group.querySelector('select[name="choixElementCompositionCarte[]"]').value,
                                };
                            });

                            document.getElementById('composition').value = JSON.stringify({ elements });
                            const formData = new FormData(e.target);

                                        fetch('{{ route('carte.ajouter') }}', {
                                            method: 'POST',
                                            body: formData,
                                        }).then(() => {
                                            addDialog.close();
                                            location.reload();
                                        });
                                    });


                        // ajout elements lors de la modification
                        document.addEventListener('DOMContentLoaded', () => {
                // Ajouter un groupe
                document.querySelectorAll('.add-group').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.dataset.id;
                        const container = document.getElementById(`edit-compositionContainer-${id}`);
                        const group = document.createElement('div');
                        group.className = 'composition-group flex items-center mb-2';
                        group.innerHTML = `
                            <select name="elementCompositionCarte[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                                <option value=""></option>
                                @foreach ($elementsMenus as $elementMenus)
                                    <option value="{{ $elementMenus->idElementMenu }}">{{ $elementMenus->nom }}</option>
                                @endforeach
                                @foreach ($elementsInventaire as $elementInventaire)
                                    <option value="{{ $elementInventaire->idIngredient }}|{{ $elementInventaire->categorieIngredient }}">{{ $elementInventaire->nom }}</option>
                                @endforeach
                            </select>
                            <select name="quantiteElementCompositionCarte[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                                @for ($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <select name="choixElementCompositionCarte[]" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
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

                // Supprimer un groupe
                document.querySelectorAll('.remove-group').forEach(button => {
                    button.addEventListener('click', () => {
                        button.parentElement.remove();
                    });
                });
            });

            // maj element
            document.querySelectorAll('.save-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('nom', document.getElementById(`edit-nom-${id}`).value);
                    formData.append('categorieIngredient', document.getElementById(`edit-categorie-${id}`).value);

                    const elements = Array.from(document.querySelectorAll(`#edit-compositionContainer-${id} .composition-group`)).map(group => {
                        const selectedOption = group.querySelector('select[name="elementCompositionCarte[]"] option:checked');
                        const [idIngredient, categorieIngredient] = selectedOption.value.split('|');
                        return {
                            idIngredient: idIngredient,
                            categorieIngredient: categorieIngredient || null,
                            nomIngredient: selectedOption.textContent.trim(),
                            quantite: group.querySelector('select[name="quantiteElementCompositionCarte[]"]').value,
                            choix: group.querySelector('select[name="choixElementCompositionCarte[]"]').value,
                        };
                    });

                    formData.append('composition', JSON.stringify({ elements }));

            fetch(`/admin/carte/modifier/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: formData,
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert('Élément mis à jour avec succès');
                                location.reload();
                            } else {
                                alert('Erreur : ' + data.message);
                            }
                        });
                });
            });
        </script>
    </body>
</html>
