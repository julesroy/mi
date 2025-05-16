<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Accueil Test</title>
    </head>

    <body class="bg-[#0a0a0a] pt-28 md:pt-60">
        @include('header')
        {{-- {{ dd ('Page loaded successfully') }} --}}

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-30">
            <!-- Left Sidebar -->
            <div class="space-y-6">
                <!-- Maison/Service status -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="font-bold">Maison Isen : <span class="text-green-600">ouverte</span></div>
                    <div class="font-bold">Service ce midi: <span class="text-green-600">12h - 13h</span></div>
                </div>
                <!-- Stats -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="font-bold mb-2">Stats</div>
                    <div class="flex items-center space-x-3">
                        <img src="/images/croque.png" alt="Croques" class="w-12 h-12">
                        <span class="text-xl font-semibold">36 croques vendus</span>
                    </div>
                </div>
                <!-- User Stats -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="font-bold mb-2">Tes stats</div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><!-- Plate icon SVG --></svg>
                        <span class="text-xl font-semibold">16 plats commandés</span>
                    </div>
                </div>
            </div>

            <!-- Center Content -->
            <div class="space-y-6">
                <!-- Greeting -->
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="text-2xl font-bold">Bonjour <span class="text-green-700">{{ Auth::user()->name ?? 'prénom' }}</span> !</div>
                </div>
                <!-- Actu du moment -->
                <div class="bg-yellow-50 rounded-lg shadow p-4 flex flex-col items-center">
                    <div class="text-lg font-bold mb-2">Actu du moment</div>
                    <div class="mb-1 font-semibold">Événement : repas passation</div>
                    <div class="mb-1 text-sm">Lundi 08/09/25</div>
                    <div class="bg-white rounded px-4 py-2 shadow mb-2">
                        Plat spécial + dessert + verre de vin
                    </div>
                    <div class="text-xs text-gray-500">Vente de vin sur place</div>
                    <div class="absolute top-2 right-2 bg-yellow-400 rounded-full px-3 py-1 font-bold">10€</div>
                </div>
                <!-- Festi'vendredi -->
                <div class="bg-blue-50 rounded-lg shadow p-4 flex flex-col items-center">
                    <div class="text-lg font-bold mb-2">Festi'vendredi</div>
                    <div class="mb-1 text-sm">Vendredi 16/05/25</div>
                    <div class="mb-2">Crêpes + soft (au choix)</div>
                    <div class="bg-yellow-400 rounded-full px-3 py-1 font-bold">3,30€</div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Commande info -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="font-bold">Commande : #027</div>
                    <div>Classement attente :</div>
                    <div>Chaud : <span class="font-semibold">5ème</span></div>
                    <div>Froid : <span class="font-semibold">aucun</span></div>
                </div>
                <!-- Menus -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="font-bold mb-2">Nos menus</div>
                    <ul class="space-y-2">
                        <li>Ch'ite faim <span class="float-right">3,30€</span><br><span class="text-xs">1 plat + 2 périphériques</span></li>
                        <li>P'tit quinquin <span class="float-right">3,80€</span><br><span class="text-xs">1 plat + 1 hot-dog/croque + 1 périphérique</span></li>
                        <li>T'cho biloute <span class="float-right">4,10€</span><br><span class="text-xs">2 plats</span></li>
                    </ul>
                    <button class="mt-4 w-full bg-green-600 text-white rounded py-2 font-bold">Notre carte</button>
                </div>
            </div>
        </div>

    @include('footer')
</body>
</html>