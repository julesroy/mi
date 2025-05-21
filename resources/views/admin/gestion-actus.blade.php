<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        @include("head")
        <title>Gestion des actus</title>
    </head>
    <body class="bg-[rgb(10,10,10)] text-white pt-28 md:pt-45">
        @include("header")

        <div class="max-w-4xl mx-auto px-4 mb-10">
            {{-- Recherche et bouton d’ajout alignés --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between rounded bg-gray-700 gap-4 mb-6 py-3 px-4">
                <form method="GET" action="{{ route("gestion-actus") }}" class="flex-1">
                    <input type="text" name="search" placeholder="Rechercher une actu..." class="w-full md:w-72 px-3 py-2 rounded text-white bg-gray-900" value="{{ request("search") }}" />
                </form>
                <button id="openAddDialog" type="button" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold transition">+ Ajouter une actu</button>
            </div>

            {{-- Dialog d’ajout --}}
            <dialog id="addActuDialog" class="rounded-lg p-0 w-full max-w-lg">
                <form method="POST" action="{{ route("actus.store") }}" enctype="multipart/form-data" class="bg-gray-800 rounded-lg p-6 flex flex-col gap-4 text-white" style="min-width: 300px">
                    @csrf
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl font-bold">Ajouter une actu</h2>
                        <button type="button" id="closeAddDialog" class="text-gray-400 hover:text-red-400 text-2xl leading-none">&times;</button>
                    </div>
                    <input type="date" name="date" required class="px-2 py-1 rounded text-white bg-gray-900" placeholder="Date" />
                    <input type="text" name="titre" required class="px-2 py-1 rounded text-white bg-gray-900" placeholder="Titre" />
                    <textarea name="contenu" required class="px-2 py-1 rounded text-white bg-gray-900" placeholder="Contenu"></textarea>
                    <label class="block">
                        <span>Image (optionnel, jpg/png/gif, max 2Mo)</span>
                        <input type="file" name="image" accept="image/*" class="mt-1 block w-full text-white bg-gray-900 rounded" />
                    </label>
                    <div class="flex justify-end gap-2 mt-2">
                        <button type="button" id="closeAddDialog2" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-1 rounded">Annuler</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded font-semibold">Ajouter</button>
                    </div>
                </form>
            </dialog>

            {{-- Modale de modification (une seule, remplie dynamiquement) --}}
            <dialog id="editActuDialog" class="rounded-lg p-0 w-full max-w-lg">
                <form id="editActuForm" method="POST" enctype="multipart/form-data" class="bg-gray-800 rounded-lg p-6 flex flex-col gap-4 text-white" style="min-width: 300px">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="idActu" id="edit_idActu" />
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl font-bold">Modifier l’actu</h2>
                        <button type="button" id="closeEditDialog" class="text-gray-400 hover:text-red-400 text-2xl leading-none">&times;</button>
                    </div>
                    <input type="date" name="date" id="edit_date" required class="px-2 py-1 rounded text-white bg-gray-900" placeholder="Date" />
                    <input type="text" name="titre" id="edit_titre" required class="px-2 py-1 rounded text-white bg-gray-900" placeholder="Titre" />
                    <textarea name="contenu" id="edit_contenu" required class="px-2 py-1 rounded text-white bg-gray-900" placeholder="Contenu"></textarea>
                    <div id="edit_image_preview" class="mb-2"></div>
                    <label class="block">
                        <span>Nouvelle image (jpg/png/gif, max 2Mo)</span>
                        <input type="file" name="image" accept="image/*" class="mt-1 block w-full text-white bg-gray-900 rounded" />
                    </label>
                    <label class="inline-flex items-center mt-1" id="delete_image_label" style="display: none">
                        <input type="checkbox" name="delete_image" value="1" class="form-checkbox" />
                        <span class="ml-1">Supprimer l’image actuelle</span>
                    </label>
                    <div class="flex justify-end gap-2 mt-2">
                        <button type="button" id="closeEditDialog2" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-1 rounded">Annuler</button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded font-semibold">Enregistrer</button>
                    </div>
                </form>
            </dialog>

            {{-- Tableau --}}
            <div class="overflow-x-auto rounded shadow">
                <table class="min-w-full text-white">
                    <thead>
                        <tr class="bg-gray-700 text-white">
                            <th class="py-3 px-4 text-left">Date</th>
                            <th class="py-3 px-4 text-left">Titre</th>
                            <th class="py-3 px-4 text-left">Contenu</th>
                            <th class="py-3 px-4 text-left">Image</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-500">
                        @forelse ($actus as $actu)
                            <tr>
                                <td class="py-2 px-4 align-middle">{{ \Carbon\Carbon::parse($actu->date)->format("Y-m-d") }}</td>
                                <td class="py-2 px-4 align-middle font-semibold">{{ $actu->titre }}</td>
                                <td class="py-2 px-4 align-middle">{{ $actu->contenu }}</td>
                                <td class="py-2 px-4 align-middle">
                                    @if ($actu->image)
                                        <img src="{{ asset("storage/" . $actu->image) }}" alt="Image actu" class="w-20 h-12 object-cover rounded border border-gray-400" />
                                    @else
                                        <span class="text-gray-400 italic">Aucune</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 text-center align-middle">
                                    <button
                                        type="button"
                                        class="inline-block ml-2 px-3 py-1 rounded bg-blue-500 hover:bg-blue-700 text-white"
                                        onclick="openEditDialog({{ $actu->idActu }},
                                        '{{ \Carbon\Carbon::parse($actu->date)->format("Y-m-d") }}',
                                        `{{ addslashes($actu->titre) }}`,
                                        `{{ addslashes($actu->contenu) }}`,
                                        '{{ $actu->image ? asset("storage/" . $actu->image) : "" }}',
                                        '{{ $actu->image ? 1 : 0 }}'
                                    )"
                                    >
                                        Modifier
                                    </button>
                                    <form method="POST" action="{{ route("actus.destroy", $actu->idActu) }}" class="inline-block" onsubmit="return confirm('Voulez-vous vraiment supprimer cette actu ?')" style="display: inline">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="rounded px-3 p-1 bg-gray-600 text-red-500 hover:underline">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-400">Aucune actu trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            // Dialog d’ajout
            const addDialog = document.getElementById('addActuDialog');
            document.getElementById('openAddDialog').addEventListener('click', () => addDialog.showModal());
            document.getElementById('closeAddDialog').addEventListener('click', () => addDialog.close());
            document.getElementById('closeAddDialog2').addEventListener('click', () => addDialog.close());
            addDialog.addEventListener('click', function (event) {
                if (event.target === addDialog) addDialog.close();
            });

            // Dialog d’édition
            const editDialog = document.getElementById('editActuDialog');
            const editForm = document.getElementById('editActuForm');
            function openEditDialog(id, date, titre, contenu, imageUrl, hasImage) {
                editForm.action = '{{ route("actus.update", "___ID___") }}'.replace('___ID___', id);
                document.getElementById('edit_idActu').value = id;

                // Correction ici : s'assurer que la date est bien au format YYYY-MM-DD
                let formattedDate = date;
                // Si la date est du type "21/05/2025", la reformater :
                if (/^\d{2}\/\d{2}\/\d{4}$/.test(date)) {
                    const [day, month, year] = date.split('/');
                    formattedDate = `${year}-${month}-${day}`;
                }
                document.getElementById('edit_date').value = formattedDate;

                document.getElementById('edit_titre').value = titre.replace(/&quot;/g, '"');
                document.getElementById('edit_contenu').value = contenu.replace(/&quot;/g, '"');
                // Affichage de l'image
                let imgPrev = document.getElementById('edit_image_preview');
                if (hasImage == 1 && imageUrl) {
                    imgPrev.innerHTML = `<img src="${imageUrl}" alt="Image actu" class="w-24 h-16 object-cover rounded border border-gray-400 mb-1" />`;
                    document.getElementById('delete_image_label').style.display = '';
                } else {
                    imgPrev.innerHTML = `<span class="text-gray-400 italic">Aucune image</span>`;
                    document.getElementById('delete_image_label').style.display = 'none';
                }
                // Décoche la case suppression par défaut
                document.querySelector('#delete_image_label input[type=checkbox]').checked = false;
                editDialog.showModal();
            }
            document.getElementById('closeEditDialog').addEventListener('click', () => editDialog.close());
            document.getElementById('closeEditDialog2').addEventListener('click', () => editDialog.close());
            editDialog.addEventListener('click', function (event) {
                if (event.target === editDialog) editDialog.close();
            });
        </script>
    </body>
</html>
