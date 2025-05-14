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
    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include("header")

        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Gestion des comptes</h1>

            <div class="overflow-x-auto min-w-full">
                <!-- Barre de recherche et bouton d'ajout -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center min-w-full mb-4 bg-gray-800 p-4 rounded gap-3 sticky left-0 top-0 z-10">
                    <form method="GET" action="{{ url()->current() }}" class="flex flex-col sm:flex-row w-full md:w-auto">
                        <input type="text" name="search" placeholder="Rechercher" class="px-3 py-2 bg-gray-700 text-white rounded-t sm:rounded-l sm:rounded-t-none border-b sm:border-b-0 sm:border-r-0 border-gray-600 w-full sm:w-auto" value="{{ request("search") }}" />
                        
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-b sm:rounded-r sm:rounded-b-none hover:bg-blue-700 w-full sm:w-auto mt-2 sm:mt-0">Rechercher</button>
                    </form>
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

                <!-- Tableau d'inventaire -->
                <div class="max-h-[280px] overflow-y-auto hide-scrollbar">
                    <table class="min-w-full table-fixed bg-white text-black rounded shadow border-collapse"">
                        <thead class="bg-gray-700 text-white">
                            <tr>
                                <th class="bg-gray-700 sticky top-0 w-1/6 py-2 px-4 border-b">
                                    <a href="{{
                                        request()->fullUrlWithQuery([
                                            "sort" => "nom",
                                            "direction" => request("sort") === "nom" && request("direction") === "asc" ? "desc" : "asc",
                                        ])
                                    }}" class="flex items-center gap-1 text-white">Numéro de compte {!! request("sort") === "nom" ? (request("direction") === "asc" ? "▲" : "▼") : "" !!}</a>
                                </th>
                                <th class="bg-gray-700 sticky top-0 w-1/6 py-2 px-4 border-b">
                                    <a href="{{
                                        request()->fullUrlWithQuery([
                                            "sort" => "nom",
                                            "direction" => request("sort") === "nom" && request("direction") === "asc" ? "desc" : "asc",
                                        ])
                                    }}" class="flex items-center gap-1 text-white">Nom {!! request("sort") === "nom" ? (request("direction") === "asc" ? "▲" : "▼") : "" !!}</a>
                                </th>
                                <th class="bg-gray-700 sticky top-0 w-1/6 py-2 px-4 border-b">
                                    <a href="{{
                                        request()->fullUrlWithQuery([
                                            "sort" => "quantite",
                                            "direction" => request("sort") === "quantite" && request("direction") === "asc" ? "desc" : "asc",
                                        ])
                                    }}" class="flex items-center gap-1 text-white">Prénom {!! request("sort") === "quantite" ? (request("direction") === "asc" ? "▲" : "▼") : "" !!}</a>
                                </th>
                                <th class="bg-gray-700 sticky top-0 w-1/6 py-2 px-4 border-b">
                                    <a class="flex items-center gap-1 text-white">Email</a>
                                </th>
                                <th class="bg-gray-700 sticky top-0 w-1/6 py-2 px-4 border-b">
                                    <a href="{{
                                        request()->fullUrlWithQuery([
                                            "sort" => "marque",
                                            "direction" => request("sort") === "marque" && request("direction") === "asc" ? "desc" : "asc",
                                        ])
                                    }}" class="flex items-center gap-1 text-white">Solde {!! request("sort") === "marque" ? (request("direction") === "asc" ? "▲" : "▼") : "" !!}</a>
                                </th>
                                @if (Auth::user() && Auth::user()->acces == 3)
                                    <th class="bg-gray-700 sticky top-0 w-1/6 py-2 px-4 border-b">
                                        <a href="{{
                                            request()->fullUrlWithQuery([
                                                "sort" => "estimationPrix",
                                                "direction" => request("sort") === "estimationPrix" && request("direction") === "asc" ? "desc" : "asc",
                                            ])
                                        }}" class="flex items-center gap-1 text-white">Accès {!! request("sort") === "estimationPrix" ? (request("direction") === "asc" ? "▲" : "▼") : "" !!}</a>
                                    </th>
                                @endif
                                <th class="bg-gray-700 sticky top-0 w-1/6 py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($utilisateurs as $donneesUtilisateur)
                                <tr id="row-{{ $donneesUtilisateur->numeroCompte }}" class="hover:bg-gray-100">
                                    <td class="w-1/6 py-2 px-4 border-b" id="id-{{ $donneesUtilisateur->numeroCompte }}">{{ $donneesUtilisateur->numeroCompte }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="nom-{{ $donneesUtilisateur->numeroCompte }}">{{ $donneesUtilisateur->nom }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="prenom-{{ $donneesUtilisateur->numeroCompte }}">{{ $donneesUtilisateur->prenom }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="email-{{ $donneesUtilisateur->numeroCompte }}">{{ $donneesUtilisateur->email }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="solde-{{ $donneesUtilisateur->numeroCompte }}">{{ $donneesUtilisateur->solde }}</td>
                                    <td class="w-1/6 py-2 px-4 border-b" id="acces-{{ $donneesUtilisateur->numeroCompte }}">{{ $donneesUtilisateur->acces }}</td>

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
                    document.getElementById(`row-${id}`).classList.add('hidden');
                    document.getElementById(`edit-row-${id}`).classList.remove('hidden');
                });
            });

            // Annuler l'édition
            document.querySelectorAll('.cancel-btn').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    document.getElementById(`row-${id}`).classList.remove('hidden');
                    document.getElementById(`edit-row-${id}`).classList.add('hidden');
                });
            });

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
                    const accesNum = {
                        0: 'Client',
                        1: 'Serveur',
                        2: 'Admin',
                        3: 'Super-Admin',
                    };

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
                                document.getElementById('acces-' + id).textContent = acces;

                                // Masque la ligne d'édition et affiche la ligne normale
                                document.getElementById('row-' + id).classList.remove('hidden');
                                document.getElementById('edit-row-' + id).classList.add('hidden');
                            } else {
                                alert('Erreur lors de la modification');
                            }
                        });
                });
            });
        </script>

        @include("footer")
    </body>
</html>
