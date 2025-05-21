<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        @include("head")
        <title>Inventaire</title>
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
            <h1 class="text-2xl font-bold mb-4">Inventaire des ingrédients</h1>

            <div class="overflow-x-auto min-w-full">
                <!-- Barre de recherche et bouton d'ajout -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center min-w-full mb-4 bg-primaire p-4 rounded gap-3 sticky left-0 top-0 z-10">
                    <form class="flex flex-col sm:flex-row w-full md:w-auto">
                        <input type="text" name="search" id="recherche-utilisateur" placeholder="Rechercher" class="bg-white px-3 py-2 rounded-t sm:rounded-l sm:rounded-t-none border-b sm:border-b-0 sm:border-r-0 border-gray-600 w-full sm:w-auto" />
                    </form>
                    <button id="openAddDialog" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full md:w-auto">+ Ajouter un ingrédient</button>
                </div>

                <!-- Indication du tri actuel -->
                <p class="min-w-full mb-2 text-sm text-black">
                    Trié par
                    <span class="font-semibold text-black" id="type-tri">défaut</span>
                </p>

                <div class="max-h-128 md:max-h-96 overflow-y-auto hide-scrollbar rounded-2xl border-2 border-primaire">
                    <!-- Tableau de gestion d'inventaire -->
                    <table class="min-w-full table-fixed bg-white text-black border-collapse text-center text-xs sm:text-sm md:text-base">
                        <thead class="bg-primaire text-white sticky z-10">
                            <tr>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b sortable" data-key="nom">Nom</th>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b sortable" data-key="quantite">Quantité</th>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b sortable" data-key="marque">Marque</th>
                                @if (Auth::user() && Auth::user()->acces == 3)
                                    <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b">Prix estimé</th>
                                @endif
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b" data-key="categorie">Catégorie</th>
                                <th class="sticky bg-primaire top-0 w-1/6 py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ingredients as $ingredient)
                                <tr id="row-{{ $ingredient->idIngredient }}" class="hover:bg-gray-100">
                                    <td class="w-1/6 py-2 px-4 border-b" id="nom-{{ $ingredient->idIngredient }}">{{ $ingredient->nom }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="quantite-{{ $ingredient->idIngredient }}">{{ $ingredient->quantite }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="marque-{{ $ingredient->idIngredient }}">{{ $ingredient->marque }}</td>
                                    @if (Auth::user() && Auth::user()->acces == 3)
                                        <td class="w-1/6 py-2 px-4 border-b" id="prix-{{ $ingredient->idIngredient }}">{{ $ingredient->estimationPrix }}</td>
                                    @endif

                                    <td class="w-1/6 py-2 px-4 border-b" id="categorie-{{ $ingredient->idIngredient }}">
                                        {{ $categories[$ingredient->categorieIngredient] ?? "Inconnu" }}
                                    </td>
                                    <td class="w-1/6 py-2 px-4 border-b text-center">
                                        <div class="flex justify-center">
                                            <img src="{{ asset('images/icons/edit.svg') }}" alt="Modifier"
                                                class="action-icon edit-btn"
                                                data-id="{{ $ingredient->idIngredient }}" />
                                    
                                            <img src="{{ asset('images/icons/delete.svg') }}" alt="Supprimer"
                                                class="action-icon delete-btn"
                                                data-id="{{ $ingredient->idIngredient }}" />
                                    
                                            @if($ingredient->commentaire)
                                                <img src="{{ asset('images/icons/commentaire.svg') }}" alt="Commentaire"
                                                    class="action-icon comment-btn cursor-pointer"
                                                    onclick="showComment('{{ addslashes($ingredient->nom) }}', `{{ addslashes($ingredient->commentaire) }}`)" />
                                            @endif
                                        </div>
                                    </td>
                                    
                                </tr>
                                <tr id="edit-row-{{ $ingredient->idIngredient }}" class="hidden bg-gray-200">
                                    <td class="w-1/6 py-2 px-4 border-b">
                                        <input type="text" class="w-full p-1 border" id="edit-nom-{{ $ingredient->idIngredient }}" value="{{ $ingredient->nom }}" />
                                    </td>
                                    <td class="w-1/6 py-2 px-4 border-b">
                                        <input type="number" class="w-full p-1 border" id="edit-quantite-{{ $ingredient->idIngredient }}" value="{{ $ingredient->quantite }}" />
                                    </td>
                                    <td class="w-1/6 py-2 px-4 border-b">
                                        <input type="text" class="w-full p-1 border" id="edit-marque-{{ $ingredient->idIngredient }}" value="{{ $ingredient->marque }}" />
                                    </td>
                                    @if (Auth::user() && Auth::user()->acces == 3)
                                        <td class="w-1/6 py-2 px-4 border-b">
                                            <input type="number" step="0.01" class="w-full p-1 border" id="edit-prix-{{ $ingredient->idIngredient }}" value="{{ $ingredient->estimationPrix }}" />
                                        </td>
                                    @endif

                                    <td class="w-1/6 py-2 px-4 border-b">
                                        <select class="w-full p-1 border" id="edit-categorie-{{ $ingredient->idIngredient }}">
                                            <option value="0" {{ $ingredient->categorieIngredient == 0 ? "selected" : "" }}>Ingrédient</option>
                                            <option value="1" {{ $ingredient->categorieIngredient == 1 ? "selected" : "" }}>Viande</option>
                                            <option value="2" {{ $ingredient->categorieIngredient == 2 ? "selected" : "" }}>Extra</option>
                                            <option value="3" {{ $ingredient->categorieIngredient == 3 ? "selected" : "" }}>Snack/Boisson</option>
                                        </select>
                                    </td>
                                    <td class="text-center w-1/6 py-2 px-4 border-b">
                                        <button class="px-4 py-2 bg-green-600 text-white rounded save-btn w-28" data-id="{{ $ingredient->idIngredient }}">Enregistrer</button>
                                        <button class="px-4 py-2 bg-gray-400 text-white rounded cancel-btn w-28 mt-1" data-id="{{ $ingredient->idIngredient }}">Annuler</button>
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

        <!-- Dialog pour l'ajout d'un ingrédient -->
        <dialog id="addDialog" class="hide-scrollbar">
            <h2 class="text-xl font-bold mb-4">Ajouter un article</h2>
            <form id="addIngredientForm" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="nom" class="block mb-1">Nom de l'article</label>
                        <input type="text" id="nom" name="nom" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required />
                    </div>

                    <div>
                        <label for="categorieIngredient" class="block mb-1">Type</label>
                        <select id="categorieIngredient" name="categorieIngredient" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required>
                            <option value="0">Ingrédient</option>
                            <option value="1">Viande</option>
                            <option value="2">Extra</option>
                            <option value="3">Snack/Boisson</option>
                        </select>
                    </div>

                    <div>
                        <label for="quantite" class="block mb-1">Quantité</label>
                        <input type="number" id="quantite" name="quantite" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required />
                    </div>

                    <div>
                        <label for="marque" class="block mb-1">Marque</label>
                        <input type="text" id="marque" name="marque" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" required />
                    </div>

                    <div>
                        <label for="commentaire" class="block mb-1">Commentaire (optionnel)</label>
                        <textarea id="commentaire" name="commentaire" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" rows="3"></textarea>
                    </div>

                    @if (Auth::user() && Auth::user()->acces == 3)
                        <div>
                            <label for="estimationPrix" class="block mb-1">Prix estimé</label>
                            <input type="number" step="0.01" id="estimationPrix" name="estimationPrix" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600" />
                        </div>
                    @endif
                </div>

                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" id="closeDialog" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Ajouter</button>
                </div>
            </form>
        </dialog>

        <!-- Dialog de confirmation de suppression -->
        <dialog id="deleteDialog" class="p-4 rounded">
            <h2 class="text-xl font-bold mb-4">Confirmer la suppression</h2>
            <p>Êtes-vous sûr de vouloir supprimer cet ingrédient ?</p>
            <div class="flex justify-end space-x-2 mt-4">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Annuler</button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
            </div>
            <input type="hidden" id="deleteIngredientId" />
        </dialog>

        <script>
            const categories = {
                0: 'Ingrédient',
                1: 'Viande',
                2: 'Extra',
                3: 'Snack/Boisson',
            };

            // Gestion des dialogues
            const addDialog = document.getElementById('addDialog');
            const deleteDialog = document.getElementById('deleteDialog');

            // Ouvrir le dialogue d'ajout
            document.getElementById('openAddDialog').addEventListener('click', () => {
                addDialog.showModal();
            });

            // Fermer le dialogue d'ajout
            document.getElementById('closeDialog').addEventListener('click', () => {
                addDialog.close();
            });

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

            // Sauvegarder l'édition
            document.querySelectorAll('.save-btn').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');

                    // Récupère les valeurs des champs d'édition
                    const nom = document.getElementById('edit-nom-' + id).value;
                    const quantite = document.getElementById('edit-quantite-' + id).value;
                    const marque = document.getElementById('edit-marque-' + id).value;
                    const categorie = document.getElementById('edit-categorie-' + id).value;
                    const commentaire = document.getElementById('edit-commentaire-' + id) ? document.getElementById('edit-commentaire-' + id).value : '';
                    const estimationPrix = document.getElementById('edit-prix-' + id) ? document.getElementById('edit-prix-' + id).value : '';

                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('nom', nom);
                    formData.append('quantite', quantite);
                    formData.append('marque', marque);
                    formData.append('categorieIngredient', categorie);
                    formData.append('commentaire', commentaire);
                    formData.append('estimationPrix', estimationPrix);

                    fetch('/admin/ingredients/update', {
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
                                document.getElementById('nom-' + id).textContent = nom;
                                document.getElementById('quantite-' + id).textContent = quantite;
                                document.getElementById('marque-' + id).textContent = marque;
                                if (document.getElementById('prix-' + id)) {
                                    document.getElementById('prix-' + id).textContent = estimationPrix;
                                }
                                document.getElementById('categorie-' + id).textContent = categories[categorie] ?? 'Inconnu';

                                // Masque la ligne d'édition et affiche la ligne normale
                                document.getElementById('row-' + id).classList.remove('hidden');
                                document.getElementById('edit-row-' + id).classList.add('hidden');
                            } else {
                                alert('Erreur lors de la modification');
                            }
                        });
                });
            });

            // Supprimer un ingrédient (afficher la confirmation)
            document.querySelectorAll('.delete-btn').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    document.getElementById('deleteIngredientId').value = id;
                    deleteDialog.showModal();
                });
            });

            // Annuler la suppression
            document.getElementById('cancelDelete').addEventListener('click', () => {
                deleteDialog.close();
            });

            // Confirmer la suppression
            document.getElementById('confirmDelete').addEventListener('click', function () {
                const id = document.getElementById('deleteIngredientId').value;

                // Envoi de la requête de suppression
                fetch('{{ route("ingredients.delete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ id: id }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Supprimer la ligne du tableau
                            document.getElementById(`row-${id}`).remove();
                            document.getElementById(`edit-row-${id}`).remove();
                            deleteDialog.close();
                        } else {
                            alert('Erreur: ' + data.message);
                        }
                    })
                    .catch((error) => {
                        console.error('Erreur:', error);
                        alert("Une erreur s'est produite lors de la suppression.");
                    });
            });

            // Soumission du formulaire d'ajout
            document.getElementById('addIngredientForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                // Envoi des données au serveur
                fetch('{{ route("ingredients.store") }}', {
                    method: 'POST',
                    body: formData,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Rafraîchir la page pour afficher le nouvel ingrédient
                            window.location.reload();
                        } else {
                            alert('Erreur: ' + data.message);
                        }
                    })
                    .catch((error) => {
                        console.error('Erreur:', error);
                        alert("Une erreur s'est produite lors de l'ajout.");
                    });
            });
        </script>

        <script src="{{ asset("js/recherche.js") }}"></script>
        <script src="{{ asset("js/tri-tableaux.js") }}"></script>
    </body>
</html>
