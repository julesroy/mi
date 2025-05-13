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
            <!-- Écran de base -->
            <div id="ecran-base" class="flex flex-col items-center gap-10">
                <h1 class="text-2xl font-semibold">Fais ton choix</h1>
                <button id="btn-menus" class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Menus</button>
            </div>

            <!-- Écran des menus -->
            <div id="ecran-menus" class="hidden flex-col items-center gap-10">
                <h1 class="text-2xl font-semibold">Choisis un menu</h1>
                @foreach ($menus as $menu)
                    @php
                        $elements = json_decode($menu->ingredientsElements)->elements;
                        $quantitePlat = collect($elements)->firstWhere('nomIngredient', 'Plat')->quantite ?? 'Non spécifiée';
                        $quantiteSnack = collect($elements)->firstWhere('nomIngredient', 'Snack')->quantite ?? 'Non spécifiée';
                    @endphp

                    <button class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition" data-plats="{{ $quantitePlat }}" data-snacks="{{ $quantiteSnack }}">
                        {{ $menu->nom }}
                    </button>
                @endforeach

                <button id="btn-retour" class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Retour</button>
            </div>

            <!-- Ecran des plats -->
            <div id="ecran-plats" class="hidden flex-col items-center gap-10">
                <h1 class="text-2xl font-semibold">Choisis un plat</h1>
                @foreach ($plats as $plat)
                    <button class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition" data-nom="{{ $plat->nom }}" data-id="{{ $plat->idElement }}" data-ingredients="{{ $plat->ingredientsElements }}">{{ $plat->nom }}</button>
                @endforeach

                <button id="btn-retour-menus" class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Retour</button>
            </div>

            <!-- Ecran des ingrédients -->
            <div id="ecran-ingredients" class="hidden flex-col items-center gap-10">
                <h1 class="text-2xl font-semibold">Choisis un ingrédient</h1>
                <h4>Viandes</h4>
                <div class="grid grid-cols-4" id="liste-viandes">
                    @foreach ($viandes as $viande)
                        <button class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition" data-nom="{{ $viande->nom }}" data-id="{{ $viande->idIngredient }}">
                            {{ $viande->nom }}
                        </button>
                    @endforeach
                </div>

                <h4>Ingrédients</h4>
                <div class="grid grid-cols-4" id="liste-ingredients">
                    @foreach ($ingredients as $ingredient)
                        <button class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition" data-nom="{{ $ingredient->nom }}" data-id="{{ $ingredient->idIngredient }}">
                            {{ $ingredient->nom }}
                        </button>
                    @endforeach
                </div>
                <button id="btn-retour-plats" class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Retour</button>
            </div>

            <!-- Ecran des snacks -->
            <div id="ecran-snacks" class="hidden flex-col items-center gap-6">
                <h1 class="text-2xl font-semibold">Choisis jusqu'à 2 snacks</h1>
                <div class="grid grid-cols-2 gap-4" id="liste-snacks">
                    @foreach ($snacks as $snack)
                        <button class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition" data-nom="{{ $snack->nom }}" data-id="{{ $snack->idElement }}">
                            {{ $snack->nom }}
                        </button>
                    @endforeach
                </div>
                <button id="btn-valider-snacks" class="bg-cyan-600 text-white px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Valider</button>
                <button id="btn-retour-ingredients" class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Retour</button>
            </div>

            <!-- Ecran du panier -->
            <div id="ecran-panier" class="hidden flex-col items-center gap-6">
                <h1 class="text-2xl font-semibold">Ton panier</h1>
                <div class="bg-[#2a2a2a] p-4 rounded-xl w-full max-w-md text-left">
                    <div id="liste-commandes" class="space-y-4"></div>
                </div>
                <button id="btn-ajouter-element" class="bg-green-500 text-white px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Ajouter un autre menu</button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const btnMenus = document.getElementById('btn-menus');
                const btnRetour = document.getElementById('btn-retour');
                const btnRetourMenus = document.getElementById('btn-retour-menus');
                const btnRetourPlats = document.getElementById('btn-retour-plats');
                const btnRetourPanier = document.getElementById('btn-retour-panier');

                const ecranBase = document.getElementById('ecran-base');
                const ecranMenus = document.getElementById('ecran-menus');
                const ecranPlats = document.getElementById('ecran-plats');
                const ecranIngredients = document.getElementById('ecran-ingredients');
                const ecranPanier = document.getElementById('ecran-panier');

                const platButtons = document.querySelectorAll('#ecran-plats button[data-ingredients]');
                const menuButtons = document.querySelectorAll('#ecran-menus button[data-plats]');
                const viandeButtons = document.querySelectorAll('#liste-viandes button');
                const ingredientButtons = document.querySelectorAll('#liste-ingredients button');

                let viandeSelectionnee = null;
                let ingredientSelectionne = null;

                let commandes = [];
                let panier = {
                    menu: null,
                    plat: null,
                    viande: null,
                    ingredient: null,
                    snacks: [],
                };

                // Navigation depuis base
                btnMenus.addEventListener('click', () => {
                    ecranBase.classList.add('hidden');
                    ecranMenus.classList.remove('hidden');
                });

                // Retour depuis menus
                btnRetour.addEventListener('click', () => {
                    ecranMenus.classList.add('hidden');
                    ecranBase.classList.remove('hidden');
                });

                // Choix d’un menu
                menuButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        panier.menu = button.textContent.trim();
                        ecranMenus.classList.add('hidden');
                        ecranPlats.classList.remove('hidden');
                    });
                });

                // Retour depuis plats
                btnRetourMenus.addEventListener('click', () => {
                    ecranPlats.classList.add('hidden');
                    ecranMenus.classList.remove('hidden');
                });

                // Choix d’un plat
                platButtons.forEach((platButton) => {
                    platButton.addEventListener('click', () => {
                        const nomPlat = platButton.getAttribute('data-nom');
                        const ingredientsJson = JSON.parse(platButton.getAttribute('data-ingredients'));
                        const ingredientIds = ingredientsJson.elements.map((ing) => parseInt(ing.idIngredient));

                        panier.plat = nomPlat;

                        viandeButtons.forEach((button) => {
                            const id = parseInt(button.getAttribute('data-id'));
                            button.style.display = ingredientIds.includes(id) ? 'block' : 'none';
                            button.classList.remove('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        });

                        ingredientButtons.forEach((button) => {
                            const id = parseInt(button.getAttribute('data-id'));
                            button.style.display = ingredientIds.includes(id) ? 'block' : 'none';
                            button.classList.remove('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        });

                        viandeSelectionnee = null;
                        ingredientSelectionne = null;

                        ecranPlats.classList.add('hidden');
                        ecranIngredients.classList.remove('hidden');
                    });
                });

                // Retour depuis ingrédients
                btnRetourPlats.addEventListener('click', () => {
                    ecranIngredients.classList.add('hidden');
                    ecranPlats.classList.remove('hidden');
                });

                // Sélection unique viande
                viandeButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        if (viandeSelectionnee) {
                            viandeSelectionnee.classList.remove('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        }

                        if (viandeSelectionnee === button) {
                            viandeSelectionnee = null;
                            panier.viande = null;
                        } else {
                            viandeSelectionnee = button;
                            panier.viande = button.getAttribute('data-nom');
                            button.classList.add('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        }
                        checkPanierReady();
                    });
                });

                // Sélection unique ingrédient
                ingredientButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        if (ingredientSelectionne) {
                            ingredientSelectionne.classList.remove('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        }

                        if (ingredientSelectionne === button) {
                            ingredientSelectionne = null;
                        } else {
                            ingredientSelectionne = button;
                            button.classList.add('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');

                            // Enregistre la sélection
                            panier.viande = viandeSelectionnee?.getAttribute('data-nom') || null;
                            panier.ingredient = button.getAttribute('data-nom');

                            // Aller à l'écran des snacks
                            document.getElementById('ecran-ingredients').classList.add('hidden');
                            document.getElementById('ecran-snacks').classList.remove('hidden');
                        }
                    });
                });

                const snackButtons = document.querySelectorAll('#liste-snacks button');
                const btnValiderSnacks = document.getElementById('btn-valider-snacks');
                let snacksSelectionnes = [];

                snackButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        const nom = button.getAttribute('data-nom');

                        const index = snacksSelectionnes.indexOf(button);
                        if (index !== -1) {
                            snacksSelectionnes.splice(index, 1);
                            button.classList.remove('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        } else if (snacksSelectionnes.length < 2) {
                            snacksSelectionnes.push(button);
                            button.classList.add('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        }
                    });
                });

                // Valider les snacks et passer au panier
                btnValiderSnacks.addEventListener('click', () => {
                    panier.snacks = snacksSelectionnes.map((btn) => btn.getAttribute('data-nom'));
                    snacksSelectionnes = [];

                    // Reset les styles
                    snackButtons.forEach((btn) => btn.classList.remove('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white'));

                    // Cacher l'écran des snacks et afficher le panier
                    document.getElementById('ecran-snacks').classList.add('hidden');
                    document.getElementById('ecran-panier').classList.remove('hidden');

                    afficherPanier();
                });

                document.getElementById('btn-retour-ingredients').addEventListener('click', () => {
                    document.getElementById('ecran-snacks').classList.add('hidden');
                    document.getElementById('ecran-ingredients').classList.remove('hidden');
                });

                // Vérifie si tout est sélectionné pour afficher le panier
                function checkPanierReady() {
                    if (panier.viande && panier.ingredient && panier.snacks.length > 0) {
                        afficherPanier();
                    }
                }

                function afficherPanier() {
                    // Ajoute la commande actuelle dans la liste temporaire
                    const toutesCommandes = [...commandes, panier];

                    const conteneur = document.getElementById('liste-commandes');
                    conteneur.innerHTML = '';

                    toutesCommandes.forEach((commande, index) => {
                        const bloc = document.createElement('div');
                        bloc.className = 'bg-[#3a3a3a] p-3 rounded-xl';
                        bloc.innerHTML = `
                            <p class="font-bold">Commande ${index + 1}</p>
                            <p><strong>Menu :</strong> ${commande.menu}</p>
                            <p><strong>Plat :</strong> ${commande.plat}</p>
                            <p><strong>Viande :</strong> ${commande.viande}</p>
                            <p><strong>Ingrédient :</strong> ${commande.ingredient}</p>
                            <p><strong>Snacks :</strong> ${commande.snacks?.join(', ') || 'Aucun'}</p>

                        `;
                        conteneur.appendChild(bloc);
                    });

                    ecranIngredients.classList.add('hidden');
                    ecranPanier.classList.remove('hidden');
                }

                document.getElementById('btn-ajouter-element').addEventListener('click', () => {
                    // Ajoute la commande actuelle au tableau
                    commandes.push({ ...panier });

                    // Réinitialise le panier courant
                    panier = {
                        menu: null,
                        plat: null,
                        viande: null,
                        ingredient: null,
                    };

                    viandeSelectionnee = null;
                    ingredientSelectionne = null;

                    // Retour au début
                    ecranPanier.classList.add('hidden');
                    ecranBase.classList.remove('hidden');
                });
            });
        </script>
    </body>
</html>
