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

    <script>
        const menus = @json($menus);
        const plats = @json($plats);
        const snacks = @json($snacks);
        const ingredients = @json($ingredients);

        let currentMenu = null;
        let currentStep = 0;
        let selectedMenuIndex = 0;
        let platsIndexes = [];
        let snacksCount = 0;
        let selectedPlats = [];
        let selectedSnacks = [];

        function startCommande() {
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
            selectedMenuIndex = index;
            currentMenu = menus[index];
            const elements = currentMenu.elementsMenu.split(',');
            platsIndexes = elements.filter(e => e === '0').map((_, i) => i);
            snacksCount = elements.filter(e => e === '4').length;
            selectedPlats = [];
            currentStep = 0;
            renderPlat(0);
        }

        function renderPlat(index) {
            const container = document.getElementById('step-content');
            const plat = plats[index];

            const ingredientsPlat = [];
            plat.ingredientsElements.split(';').forEach(item => {
                if (item.trim() === '') return;
                const [idIngredient, quantite, choix] = item.split(',');
                ingredientsPlat.push({ id: idIngredient, quantite, choix });
            });

            let html = `<h2 class="text-xl font-bold mb-4">${plat.nom}</h2><form id="composition-plat-${index}" class="flex flex-col gap-2">`;
            const groupeChoix = [];

            ingredientsPlat.forEach((ing, i) => {
                const ingredient = ingredients.find(obj => obj.idIngredient == ing.id);
                if (!ingredient) return;

                if (ing.choix === '2') {
                    html += `<div><strong>${ingredient.nom}</strong> (obligatoire)</div>`;
                } else if (ing.choix === '0') {
                    html += `
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="ingredient-${i}" value="${ing.id}" checked />
                            ${ingredient.nom}
                        </label>`;
                } else if (ing.choix === '1') {
                    groupeChoix.push({ index: i, id: ing.id, nom: ingredient.nom });
                }
            });

            if (groupeChoix.length) {
                html += `<div class="mt-4"><strong>Choix obligatoire :</strong><div class="ml-2">`;
                groupeChoix.forEach((g, i) => {
                    html += `
                        <label class="flex items-center gap-2">
                            <input type="radio" name="choix_unique_${index}" value="${g.id}" ${i === 0 ? 'checked' : ''} />
                            ${g.nom}
                        </label>`;
                });
                html += `</div></div>`;
            }

            html += `</form>`;
            container.innerHTML = html;
            renderNavigationButtons(index, plats.length, 'plat');
        }

        function renderNavigationButtons(index, total, type) {
            const container = document.getElementById('step-content');
            let html = `<div class="mt-6 flex justify-between">`;

            if (index > 0) {
                html += `<button onclick="renderPlat(${index - 1})" class="bg-gray-600 px-4 py-2">Retour</button>`;
            }

            html += `<button onclick="saveAndContinue(${index})" class="bg-blue-600 px-4 py-2">Suivant</button>`;
            html += `</div>`;

            container.innerHTML += html;
        }

        function saveAndContinue(index) {
            const form = document.querySelector(`#composition-plat-${index}`);
            const formData = new FormData(form);
            const selected = [];

            form.querySelectorAll('input[type="checkbox"]:checked').forEach(input => {
                selected.push(input.value);
            });

            form.querySelectorAll('input[type="radio"]:checked').forEach(input => {
                selected.push(input.value);
            });

            selectedPlats.push({ platIndex: index, ingredients: selected });

            if (selectedPlats.length < platsIndexes.length) {
                renderPlat(selectedPlats.length);
            } else {
                renderSnacks(0);
            }
        }

        function renderSnacks(index) {
            const container = document.getElementById('step-content');
            let html = `<h2 class="text-xl font-bold mb-4">Choisissez votre snack ou boisson (${index + 1}/${snacksCount})</h2><div class="flex flex-col gap-2">`;

            snacks.forEach((snack, i) => {
                html += `<button onclick="selectSnack(${index}, ${i})" class="bg-green-600 px-4 py-2">${snack.nom}</button>`;
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

        // Démarrage de la commande au chargement
        document.addEventListener('DOMContentLoaded', startCommande);
    </script>
</body>
</html>