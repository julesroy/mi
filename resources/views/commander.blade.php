<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Commander</title>
        <link rel="stylesheet" href="{{ asset('css/dialog.css') }}" />
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include('header')

        <div class="flex flex-col items-center gap-6 bg-[#1a1a1a] p-6 rounded-2xl w-[90%] max-w-xl mx-auto">
            <!-- Écran 1 -->
            <div id="ecran-1" class="flex flex-col items-center gap-10">
                <h1 class="text-2xl font-semibold">Fais ton choix</h1>
                <div class="flex gap-4">
                    <button id="btn-menus" class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Menus</button>
                </div>
            </div>

            <!-- Écran 2 -->
            <div id="ecran-2" class="hidden flex flex-col items-center gap-10">
                <h1 class="text-2xl font-semibold">Choisis un menu</h1>
                <div class="flex gap-4">
                    <button id="btn-menu-1" class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Menu 1</button>
                </div>
                <button onclick="retourEcran('ecran-1', 'ecran-2')" class="text-sm underline">Retour</button>
            </div>

            <!-- Écran Choix Type -->
            <div id="ecran-choix-type" class="hidden flex flex-col items-center gap-10">
                <h1 class="text-2xl font-semibold">Choisis ton type</h1>
                <div class="flex gap-4">
                    <button class="btn-type bg-white text-black px-6 py-3 rounded-2xl" data-type="croque">Croque-Monsieur</button>
                    <button class="btn-type bg-white text-black px-6 py-3 rounded-2xl" data-type="sandwich">Sandwich</button>
                    <button class="btn-type bg-white text-black px-6 py-3 rounded-2xl" data-type="panini">Panini</button>
                </div>
                <button onclick="retourEcran('ecran-2', 'ecran-choix-type')" class="text-sm underline">Retour</button>
            </div>

            <!-- Écran Composition -->
            <div id="ecran-composition" class="hidden flex flex-col items-center gap-6">
                <h1 class="text-2xl font-semibold">Choisis tes ingrédients</h1>
                <div id="zone-composition" class="flex flex-wrap justify-center gap-4"></div>
                <div class="flex gap-4">
                    <button onclick="retourEcran('ecran-choix-type', 'ecran-composition')" class="text-sm underline">Retour</button>
                    <button id="btn-suivant-composition" class="mt-4 bg-white text-black px-6 py-2 rounded-xl">Suivant</button>
                </div>
            </div>

            <!-- Écran Snacks -->
            <div id="ecran-snacks" class="hidden flex flex-col items-center gap-6">
                <h1 class="text-2xl font-semibold">Choisis 2 snacks ou boissons</h1>
                <div class="flex gap-6 text-lg">
                    <span id="tab-snacks" class="cursor-pointer border-b-2 border-white pb-1">Snacks</span>
                    <span id="tab-boissons" class="cursor-pointer text-gray-400 pb-1">Boissons</span>
                </div>
                <div id="zone-snacks" class="grid grid-cols-2 gap-4">
                    <div class="snack-item bg-[#1a1a1a] px-4 py-3 rounded-xl cursor-pointer">🍪 Cookie</div>
                    <div class="snack-item bg-[#1a1a1a] px-4 py-3 rounded-xl cursor-pointer">🍫 Barre</div>
                </div>
                <div id="zone-boissons" class="hidden grid grid-cols-2 gap-4">
                    <div class="snack-item bg-[#1a1a1a] px-4 py-3 rounded-xl cursor-pointer">🥤 Soda</div>
                    <div class="snack-item bg-[#1a1a1a] px-4 py-3 rounded-xl cursor-pointer">☕ Café</div>
                </div>
                <div class="flex gap-4">
                    <button onclick="retourEcran('ecran-composition', 'ecran-snacks')" class="text-sm underline">Retour</button>
                    <button class="mt-4 bg-white text-black px-6 py-2 rounded-xl" onclick="validerCommande()">Suivant</button>
                </div>
            </div>

            <!-- Écran Panier -->
            <div id="ecran-panier" class="hidden flex flex-col items-center gap-6">
                <h2 class="text-2xl font-semibold">Récapitulatif de ta commande</h2>
                <ul id="liste-panier" class="list-disc list-inside text-sm space-y-1 mb-2"></ul>
                <p class="text-lg font-semibold">
                    Total :
                    <span id="total-panier">0.00€</span>
                </p>
                <button class="text-sm underline" onclick="ajouterUnElement()">Ajouter un autre élément</button>
            </div>
        </div>

        @include('footer')

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const e1 = document.getElementById('ecran-1');
                const e2 = document.getElementById('ecran-2');
                const eType = document.getElementById('ecran-choix-type');
                const eComp = document.getElementById('ecran-composition');
                const eSnacks = document.getElementById('ecran-snacks');
                const ePanier = document.getElementById('ecran-panier');

                let panier = [];
                let total = 0;
                let plat = '';
                let currentSelection = [];

                const compositions = {
                    croque: ['Raclette', 'Emmental'],
                    sandwich: ['Jambon', 'Poulet'],
                    panini: ['Mozza', 'Thon'],
                };

                function retourEcran(prevId, currentId) {
                    document.getElementById(currentId).classList.add('hidden');
                    document.getElementById(prevId).classList.remove('hidden');
                }

                function updateTotal() {
                    document.getElementById('total-panier').textContent = total.toFixed(2) + '€';
                }

                function validerCommande() {
                    panier = panier.concat(currentSelection);
                    const liste = document.getElementById('liste-panier');
                    liste.innerHTML = '';
                    panier.forEach((item) => {
                        const li = document.createElement('li');
                        li.textContent = item;
                        liste.appendChild(li);
                    });
                    updateTotal();
                    eSnacks.classList.add('hidden');
                    ePanier.classList.remove('hidden');
                }

                function ajouterUnElement() {
                    currentSelection = [];
                    ePanier.classList.add('hidden');
                    e1.classList.remove('hidden');
                }

                document.getElementById('btn-menus').onclick = () => {
                    e1.classList.add('hidden');
                    e2.classList.remove('hidden');
                };

                document.getElementById('btn-menu-1').onclick = () => {
                    e2.classList.add('hidden');
                    eType.classList.remove('hidden');
                };

                document.querySelectorAll('.btn-type').forEach((btn) => {
                    btn.onclick = () => {
                        plat = btn.dataset.type;
                        currentSelection = [];
                        eType.classList.add('hidden');
                        eComp.classList.remove('hidden');

                        const zone = document.getElementById('zone-composition');
                        zone.innerHTML = '';
                        compositions[plat].forEach((ing) => {
                            const div = document.createElement('div');
                            div.className = 'px-4 py-2 bg-[#1a1a1a] rounded-xl cursor-pointer hover:bg-white hover:text-black transition';
                            div.textContent = ing;

                            div.onclick = () => {
                                const item = `${plat} - ${ing}`;
                                if (currentSelection.includes(item)) {
                                    currentSelection = currentSelection.filter((i) => i !== item);
                                    total -= 5.0;
                                    div.classList.remove('bg-white', 'text-black');
                                } else {
                                    currentSelection.push(item);
                                    total += 5.0;
                                    div.classList.add('bg-white', 'text-black');
                                }
                                updateTotal();
                            };

                            zone.appendChild(div);
                        });
                    };
                });

                document.getElementById('btn-suivant-composition').onclick = () => {
                    eComp.classList.add('hidden');
                    eSnacks.classList.remove('hidden');
                    document.querySelectorAll('.snack-item').forEach((el) => el.classList.remove('selected', 'bg-white', 'text-black'));
                };

                document.getElementById('tab-snacks').onclick = () => {
                    document.getElementById('tab-snacks').classList.add('border-white', 'text-white');
                    document.getElementById('tab-boissons').classList.remove('border-white');
                    document.getElementById('tab-boissons').classList.add('text-gray-400');
                    document.getElementById('zone-snacks').classList.remove('hidden');
                    document.getElementById('zone-boissons').classList.add('hidden');
                };

                document.getElementById('tab-boissons').onclick = () => {
                    document.getElementById('tab-boissons').classList.add('border-white', 'text-white');
                    document.getElementById('tab-snacks').classList.remove('border-white');
                    document.getElementById('tab-snacks').classList.add('text-gray-400');
                    document.getElementById('zone-snacks').classList.add('hidden');
                    document.getElementById('zone-boissons').classList.remove('hidden');
                };

                document.querySelectorAll('.snack-item').forEach((item) => {
                    item.onclick = () => {
                        const snack = item.textContent.trim();
                        if (item.classList.contains('selected')) {
                            currentSelection = currentSelection.filter((i) => i !== snack);
                            item.classList.remove('selected', 'bg-white', 'text-black');
                            total -= 2.0;
                        } else if (currentSelection.filter((i) => i === snack).length < 2) {
                            currentSelection.push(snack);
                            item.classList.add('selected', 'bg-white', 'text-black');
                            total += 2.0;
                        }
                        updateTotal();
                    };
                });

                // Expose les fonctions globales
                window.retourEcran = retourEcran;
                window.validerCommande = validerCommande;
                window.ajouterUnElement = ajouterUnElement;
            });
        </script>
    </body>
</html>
