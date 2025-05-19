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
                <form method="POST" action="{{ route("actus.store") }}" class="bg-gray-800 rounded-lg p-6 flex flex-col gap-4 text-white" style="min-width: 300px">
                    @csrf
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl font-bold">Ajouter une actu</h2>
                        <button type="button" id="closeAddDialog" class="text-gray-400 hover:text-red-400 text-2xl leading-none">&times;</button>
                    </div>
                    <input type="date" name="date" required class="px-2 py-1 rounded text-white bg-gray-900" placeholder="Date" />
                    <input type="text" name="titre" required class="px-2 py-1 rounded text-white bg-gray-900" placeholder="Titre" />
                    <textarea name="contenu" required class="px-2 py-1 rounded text-white bg-gray-900" placeholder="Contenu"></textarea>
                    <div class="flex justify-end gap-2 mt-2">
                        <button type="button" id="closeAddDialog2" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-1 rounded">Annuler</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded font-semibold">Ajouter</button>
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
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-500">
                        @forelse ($actus as $actu)
                            <tr id="row-{{ $actu->idActu }}">
                                <td class="py-2 px-4 align-middle" data-field="date">{{ \Carbon\Carbon::parse($actu->date)->format("Y-m-d") }}</td>
                                <td class="py-2 px-4 align-middle font-semibold" data-field="titre">{{ $actu->titre }}</td>
                                <td class="py-2 px-4 align-middle" data-field="contenu">{{ $actu->contenu }}</td>
                                <td class="py-2 px-4 text-center align-middle" data-field="actions">
                                    <button type="button" class="inline-block ml-2 px-3 py-1 rounded bg-blue-500 hover:bg-blue-700 text-white" onclick="editRow({{ $actu->idActu }})">Modifier</button>
                                    <form method="POST" action="{{ route("actus.destroy", $actu->idActu) }}" class="inline-block" onsubmit="return confirm('Voulez-vous vraiment supprimer cette actu ?')" style="display: inline">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="rounded px-3 p-1 bg-gray-600 text-red-500 hover:underline">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-400">Aucune actu trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            // Dialog d’ajout (inchangé)
            const addDialog = document.getElementById('addActuDialog');
            document.getElementById('openAddDialog').addEventListener('click', () => {
                addDialog.showModal();
            });
            document.getElementById('closeAddDialog').addEventListener('click', () => {
                addDialog.close();
            });
            document.getElementById('closeAddDialog2').addEventListener('click', () => {
                addDialog.close();
            });
            addDialog.addEventListener('click', function (event) {
                if (event.target === addDialog) addDialog.close();
            });

            // Modification inline
            let editingRow = null;
            function editRow(id) {
                if (editingRow) return; // Une seule édition à la fois
                editingRow = id;

                const row = document.getElementById('row-' + id);
                const dateCell = row.querySelector('[data-field="date"]');
                const titreCell = row.querySelector('[data-field="titre"]');
                const contenuCell = row.querySelector('[data-field="contenu"]');
                const actionsCell = row.querySelector('[data-field="actions"]');

                // On garde les anciennes valeurs pour annuler (on encode en base64)
                const oldDate = dateCell.textContent.trim();
                const oldTitre = titreCell.textContent.trim();
                const oldContenu = contenuCell.textContent.trim();
                const oldTitreB64 = btoa(unescape(encodeURIComponent(oldTitre)));
                const oldContenuB64 = btoa(unescape(encodeURIComponent(oldContenu)));

                dateCell.innerHTML = `<input type="date" value="${oldDate}" class="px-2 py-1 rounded text-white bg-gray-900" style="width: 130px;" id="edit_date_${id}">`;
                titreCell.innerHTML = `<input type="text" value="${oldTitre.replace(/"/g, '&quot;')}" class="px-2 py-1 rounded text-white bg-gray-900" style="width: 130px;" id="edit_titre_${id}">`;
                contenuCell.innerHTML = `<input type="text" value="${oldContenu.replace(/"/g, '&quot;')}" class="px-2 py-1 rounded text-white bg-gray-900" style="width: 180px;" id="edit_contenu_${id}">`;

                const updateUrl = '{{ route("actus.update", "___ID___") }}'.replace('___ID___', id);
                const deleteUrl = '{{ route("actus.destroy", "___ID___") }}'.replace('___ID___', id);

                actionsCell.innerHTML = `
                    <button type="button" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded font-semibold" onclick="saveRow(${id})">Enregistrer</button>
                    <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded font-semibold ml-2"
                        onclick="cancelEdit(${id}, '${oldDate}', '${oldTitreB64}', '${oldContenuB64}')">Annuler</button>
                    <form method="POST" action="${deleteUrl}" class="inline-block" onsubmit="return confirm('Voulez-vous vraiment supprimer cette actu ?')" style="display:inline">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="rounded px-3 p-1 bg-gray-600 text-red-500 hover:underline">Supprimer</button>
                    </form>
                `;
            }

            function cancelEdit(id, oldDate, oldTitreB64, oldContenuB64) {
                const row = document.getElementById('row-' + id);
                // On décode les valeurs base64
                const oldTitre = decodeURIComponent(escape(atob(oldTitreB64)));
                const oldContenu = decodeURIComponent(escape(atob(oldContenuB64)));

                row.querySelector('[data-field="date"]').textContent = oldDate;
                row.querySelector('[data-field="titre"]').textContent = oldTitre;
                row.querySelector('[data-field="contenu"]').textContent = oldContenu;

                const deleteUrl = '{{ route("actus.destroy", "___ID___") }}'.replace('___ID___', id);

                row.querySelector('[data-field="actions"]').innerHTML = `
                    <button type="button" class="inline-block ml-2 px-3 py-1 rounded bg-blue-500 hover:bg-blue-700 text-white" onclick="editRow(${id})">Modifier</button>
                    <form method="POST" action="${deleteUrl}" class="inline-block" onsubmit="return confirm('Voulez-vous vraiment supprimer cette actu ?')" style="display:inline">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="rounded px-3 p-1 bg-gray-600 text-red-500 hover:underline">Supprimer</button>
                    </form>
                `;
                editingRow = null;
            }

            function saveRow(id) {
                const row = document.getElementById('row-' + id);
                const date = row.querySelector(`#edit_date_${id}`).value;
                const titre = row.querySelector(`#edit_titre_${id}`).value;
                const contenu = row.querySelector(`#edit_contenu_${id}`).value;

                const updateUrl = '{{ route("actus.update", "___ID___") }}'.replace('___ID___', id);

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = updateUrl;

                // CSRF
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                // Method spoofing
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'PUT';
                form.appendChild(method);

                // Champs
                const inputDate = document.createElement('input');
                inputDate.type = 'hidden';
                inputDate.name = 'date';
                inputDate.value = date;
                form.appendChild(inputDate);

                const inputTitre = document.createElement('input');
                inputTitre.type = 'hidden';
                inputTitre.name = 'titre';
                inputTitre.value = titre;
                form.appendChild(inputTitre);

                const inputContenu = document.createElement('input');
                inputContenu.type = 'hidden';
                inputContenu.name = 'contenu';
                inputContenu.value = contenu;
                form.appendChild(inputContenu);

                document.body.appendChild(form);
                form.submit();
            }
        </script>
        @include("footer")
    </body>
</html>
