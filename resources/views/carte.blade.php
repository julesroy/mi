<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Carte</title>
    </head>

    <body class="bg-white pt-28 md:pt-57 min-h-screen flex flex-col">
        @include("header")

        <main class="flex-grow">

        <div class="max-w-6xl mx-auto px-6 sm:px-8 md:px-10 py-6 border-2 border-black rounded-lg bg-white shadow-lg mb-20">
            <!-- En-tête centré avec titre, nouveautés à gauche, engrenage à droite -->
            <div class="relative mb-6 pb-4 border-b border-black">
                <h1 class="text-4xl font-bold text-center">Carte</h1>

                <span class="absolute left-0 top-1/2 transform -translate-y-1/2 text-red-600 font-semibold text-lg">
                    Nouveautés
                </span>
                @can("verifier-acces-administrateur")
                <a href="/admin/gestion-carte" class="absolute right-0 top-1/2 transform -translate-y-1/2 hover:opacity-75">
                    <img src="{{ asset('images/icons/admin_parameter.png') }}" alt="Gestion carte" class="w-12 h-12 inline-block" />
                </a>
                @endcan
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">

                <!-- Menus -->
                <div class="border border-black rounded-lg p-4">
                    <h3 class="text-2xl font-semibold border-b border-black mb-2">Menus</h3>
                    <ul class="space-y-2 text-l">
                        <li class="text-xl font-semibold">• Ch'tite faim 
                            <span class="float-right font-normal text-base">3,30€</span><br>
                            <span class="font-normal text-base">1 plat + 2 périphériques (au choix)</span></li>
                        <li class="text-xl font-semibold">• P’tit quinguin 
                            <span class="float-right font-normal text-base">3,80€</span><br>
                            <span class="font-normal text-base">1 plat + 1 hot-dog/croque-monsieur + 1 périphérique</span></li>
                        <li class="text-xl font-semibold">• Tchô-biloute 
                            <span class="float-right font-normal text-base">4,10€</span><br>
                            <span class="font-normal text-base">2 plats (au choix)</span></li>
                    </ul>
                </div>

                <!-- Plats -->
                <div class="border border-black rounded-lg p-4">
                    <h3 class="text-2xl font-semibold border-b border-black mb-2">Plats</h3>
                    <ul class="space-y-2">
                        <ul class="space-y-2">
                        <li class="text-xl font-semibold">• Croque-monsieur
                            <span class="float-right font-normal text-base">1 : 1,10€ / 2 : 2,10€</span><br> 
                            <span class="font-normal text-base">2 garnitures au choix (1 viande max)</span>   
                        </li>
                        <li class="text-xl font-semibold">• Hot-dog
                            <span class="float-right font-normal text-base">1 : 1,10€ / 2 : 2,10€</span><br> 
                            <span class="font-normal text-base">2 sauces max, oignons frits</span>
                        </li>
                        <li class="text-xl font-semibold">• Sandwich
                            <span class="float-right font-normal text-base">2,10€</span><br> 
                            <span class="font-normal text-base">2 garnitures au choix (1 viande max), salade, tomates, beurre</span>
                        </li>   
                        <li class="text-xl font-semibold">• Panini 
                            <span class="float-right font-normal text-base">2,10€</span><br> 
                            <span class="font-normal text-base">2 plats au choix</span>
                        </li>
                    </ul>
                </div>

                <!-- Périphériques -->
                <div class="border border-black rounded-lg p-4">
                    <h3 class="text-2xl font-semibold border-b border-black mb-2">Périphériques</h3>
                    <p>
                        <span class="font-semibold text-xl">Snacks</span>
                        <span class="float-right text-base">0,80€</span>
                    </p>
                    
                    <p class="text-base">Kinder Bueno, Kinder Bueno White, Twix, M&Ms, Granola, Kinder Délice </p>
                    <br>

                    <p class="font-semibold text-xl">Boissons</p>
                    <ul class="space-y-1">
                        <li>Eau plate, eau pétillante <span class="float-right">0,50€</span></li>
                        <li>Redbull <span class="float-right">1,30€</span></li>
                        <li class="text-red-600 font-semibold">Redbull (avec goût) 
                            <span class="float-right text-red-600 font-semibold">1,50€</span></li>
                        <li>Coca, Oasis, Fanta, Sprite… 
                            <span class="float-right">0,80€</span></li>
                    </ul>
                </div>

                <!-- Garnitures -->
                <div class="border border-black rounded-lg p-4">
                    <h3 class="text-xl font-semibold border-b border-black mb-2">Garnitures</h3>
                    <p class="text-base"><span class="font-semibold">Viandes :</span> jambon, chorizo, poulet curry</p>
                    <p class="text-base"><span class="font-semibold">Fromages :</span> emmental, raclette, maroilles</p>
                </div>

                <!-- Sauces -->
                <div class="border border-black rounded-lg p-4">
                    <h3 class="text-xl font-semibold border-b border-black mb-2">Sauces</h3>
                    <p class="text-l">Ketchup, mayonnaise, moutarde</p>
                </div>
            </div>

            @if ($donneesParametres->service == 1)
                <!-- Bouton Commander -->
                <div class="flex justify-center mt-8">
                    <button href="/commander" onclick="window.location.href='/commander';" class="bg-primaire hover:bg-secondaire text-white py-2 px-8 rounded-full transition duration-200">
                        <a href="/commander">Commander</a>
                    </button>
                </div>
            @endif
        </div>

        </main>
     @include('footer')
    </body>
</html>
