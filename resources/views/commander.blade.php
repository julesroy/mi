<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include("head")
    <title>Commander</title>
    <link rel="stylesheet" href="{{ asset('css/dialog.css') }}" />
</head>
<body class="bg-[#0a0a0a] text-white pt-28 md:pt-60">
    @include("header")

    <div class="flex flex-col items-center gap-6 bg-[#1a1a1a] p-6 rounded-2xl w-[90%] max-w-xl mx-auto">
        <div id="step-content"></div>
    </div>

    <style>
        .selectable {
            @apply border border-gray-600 rounded-lg px-4 py-2 cursor-pointer hover:border-blue-400;
        }
        .selected {
            @apply border-blue-600 bg-blue-700;
        }
    </style>

    <script>
        const menus = @json($menus);
        const plats = @json($plats);
        const snacks = @json($snacks);
        const ingredients = @json($ingredients);

        let currentMenu = null;
        let selectedMenuIndex = 0;
        let platsIndexes = [];
        let snacksCount = 0;
        let selectedPlats = [];
        let selectedSnacks = [];
        let currentStep = 0;

        function startCommande() {
            renderMenuSelection();
        }

        function renderMenuSelection() {
            const container = document.getElementById('step-content');
            let html = '<h2 class="text-xl font-bold mb-4">Choisissez un menu</h2><div class="flex flex-col gap-2">';

            menus.forEach((menu, index) => {
                html += `<div class="selectable" onclick="selectMenu(${index})">${menu.nom}</div>`;
            });

            html += '</div>';
            container.innerHTML = html;
        }

        function selectMenu(index) {
            selectedMenuIndex = index;
            currentMenu = menus[index];
            const elements = currentMenu.elementsMenu.split(',');
            platsIndexes = elements.filter(e => e === '0').map((_, i) => i);
            snacksCount = elements.filter(e => e === '4').length;
            selectedPlats = [];
            currentStep = 0;
            renderPlatSelection();
        }

        function renderPlatSelection() {
            const container = document.getElementById('step-content');
            let html = `<h2 class="text-xl font-bold mb-4">Choisissez un plat (${currentStep + 1}/${platsIndexes.length})</h2><div class="flex flex-col gap-2">`;

            plats.forEach((plat, i) => {
                html += `<div class="selectable" onclick="selectPlat(${i})">${plat.nom}</div>`;
            });

            html += '</div>';
            container.innerHTML = html;
        }

        function selectPlat(index) {
            renderPlatComposition(index);
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

            let html = `<h2 class="text-xl font-bold mb-4">Composer : ${plat.nom}</h2>`;
            html += `<div id="ingredients-container" class="flex flex-col gap-2">`;

            ingredientsPlat.forEach((ing, i) => {
                const ingredient = ingredients.find(obj => obj.idIngredient == ing.id);
                if (!ingredient) return;

                html += `<div class="selectable" data-id="${ing.id}" onclick="toggleSelection(this)">${ingredient.nom}</div>`;
            });

            html += '</div>';
            html += `<div class="mt-6 flex justify-between">
                        <button onclick="renderPlatSelection()" class="bg-gray-600 px-4 py-2">Retour</button>
                        <button onclick="saveSelectedIngredients(${index})" class="bg-blue-600 px-4 py-2">Valider</button>
                     </div>`;

            container.innerHTML = html;
        }

        function toggleSelection(element) {
            element.classList.toggle('selected');
        }

        function saveSelectedIngredients(platIndex) {
            const selected = [];
            document.querySelectorAll('#ingredients-container .selected').forEach(el => {
                selected.push(el.getAttribute('data-id'));
            });
            selectedPlats.push({ platIndex: platIndex, ingredients: selected });

            if (selectedPlats.length < platsIndexes.length) {
                currentStep++;
                renderPlatSelection();
            } else {
                renderSnacks(0);
            }
        }

        function renderSnacks(index) {
            const container = document.getElementById('step-content');
            let html = `<h2 class="text-xl font-bold mb-4">Choisissez un snack ou boisson (${index + 1}/${snacksCount})</h2><div class="flex flex-col gap-2">`;

            snacks.forEach((snack, i) => {
                html += `<div class="selectable" onclick="selectSnack(${index}, ${i})">${snack.nom}</div>`;
            });

            html += '</div>';
            container.innerHTML = html;
        }

        function selectSnack(snackIndex, selectionIndex) {
            selectedSnacks[snackIndex] = snacks[selectionIndex];
            if (snackIndex + 1 < snacksCount) {
                renderSnacks(snackIndex + 1);
            } else {
                renderPanier();
            }
        }

        function renderPanier() {
            const container = document.getElementById('step-content');
            let html = `<h2 class="text-xl font-bold mb-4">Panier</h2>`;

            selectedPlats.forEach((platObj, i) => {
                const plat = plats[platObj.platIndex];
                html += `<div><strong>${plat.nom}</strong> avec :`;
                const nomsIngredients = platObj.ingredients.map(id => {
                    const ingredient = ingredients.find(ing => ing.idIngredient == id);
                    return ingredient ? ingredient.nom : "?";
                });
                html += `<ul class="list-disc ml-6">` + nomsIngredients.map(n => `<li>${n}</li>`).join('') + `</ul></div><br>`;
            });

            selectedSnacks.forEach(snack => {
                html += `<div><strong>Snack/Boisson :</strong> ${snack.nom}</div>`;
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