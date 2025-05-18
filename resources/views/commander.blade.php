<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @include("head")
        <title>Commander</title>
        <link rel="stylesheet" href="{{ asset("css/dialog.css") }}" />
        <style>
            .selectable {
                border: 2px solid #444;
                border-radius: 0.5rem;
                padding: 0.5rem;
                cursor: pointer;
                transition: border-color 0.2s;
            }
            .selectable.selected {
                border-color: #22c55e;
            }
            .btn-main {
                background-color: #7c3aed; /* violet */
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                cursor: pointer;
                font-weight: bold;
            }
            .btn-main:hover {
                background-color: #6d28d9;
            }
        </style>
    </head>
    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-60">
        @include("header")

        <div class="flex flex-col items-center gap-6 bg-[#1a1a1a] p-6 rounded-2xl w-[90%] max-w-xl mx-auto">
            <div id="step-content"></div>
            <div id="carte-button-container" class="mt-6 w-full flex justify-center"></div>
        </div>

        <script>
            const menus = @json($menus);
            const plats = @json($plats);
            const snacks = @json($snacks);
            const ingredients = @json($ingredients);

            let currentMenu = null;
            let currentStep = 0;
            let platsIndexes = [];
            let snacksCount = 0;
            let selectedPlats = [];
            let selectedSnacks = [];
            let commande = [];
            let selectedPlatId = null;
            let enModePlatALaCarte = false;

            function startCommande() {
                enModePlatALaCarte = false;
                selectedPlats = [];
                selectedSnacks = [];
                currentMenu = null;
                currentStep = 0;
                platsIndexes = [];
                snacksCount = 0;
                selectedPlatId = null;

                renderMenuSelection();
            }

            function renderMenuSelection() {
                const container = document.getElementById('step-content');
                let html = '<h2 class="text-xl font-bold mb-4">Choisissez un menu</h2><div class="flex flex-col gap-2">';
                menus.forEach((menu) => {
                    html += `<button onclick="selectMenu(${menu.idMenu})" class="btn-main">${menu.nom}</button>`;
                });
                html += `<button onclick="startPlatALaCarte()" class="btn-main">Plat à la carte</button>`;
                html += '</div>';
                container.innerHTML = html;
            }

            function selectMenu(idMenu) {
                enModePlatALaCarte = false;
                currentMenu = menus.find((m) => m.idMenu == idMenu);
                const elements = currentMenu.elementsMenu.split(',');
                platsIndexes = elements.map((e, i) => (e === '0' ? i : -1)).filter((i) => i !== -1);
                snacksCount = elements.filter((e) => e === '4').length;
                currentStep = 0;
                selectedPlats = [];
                selectedSnacks = [];
                renderPlatSelection();
            }

            function startPlatALaCarte() {
                enModePlatALaCarte = true;
                selectedPlatId = null;
                selectedPlats = [];
                selectedSnacks = [];
                currentStep = 0;
                renderPlatSelectionPlatALaCarte();
            }

            function renderPlatSelectionPlatALaCarte() {
                const container = document.getElementById('step-content');
                let html = '<h2 class="text-xl font-bold mb-4">Choisissez un plat à la carte</h2><div class="grid grid-cols-1 gap-2">';
                plats.forEach((plat) => {
                    html += `<div class="selectable" onclick="selectPlat(${plat.idElement}, this)">${plat.nom}</div>`;
                });
                html += '</div><div class="mt-6 flex justify-between">';
                html += `<button onclick="cancelPlatALaCarte()" class="bg-gray-600 px-4 py-2 rounded">Retour</button>`;
                html += `<button onclick="continuePlatCompositionPlatALaCarte()" class="btn-main">Suivant</button>`;
                html += '</div>';
                container.innerHTML = html;
            }

            function cancelPlatALaCarte() {
                enModePlatALaCarte = false;
                selectedPlatId = null;
                startCommande();
            }

            function continuePlatCompositionPlatALaCarte() {
                if (selectedPlatId !== null) {
                    renderPlatCompositionPlatALaCarte(selectedPlatId);
                } else {
                    alert('Veuillez choisir un plat.');
                }
            }

            function selectPlat(id, element) {
                document.querySelectorAll('.selectable').forEach((el) => el.classList.remove('selected'));
                element.classList.add('selected');
                selectedPlatId = id;
            }

            function renderPlatCompositionPlatALaCarte(id) {
                const container = document.getElementById('step-content');
                const plat = plats.find((p) => p.idElement == id);
                const ingredientsPlat = [];

                if (plat.ingredientsElements) {
                    plat.ingredientsElements.split(';').forEach((item) => {
                        if (item.trim() === '') return;
                        const [idIngredient, quantite, choix] = item.split(',');
                        ingredientsPlat.push({ id: idIngredient, quantite, choix });
                    });
                }

                let html = `<h2 class="text-xl font-bold mb-4">Composition : ${plat.nom}</h2><div class="flex flex-col gap-2">`;

                ingredientsPlat.forEach((ing) => {
                    const ingredient = ingredients.find((obj) => obj.idIngredient == ing.id);
                    if (!ingredient) return;

                    html += `<div class="selectable" data-id="${ing.id}" onclick="toggleSelection(this, '${ing.id}')">${ingredient.nom}</div>`;
                });

                html += '</div><div class="mt-6 flex justify-between">';
                html += `<button onclick="renderPlatSelectionPlatALaCarte()" class="bg-gray-600 px-4 py-2 rounded">Retour</button>`;
                html += `<button onclick="savePlatALaCarte(${id})" class="btn-main">Ajouter au panier</button>`;
                html += '</div>';

                container.innerHTML = html;
            }

            function toggleSelection(el, id) {
                el.classList.toggle('selected');
            }

            function savePlatALaCarte(id) {
                const selected = Array.from(document.querySelectorAll('.selectable.selected')).map((el) => el.dataset.id);

                if (selected.length === 0) {
                    alert('Veuillez sélectionner au moins un ingrédient.');
                    return;
                }

                commande.push({ plats: [{ idElement: id, ingredients: selected }], snacks: [] });
                renderPanier();
            }

            function renderPlatSelection() {
                const container = document.getElementById('step-content');
                let html = '<h2 class="text-xl font-bold mb-4">Choisissez un plat</h2><div class="grid grid-cols-1 gap-2">';
                plats.forEach((plat) => {
                    html += `<div class="selectable" onclick="selectPlat(${plat.idElement}, this)">${plat.nom}</div>`;
                });
                html += '</div><div class="mt-6 flex justify-between">';
                if (currentStep > 0) {
                    html += `<button onclick="goBackStep()" class="bg-gray-600 px-4 py-2 rounded">Retour</button>`;
                }
                html += `<button onclick="continuePlatComposition()" class="btn-main">Suivant</button>`;
                html += '</div>';
                container.innerHTML = html;
            }

            function continuePlatComposition() {
                if (selectedPlatId !== null) {
                    renderPlatComposition(selectedPlatId);
                } else {
                    alert('Veuillez choisir un plat.');
                }
            }

            function renderPlatComposition(id) {
                const container = document.getElementById('step-content');
                const plat = plats.find((p) => p.idElement == id);
                const ingredientsPlat = [];

                if (plat.ingredientsElements) {
                    plat.ingredientsElements.split(';').forEach((item) => {
                        if (item.trim() === '') return;
                        const [idIngredient, quantite, choix] = item.split(',');
                        ingredientsPlat.push({ id: idIngredient, quantite, choix });
                    });
                }

                let html = `<h2 class="text-xl font-bold mb-4">Composition : ${plat.nom}</h2><div class="flex flex-col gap-2">`;

                ingredientsPlat.forEach((ing) => {
                    const ingredient = ingredients.find((obj) => obj.idIngredient == ing.id);
                    if (!ingredient) return;

                    html += `<div class="selectable" data-id="${ing.id}" onclick="toggleSelection(this, '${ing.id}')">${ingredient.nom}</div>`;
                });

                html += '</div><div class="mt-6 flex justify-between">';
                html += `<button onclick="renderPlatSelection()" class="bg-gray-600 px-4 py-2 rounded">Retour</button>`;
                html += `<button onclick="savePlat(${id})" class="btn-main">Suivant</button>`;
                html += '</div>';

                container.innerHTML = html;
            }

            function savePlat(id) {
                const selected = Array.from(document.querySelectorAll('.selectable.selected')).map((el) => el.dataset.id);

                if (selected.length === 0) {
                    alert('Veuillez sélectionner au moins un ingrédient.');
                    return;
                }

                selectedPlats.push({ idElement: id, ingredients: selected });
                selectedPlatId = null;
                currentStep++;

                if (currentStep < platsIndexes.length) {
                    renderPlatSelection();
                } else if (snacksCount > 0) {
                    renderSnacks(0);
                } else {
                    renderPanier();
                }
            }

            function renderSnacks(index) {
                const container = document.getElementById('step-content');
                let html = `<h2 class="text-xl font-bold mb-4">Choisissez votre snack/boisson (${index + 1}/${snacksCount})</h2><div class="grid grid-cols-1 gap-2">`;
                snacks.forEach((snack, i) => {
                    html += `<div class="selectable" onclick="selectSnack(${index}, ${i}, this)">${snack.nom}</div>`;
                });
                html += '</div>';
                container.innerHTML = html;
            }

            function selectSnack(snackIndex, selectionIndex, el) {
                document.querySelectorAll('.selectable').forEach((e) => e.classList.remove('selected'));
                el.classList.add('selected');
                selectedSnacks[snackIndex] = snacks[selectionIndex];
                setTimeout(() => {
                    if (snackIndex + 1 < snacksCount) {
                        renderSnacks(snackIndex + 1);
                    } else {
                        renderPanier();
                    }
                }, 300);
            }

            function deleteCommande(index) {
                commande.splice(index, 1);
                renderPanier();
            }

            function renderPanier() {
                const container = document.getElementById('step-content');
                let html = `<h2 class="text-xl font-bold mb-4">Panier</h2>`;

                if (selectedPlats.length || selectedSnacks.length) {
                    commande.push({ plats: selectedPlats, snacks: selectedSnacks });
                    selectedPlats = [];
                    selectedSnacks = [];
                }

                if (commande.length === 0) {
                    html += '<p>Votre panier est vide.</p>';
                }

                commande.forEach((cmd, cmdIndex) => {
                    html += `<div class="mb-4 p-4 rounded bg-[#2a2a2a]">
                        <h3 class="text-lg font-semibold flex justify-between items-center">
                            Commande ${cmdIndex + 1}
                            <button onclick="deleteCommande(${cmdIndex})" class="text-red-400 hover:text-red-600">Supprimer</button>
                        </h3>`;

                    cmd.plats.forEach((platObj) => {
                        const plat = plats.find((p) => p.idElement == platObj.idElement);
                        html += `<div><strong>${plat.nom}</strong> avec :`;
                        const nomsIngredients = platObj.ingredients.map((id) => {
                            const ingredient = ingredients.find((ing) => ing.idIngredient == id);
                            return ingredient ? ingredient.nom : '?';
                        });
                        html += `<ul class="list-disc ml-6">` + nomsIngredients.map((n) => `<li>${n}</li>`).join('') + `</ul></div><br>`;
                    });

                    cmd.snacks.forEach((snack) => {
                        html += `<div><strong>Snack/Boisson :</strong> ${snack.nom}</div>`;
                    });

                    html += `</div>`;
                });

                html += `<div class="mt-6 flex gap-4 justify-center">
                    <button onclick="startCommande()" class="btn-main">Ajouter une commande</button>
                    <button onclick="submitCommande()" class="btn-main">Valider la commande</button>
                </div>`;

                container.innerHTML = html;

                console.log('Commande finale :', commande);
            }

            function goBackStep() {
                if (currentStep > 0) {
                    currentStep--;
                    selectedPlats.pop();
                    renderPlatSelection();
                } else {
                    startCommande();
                }
            }

            document.addEventListener('DOMContentLoaded', startCommande);

            function submitCommande() {
                if (selectedPlats.length || selectedSnacks.length) {
                    commande.push({ plats: selectedPlats, snacks: selectedSnacks });
                    selectedPlats = [];
                    selectedSnacks = [];
                }

                const input = document.getElementById('panier-input');
                input.value = JSON.stringify(commande);

                document.getElementById('commande-form').submit();
            }
        </script>

        <form id="commande-form" method="POST" action="{{ route("commander.valider") }}" class="hidden">
            @csrf
            <input type="hidden" name="panier" id="panier-input" />
        </form>
    </body>
</html>
