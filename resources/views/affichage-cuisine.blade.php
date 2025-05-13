<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <title>Affichage de la cuisine</title>
    </head>

    <body class="bg-[#0a0a0a] text-white h-screen flex flex-col">

        <!-- Conteneur principal -->
        <div x-data="affichageCuisine()" x-init="initialiser()" class="flex flex-col flex-grow bg-gray-100">
            <!-- Barre supérieure avec l'heure -->
            <div class="flex items-center justify-center bg-gray-800 text-white px-6 py-3">
                <!-- Timer -->
                <span x-text="heureActuelle" class="font-mono text-xl"></span>
            </div>

            <!-- Barre de statut -->
            <div class="flex h-12 bg-gray-200">
                <!-- Plats froids (1/4) -->
                <div class="flex-[1] bg-blue-500 text-white flex items-center justify-center font-bold">
                    Plats froids
                </div>
                <!-- Plats chauds (3/4) -->
                <div class="flex-[3] bg-red-500 text-white flex items-center justify-center font-bold">
                    Plats chauds
                </div>
            </div>

            <!-- Zone principale d'affichage -->
            <div class="flex flex-1 bg-white text-black text-center border-t border-gray-300">
                <!-- Section des plats froids -->
                <div class="w-1/4 p-4 border-r border-gray-300">
                    <h2 class="text-xl font-bold mb-4">Sandwiches</h2>
                    <ul class="space-y-2">
                        <li class="bg-gray-100 p-2 rounded shadow">Sandwich 1</li>
                        <li class="bg-gray-100 p-2 rounded shadow">Sandwich 2</li>
                        <li class="bg-gray-100 p-2 rounded shadow">Sandwich 3</li>
                    </ul>
                </div>

                <!-- Section des plats chauds -->
                <div class="w-3/4 grid grid-cols-3 divide-x divide-gray-300">
                    <!-- Hot Dogs -->
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-4">Hot Dogs</h2>
                        <ul class="space-y-2">
                            <li class="bg-gray-100 p-2 rounded shadow">Hot Dog 1</li>
                            <li class="bg-gray-100 p-2 rounded shadow">Hot Dog 2</li>
                        </ul>
                    </div>

                    <!-- Paninis -->
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-4">Paninis</h2>
                        <ul class="space-y-2">
                            <li class="bg-gray-100 p-2 rounded shadow">Panini 1</li>
                            <li class="bg-gray-100 p-2 rounded shadow">Panini 2</li>
                        </ul>
                    </div>

                    <!-- Croques -->
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-4">Croques</h2>
                        <ul class="space-y-2">
                            <li class="bg-gray-100 p-2 rounded shadow">Croque 1</li>
                            <li class="bg-gray-100 p-2 rounded shadow">Croque 2</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script pour l'affichage de l'heure -->
        <script>
            function affichageCuisine() {
                return {
                    heureActuelle: '', // Variable pour stocker l'heure actuelle
                    initialiser() {
                        this.mettreAJourHeure();
                        setInterval(() => this.mettreAJourHeure(), 1000); // Mise à jour toutes les secondes
                    },
                    mettreAJourHeure() {
                        const maintenant = new Date();
                        this.heureActuelle = maintenant.toLocaleTimeString('fr-FR', { 
                            hour: '2-digit', 
                            minute: '2-digit', 
                            second: '2-digit' 
                        });
                    }
                };
            }
        </script>
    </body>
</html>
