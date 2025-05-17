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
    </style>
</head>
<body class="bg-[#0a0a0a] text-white pt-28 md:pt-60">
    @include("header")

    <div class="flex flex-col items-center gap-6 bg-[#1a1a1a] p-6 rounded-2xl w-[90%] max-w-xl mx-auto">
        <div id="step-content"></div>
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

        function startCommande() {
            selectedPlats = [];
            selectedSnacks = [];
            selectedPlatIndex = null;
            renderMenuSelection();
        }

        function renderMenuSelection() {
            const container = document.getElementById('step-content');
            let html = '<h2 class="text-xl font-bold mb-4">Choisissez un menu</h2><div class="flex flex-col gap-2">';
            menus.forEach((menu, index) => {
                html += `<button onclick="selectMenu(${index})" class="bg-blue-600 px-4 py-2 rounded">${menu.nom}</button>`;
            });
            html += '</div>';
            container.innerHTML = html;
        }

        function selectMenu(index) {
            currentMenu = menus[index];
            const elements = currentMenu.elementsMenu.split(',');
            platsIndexes = elements.filter(e => e === '0').map((_, i) => i);
            snacksCount = elements.filter(e => e === '4').length;
            currentStep = 0;
            renderPlatSelection();
        }

        function renderPlatSelection() {
            const container = document.getElementById('step-content');
            let html = '<h2 class="text-xl font-bold mb-4">Choisissez un plat</h2><div class="grid grid-cols-1 gap-2">';
            plats.forEach((plat, index) => {
                html += `<div class="selectable" onclick="selectPlat(${index}, this)">${plat.nom}</div>`;
            });
            html += '</div><div class="mt-6"><button onclick="continuePlatComposition()" class="bg-blue-600 px-4 py-2">Suivant</button></div>';
            container.innerHTML = html;
        }

        function selectPlat(index, element) {
            document.querySelectorAll('.selectable').forEach(el => el.classList.remove('selected'));
            element.classList.add('selected');
            selectedPlatIndex = index;
        }

        function continuePlatComposition() {
            if (selectedPlatIndex !== null) {
                renderPlatComposition(selectedPlatIndex);
            }
        }

        function renderPlatComposition(index) {
            const container = document.getElementById('step-content');
            const plat = plats[index];
            const ingredientsPlat = [];

            plat.ingredientsElements.split(';').forEach(item => {
                if (item.trim() === '') return;
                const [idIngredient, quantite, choix] = item.split(',');
                ingredientsPlat.push({ id: idIngredient, quantite, choix });
            });

            let html = `<h2 class="text-xl font-bold mb-4">Composition : ${plat.nom}</h2><div class="flex flex-col gap-2">`;

            ingredientsPlat.forEach((ing, i) => {
                const ingredient = ingredients.find(obj => obj.idIngredient == ing.id);
                if (!ingredient) return;

                html += `<div class="selectable" onclick="toggleSelection(this, '${ing.id}')" data-id="${ing.id}">${ingredient.nom}</div>`;
            });

            html += '</div><div class="mt-6 flex justify-between">';
            html += `<button onclick="renderPlatSelection()" class="bg-gray-600 px-4 py-2">Retour</button>`;
            html += `<button onclick="savePlat(${index})" class="bg-blue-600 px-4 py-2">Suivant</button>`;
            html += '</div>';

            container.innerHTML = html;
        }

        function toggleSelection(el, id) {
            el.classList.toggle('selected');
        }

        function savePlat(index) {
            const selected = Array.from(document.querySelectorAll('.selectable.selected'))
                .map(el => el.dataset.id);
            selectedPlats.push({ platIndex: index, ingredients: selected });
            selectedPlatIndex = null;

            if (selectedPlats.length < platsIndexes.length) {
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
            document.querySelectorAll('.selectable').forEach(e => e.classList.remove('selected'));
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

        function renderPanier() {
            const container = document.getElementById('step-content');
            let html = `<h2 class="text-xl font-bold mb-4">Panier</h2>`;

            commande.push({ plats: selectedPlats, snacks: selectedSnacks });

            commande.forEach((cmd, cmdIndex) => {
                html += `<div class="mb-4"><h3 class="text-lg font-semibold">Commande ${cmdIndex + 1}</h3>`;
                cmd.plats.forEach((platObj, i) => {
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

            html += `<div class="mt-6 flex gap-4">
                        <button onclick="startCommande()" class="bg-yellow-600 px-4 py-2">Ajouter une commande</button>
                        <button class="bg-green-700 px-4 py-2">Valider la commande</button>
                    </div>`;

            container.innerHTML = html;
        }

        document.addEventListener('DOMContentLoaded', startCommande);
    </script>
</body>
</html>