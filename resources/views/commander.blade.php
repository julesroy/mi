<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include("head")
    <title>Commander</title>
    <link rel="stylesheet" href="{{ asset('css/dialog.css') }}" />
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
        let selectedPlatIndex = null;
        let enModePlatALaCarte = false;

        function startCommande() {
            enModePlatALaCarte = false;
            selectedPlats = [];
            selectedSnacks = [];
            currentMenu = null;
            currentStep = 0;
            platsIndexes = [];
            snacksCount = 0;
            selectedPlatIndex = null;

            renderMenuSelection();
            showPlatALaCarteButton(true);
        }

        function showPlatALaCarteButton(show) {
            const container = document.getElementById('carte-button-container');
            if(show) {
                container.innerHTML = `<button onclick="startPlatALaCarte()" class="btn-main">Plat à la carte</button>`;
            } else {
                container.innerHTML = '';
            }
        }

        function renderMenuSelection() {
            const container = document.getElementById('step-content');
            let html = '<h2 class="text-xl font-bold mb-4">Choisissez un menu</h2><div class="flex flex-col gap-2">';
            menus.forEach((menu, index) => {
                html += `<button onclick="selectMenu(${index})" class="btn-main">${menu.nom}</button>`;
            });
            html += '</div>';
            container.innerHTML = html;
        }

        function selectMenu(index) {
            enModePlatALaCarte = false;
            showPlatALaCarteButton(false);
            currentMenu = menus[index];
            const elements = currentMenu.elementsMenu.split(',');
            platsIndexes = elements.map((e,i) => e === '0' ? i : -1).filter(i => i !== -1);
            snacksCount = elements.filter(e => e === '4').length;
            currentStep = 0;
            selectedPlats = [];
            selectedSnacks = [];
            renderPlatSelection();
        }

        // ====================
        // PLAT À LA CARTE MODE
        // ====================
        function startPlatALaCarte() {
            enModePlatALaCarte = true;
            showPlatALaCarteButton(false);
            selectedPlatIndex = null;
            selectedPlats = [];
            selectedSnacks = [];
            currentStep = 0;
            renderPlatSelectionPlatALaCarte();
        }

        function renderPlatSelectionPlatALaCarte() {
            const container = document.getElementById('step-content');
            let html = '<h2 class="text-xl font-bold mb-4">Choisissez un plat à la carte</h2><div class="grid grid-cols-1 gap-2">';
            plats.forEach((plat, index) => {
                html += `<div class="selectable" onclick="selectPlat(${index}, this)">${plat.nom}</div>`;
            });
            html += '</div><div class="mt-6 flex justify-between">';
            html += `<button onclick="cancelPlatALaCarte()" class="bg-gray-600 px-4 py-2 rounded">Retour</button>`;
            html += `<button onclick="continuePlatCompositionPlatALaCarte()" class="btn-main">Suivant</button>`;
            html += '</div>';
            container.innerHTML = html;
        }

        function cancelPlatALaCarte() {
            enModePlatALaCarte = false;
            selectedPlatIndex = null;
            startCommande();
        }

        function continuePlatCompositionPlatALaCarte() {
            if(selectedPlatIndex !== null) {
                renderPlatCompositionPlatALaCarte(selectedPlatIndex);
            } else {
                alert("Veuillez choisir un plat.");
            }
        }

        function selectPlat(index, element) {
            document.querySelectorAll('.selectable').forEach(el => el.classList.remove('selected'));
            element.classList.add('selected');
            selectedPlatIndex = index;
        }

        function renderPlatCompositionPlatALaCarte(index) {
            const container = document.getElementById('step-content');
            const plat = plats[index];
            const ingredientsPlat = [];

            if (plat.ingredientsElements) {
                plat.ingredientsElements.split(';').forEach(item => {
                    if (item.trim() === '') return;
                    const [idIngredient, quantite, choix] = item.split(',');
                    ingredientsPlat.push({ id: idIngredient, quantite, choix });
                });
            }

            let html = `<h2 class="text-xl font-bold mb-4">Composition : ${plat.nom}</h2><div class="flex flex-col gap-2">`;

            ingredientsPlat.forEach(ing => {
                const ingredient = ingredients.find(obj => obj.idIngredient == ing.id);
                if (!ingredient) return;

                html += `<div class="selectable" data-id="${ing.id}" onclick="toggleSelection(this, '${ing.id}')">${ingredient.nom}</div>`;
            });

            html += '</div><div class="mt-6 flex justify-between">';
            html += `<button onclick="renderPlatSelectionPlatALaCarte()" class="bg-gray-600 px-4 py-2 rounded">Retour</button>`;
            html += `<button onclick="savePlatALaCarte(${index})" class="btn-main">Ajouter au panier</button>`;
            html += '</div>';

            container.innerHTML = html;
        }

        function toggleSelection(el, id) {
            el.classList.toggle('selected');
        }

        function savePlatALaCarte(index) {
            const selected = Array.from(document.querySelectorAll('.selectable.selected'))
                .map(el => el.dataset.id);

            if(selected.length === 0) {
                alert("Veuillez sélectionner au moins un ingrédient.");
                return;
            }

            // Ajoute la commande plat à la carte dans le panier
            commande.push({ plats: [{ platIndex: index, ingredients: selected }], snacks: [] });

            // Affiche directement le panier
            renderPanier();
        }

        // ====================
        // FIN PLAT À LA CARTE
        // ====================


        // Partie menu classique

        function renderPlatSelection() {
            const container = document.getElementById('step-content');
            let html = '<h2 class="text-xl font-bold mb-4">Choisissez un plat</h2><div class="grid grid-cols-1 gap-2">';
            plats.forEach((plat, index) => {
                html += `<div class="selectable" onclick="selectPlat(${index}, this)">${plat.nom}</div>`;
            });
            html += '</div><div class="mt-6 flex justify-between">';
            if(currentStep > 0) {
                html += `<button onclick="goBackStep()" class="bg-gray-600 px-4 py-2 rounded">Retour</button>`;
            }
            html += `<button onclick="continuePlatComposition()" class="btn-main">Suivant</button>`;
            html += '</div>';
            container.innerHTML = html;
        }

        function continuePlatComposition() {
            if (selectedPlatIndex !== null) {
                renderPlatComposition(selectedPlatIndex);
            } else {
                alert("Veuillez choisir un plat.");
            }
        }

        function renderPlatComposition(index) {
            const container = document.getElementById('step-content');
            const plat = plats[index];
            const ingredientsPlat = [];

            if (plat.ingredientsElements) {
                plat.ingredientsElements.split(';').forEach(item => {
                    if (item.trim() === '') return;
                    const [idIngredient, quantite, choix] = item.split(',');
                    ingredientsPlat.push({ id: idIngredient, quantite, choix });
                });
            }

            let html = `<h2 class="text-xl font-bold mb-4">Composition : ${plat.nom}</h2><div class="flex flex-col gap-2">`;

            ingredientsPlat.forEach(ing => {
                const ingredient = ingredients.find(obj => obj.idIngredient == ing.id);
                if (!ingredient) return;

                html += `<div class="selectable" data-id="${ing.id}" onclick="toggleSelection(this, '${ing.id}')">${ingredient.nom}</div>`;
            });

            html += '</div><div class="mt-6 flex justify-between">';
            html += `<button onclick="renderPlatSelection()" class="bg-gray-600 px-4 py-2 rounded">Retour</button>`;
            html += `<button onclick="savePlat(${index})" class="btn-main">Suivant</button>`;
            html += '</div>';

            container.innerHTML = html;
        }

        function savePlat(index) {
            const selected = Array.from(document.querySelectorAll('.selectable.selected'))
                .map(el => el.dataset.id);

            if(selected.length === 0) {
                alert("Veuillez sélectionner au moins un ingrédient.");
                return;
            }

            selectedPlats.push({ platIndex: index, ingredients: selected });
            selectedPlatIndex = null;
            currentStep++;

            if (currentStep < platsIndexes.length) {
                renderPlatSelection();
            } else if (snacksCount > 0) {
                renderSnacks(0);
            } else {
                renderPanier();
                showPlatALaCarteButton(true);
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
            document.querySelectorAll('.selectable').forEach(e => e.classList.remove('selected'));
            el.classList.add('selected');
            selectedSnacks[snackIndex] = snacks[selectionIndex];
            setTimeout(() => {
                if (snackIndex + 1 < snacksCount) {
                    renderSnacks(snackIndex + 1);
                } else {
                    renderPanier();
                    showPlatALaCarteButton(true);
                }
            }, 300);
        }

        function deleteCommande(index) {
            commande.splice(index, 1);
            renderPanier();
            showPlatALaCarteButton(true);
        }

        function renderPanier() {
            const container = document.getElementById('step-content');
            let html = `<h2 class="text-xl font-bold mb-4">Panier</h2>`;

            if (selectedPlats.length || selectedSnacks.length) {
                commande.push({ plats: selectedPlats, snacks: selectedSnacks });
                selectedPlats = [];
                selectedSnacks = [];
            }

            if(commande.length === 0) {
                html += "<p>Votre panier est vide.</p>";
            }

            commande.forEach((cmd, cmdIndex) => {
                html += `<div class="mb-4 p-4 rounded bg-[#2a2a2a]">
                            <h3 class="text-lg font-semibold flex justify-between items-center">
                                Commande ${cmdIndex + 1}
                                <button onclick="deleteCommande(${cmdIndex})" class="text-red-400 hover:text-red-600">Supprimer</button>
                            </h3>`;

                cmd.plats.forEach((platObj) => {
                    const plat = plats[platObj.platIndex];
                    html += `<div><strong>${plat.nom}</strong> avec :`;
                    const nomsIngredients = platObj.ingredients.map(id => {
                        const ingredient = ingredients.find(ing => ing.idIngredient == id);
                        return ingredient ? ingredient.nom : "?";
                    });
                    html += `<ul class="list-disc ml-6">` + nomsIngredients.map(n => `<li>${n}</li>`).join('') + `</ul></div><br>`;
                });

                cmd.snacks.forEach(snack => {
                    html += `<div><strong>Snack/Boisson :</strong> ${snack.nom}</div>`;
                });

                html += `</div>`;
            });

            html += `<div class="mt-6 flex gap-4 justify-center">
                        <button onclick="startCommande()" class="btn-main">Ajouter une commande</button>
                        <button class="btn-main">Valider la commande</button>
                    </div>`;

            container.innerHTML = html;
        }

        function goBackStep() {
            if(currentStep > 0) {
                currentStep--;
                selectedPlats.pop();
                renderPlatSelection();
            } else {
                startCommande();
            }
        }

        document.addEventListener('DOMContentLoaded', startCommande);
    </script>
</body>
</html>