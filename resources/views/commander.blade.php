<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
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
            <div id="ecran-menus" class="hidden flex flex-col items-center gap-10">
                <h1 class="text-2xl font-semibold">Choisis un menu</h1>
                @foreach ($menus as $menu)
                    @php
                        $elements = json_decode($menu->ingredientsElements)->elements;
                    @endphp

                    <button class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition" data-nom="{{ $menu->nom }}" data-config='@json($elements)' data-id="{{ $menu->idElement }}" data-prix="{{ $menu->prix }}">
                        {{ $menu->nom }}
                    </button>
                @endforeach

                <button id="btn-retour" class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Retour</button>
            </div>

            <!-- Écran des plats -->
            <div id="ecran-plats" class="hidden flex flex-col items-center gap-10">
                <h1 class="text-2xl font-semibold">Choisis un plat</h1>
                @foreach ($plats as $plat)
                    <button class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition" data-nom="{{ $plat->nom }}" data-prix="{{ $plat->prix }}" data-id="{{ $plat->idElement }}" data-ingredients='{!! $plat->ingredientsElements !!}'>{{ $plat->nom }}</button>
                @endforeach

                <button id="btn-retour-menus" class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Retour</button>
            </div>

            <!-- Écran des ingrédients -->
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
                <button id="btn-valider-ingredients" class="bg-green-600 text-white px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Valider</button>
                <button id="btn-retour-plats" class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Retour</button>
            </div>

            <!-- Écran des snacks -->
            <div id="ecran-snacks" class="hidden flex-col items-center gap-10">
                <h1 class="text-2xl font-semibold">Choisis tes snacks (2 max)</h1>
                <div class="grid grid-cols-4" id="liste-snacks">
                    @foreach ($snacks as $snack)
                        <button class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition" data-nom="{{ $snack->nom }}" data-id="{{ $snack->idElement }}">
                            {{ $snack->nom }}
                        </button>
                    @endforeach

                    @foreach ($boissons as $boisson)
                        <button class="bg-white text-black px-6 py-3 rounded-2xl shadow hover:scale-105 transition" data-nom="{{ $boisson->nom }}" data-id="{{ $boisson->idElement }}">
                            {{ $boisson->nom }}
                        </button>
                    @endforeach
                </div>
                <button id="btn-valider-snacks" class="bg-green-600 text-white px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Valider</button>
            </div>

            <!-- Écran du panier -->
            <div id="ecran-panier" class="hidden flex-col items-center gap-6">
                <h1 class="text-2xl font-semibold">Ton panier</h1>
                <div id="recap-panier" class="text-white"></div>
                <button id="btn-nouvelle-commande" class="bg-cyan-600 text-white px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Commander autre chose</button>
                <button id="btn-valider-commande" class="bg-green-600 text-white px-6 py-3 rounded-2xl shadow hover:scale-105 transition">Valider la commande</button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let configActuelle = [];
                let etapeIndex = 0;
                let panier = { commandes: [] };
                let commandeActuelle = {};

                const ecrans = {
                    base: document.getElementById('ecran-base'),
                    menus: document.getElementById('ecran-menus'),
                    plats: document.getElementById('ecran-plats'),
                    ingredients: document.getElementById('ecran-ingredients'),
                    snacks: document.getElementById('ecran-snacks'),
                    panier: document.getElementById('ecran-panier'),
                };

                const boutonsMenu = document.querySelectorAll('#ecran-menus button[data-config]');
                const boutonsPlat = document.querySelectorAll('#ecran-plats button[data-ingredients]');
                const boutonsViande = document.querySelectorAll('#liste-viandes button');
                const boutonsIngredient = document.querySelectorAll('#liste-ingredients button');
                const boutonsSnack = document.querySelectorAll('#liste-snacks button');

                let selectionViande = null;
                let selectionIngredient = null;
                let snacksSelectionnes = [];

                function afficherEcran(cle) {
                    Object.values(ecrans).forEach((e) => e.classList.add('hidden'));
                    ecrans[cle].classList.remove('hidden');
                }

                function suivant() {
                    etapeIndex++;
                    const etape = configActuelle[etapeIndex];
                    if (!etape) {
                        afficherPanier();
                        return;
                    }
                    if (etape.nomIngredient === 'Plat') afficherEcran('plats');
                    else if (etape.nomIngredient === 'Snack') afficherEcran('snacks');
                    else if (etape.nomIngredient === 'Boisson') afficherPanier();
                }

                function afficherPanier() {
                    panier.commandes.push({ ...commandeActuelle });
                    const recap = panier.commandes.map((cmd, i) => `Commande ${i + 1}: ${cmd.menu} - ${cmd.plat} - ${cmd.viande || ''} - ${cmd.ingredient || ''} - Snacks: ${(cmd.snacks || []).join(', ')} - Prix: ${cmd.prix.toFixed(2)}€`).join('<br>');
                    document.getElementById('recap-panier').innerHTML = recap;
                    afficherEcran('panier');
                }

                document.getElementById('btn-menus').addEventListener('click', () => afficherEcran('menus'));

                document.getElementById('btn-retour').addEventListener('click', () => afficherEcran('base'));
                document.getElementById('btn-retour-menus').addEventListener('click', () => afficherEcran('menus'));
                document.getElementById('btn-retour-plats').addEventListener('click', () => afficherEcran('plats'));

                document.getElementById('btn-nouvelle-commande').addEventListener('click', () => {
                    commandeActuelle = {};
                    selectionViande = null;
                    selectionIngredient = null;
                    snacksSelectionnes = [];
                    etapeIndex = 0;
                    afficherEcran('base');
                });

                boutonsMenu.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        configActuelle = JSON.parse(btn.getAttribute('data-config'));
                        commandeActuelle = { menu: btn.getAttribute('data-id'), prix: parseFloat(btn.getAttribute('data-prix')) };
                        etapeIndex = -1;
                        suivant();
                    });
                });

                boutonsPlat.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        commandeActuelle.plat = btn.getAttribute('data-id');
                        const data = JSON.parse(btn.getAttribute('data-ingredients'));
                        const ids = data.elements.map((e) => parseInt(e.idIngredient));

                        boutonsViande.forEach((b) => {
                            const id = parseInt(b.getAttribute('data-id'));
                            b.style.display = ids.includes(id) ? 'block' : 'none';
                            b.classList.remove('selected');
                        });
                        boutonsIngredient.forEach((b) => {
                            const id = parseInt(b.getAttribute('data-id'));
                            b.style.display = ids.includes(id) ? 'block' : 'none';
                            b.classList.remove('selected');
                        });
                        afficherEcran('ingredients');
                    });
                });

                boutonsViande.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        if (selectionViande) selectionViande.classList.remove('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        if (selectionViande === btn) selectionViande = null;
                        else {
                            selectionViande = btn;
                            btn.classList.add('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        }
                    });
                });

                boutonsIngredient.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        if (selectionIngredient) selectionIngredient.classList.remove('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        if (selectionIngredient === btn) selectionIngredient = null;
                        else {
                            selectionIngredient = btn;
                            btn.classList.add('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        }
                    });
                });

                document.getElementById('btn-valider-ingredients').addEventListener('click', () => {
                    commandeActuelle.viande = selectionViande?.getAttribute('data-id') || '';
                    commandeActuelle.ingredient = selectionIngredient?.getAttribute('data-id') || '';
                    suivant();
                });

                boutonsSnack.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        if (snacksSelectionnes.includes(btn)) {
                            btn.classList.remove('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                            snacksSelectionnes = snacksSelectionnes.filter((b) => b !== btn);
                        } else if (snacksSelectionnes.length < 2) {
                            snacksSelectionnes.push(btn);
                            btn.classList.add('ring-2', 'ring-cyan-400', 'bg-cyan-600', 'text-white');
                        }
                    });
                });

                document.getElementById('btn-valider-snacks').addEventListener('click', () => {
                    commandeActuelle.snacks = snacksSelectionnes.map((b) => b.getAttribute('data-nom'));
                    snacksSelectionnes = [];
                    suivant();
                    console.log(panier);
                });

                document.getElementById('btn-valider-commande').addEventListener('click', () => {
                    const panierJson = JSON.stringify(panier);

                    // on envoie le panier
                    fetch('/commander/valider', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: panierJson,
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                alert('Commande validée avec succès !');
                                location.reload();
                            } else {
                                alert('Erreur lors de la validation de la commande : ' + data.message);
                            }
                        })
                        .catch((error) => {
                            console.error("Erreur lors de l'envoi de la commande :", error);
                            alert('Une erreur est survenue. Veuillez réessayer.');
                        });
                });
            });
        </script>
    </body>
</html>
