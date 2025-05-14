<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Carte</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-60">
        @include('header')
        <div class="max-w-4xl mx-auto p-6 bg-black shadow-lg rounded-lg">
            <h1 class="text-3xl font-bold text-center mb-8">Carte</h1>
            <div class="space-y-6">
                <h2 class="text-xl">Menus</h2>
                <!-- Menu 1 -->
                <div class="flex justify-between items-center">
                    <div class="text-lg font-medium">
                        <h2 class="text-xl">Petit menu</h2>
                        <p class="text-sm text-white">Un plat (au choix) + 2 périphériques</p>
                    </div>
                    <div class="ml-auto text-sm font-bold text-red-600">3,30€</div>
                </div>

                <!-- Menu 2 -->
                <div class="flex justify-between items-center">
                    <div class="text-lg font-medium">
                        <h2 class="text-xl">Moyen Menu</h2>
                        <p class="text-sm text-white">Un plat (au choix) + 1 croque-monsieur/1 hot-dog + 1 périphérique</p>
                    </div>
                    <div class="ml-auto text-sm font-bold text-red-600">3,80€</div>
                </div>

                <!-- Menu 3 -->
                <div class="flex justify-between items-center">
                    <div class="text-lg font-medium">
                        <h2 class="text-xl">Gros menu</h2>
                        <p class="text-sm text-gray-600">Deux plats (au choix)</p>
                    </div>
                    <div class="ml-auto text-sm font-bold text-red-600">4,10€</div>
                </div>

                <!-- Plats -->
                <h2 class="text-xl">Plats</h2>
                <!-- Hot-dog -->
                <div class="flex justify-between items-center">
                    <div class="text-lg font-medium">
                        <h2 class="text-xl">Hot-dog</h2>
                        <p class="text-sm text-gray-600">Saucisse, sauces au choix (2 max), oignons frits</p>
                    </div>
                    <div class="ml-auto text-sm font-bold text-red-600">1 = 1,10€ / 2 = 2,10€</div>
                </div>

                <!-- Croque-monsieur -->
                <div class="flex justify-between items-center">
                    <div class="text-lg font-medium">
                        <h2 class="text-xl">Croque monsieur</h2>
                        <p class="text-sm text-gray-600">Garnitures (2 au choix dont 1 viande max)</p>
                    </div>
                    <div class="ml-auto text-sm font-bold text-red-600">1 = 1,10€ / 2 = 2,10€</div>
                </div>

                <!-- Sandwich -->
                <div class="flex justify-between items-center">
                    <div class="text-lg font-medium">
                        <h2 class="text-xl">Sandwich</h2>
                        <p class="text-sm text-white">Garnitures (2 au choix dont 1 viande max) + salade, tomates, beurre</p>
                    </div>
                    <div class="ml-auto text-sm font-bold text-red-600">2,10€</div>
                </div>

                <!-- Panini -->
                <div class="flex justify-between items-center">
                    <div class="text-lg font-medium">
                        <h2 class="text-xl">Panini</h2>
                        <p class="text-sm text-white">Garnitures (2 au choix) (/!\1 viande max) + salade, tomates, beurre</p>
                    </div>
                    <div class="ml-auto text-sm font-bold text-red-600">2,10€</div>
                </div>

                <!-- Périphériques -->
                <h2 class="text-xl">Périphériques</h2>
                <!-- Snacks -->
                <div class="flex justify-between items-center">
                    <div class="text-lg font-medium">
                        <h2 class="text-xl">Snacks</h2>
                        <p class="text-sm text-white">
                            Salé : chips barbecue, chips ancienne, chips nature, chips poulet
                            <br />
                            Sucré : Kinder Bueno, Kinder Bueno White, Kinder Délice, KitKat, M&Ms, Lion, Granola
                        </p>
                    </div>
                    <div class="ml-auto text-sm font-bold text-red-600">0,80€</div>
                </div>

                <!-- Boissons -->
                <div class="flex justify-between items-center">
                    <div class="text-lg font-medium">
                        <h2 class="text-xl">Snacks</h2>
                        <p class="text-sm text-white">
                            Eau : plate, gazeuse
                            <br />
                            Soft : Coca-cola, Coca-cola Zéro, Coca-Cola Cherry, Oasis Tropical, Oasis Pomme Cassis Framboise, Fanta Orange, Fante Citron, Sprite, ...
                            <br />
                            Redbull :
                        </p>
                    </div>
                    <div class="ml-auto text-sm font-bold text-red-600">
                        0,50€
                        <br />
                        0,80€
                        <br />
                        1,30€
                        <br />
                    </div>
                </div>
            </div>
        </div>
        @include('footer')
    </body>
</html>
