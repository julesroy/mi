<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        @include("head")
        <title>Affichage de la cuisine</title>
    </head>

    <body class="bg-[#0a0a0a] text-white h-screen flex flex-col">
        <!-- Conteneur principal -->
        <div class="flex flex-col flex-grow bg-gray-100">
            <!-- Barre supérieure avec l'heure -->
            <div class="flex items-center justify-center bg-gray-800 text-white px-6 py-3">
                <!-- Timer -->
                <span id="heureActuelle" class="font-mono text-xl"></span>
            </div>

            <!-- Barre de statut -->
            <div class="flex h-12 bg-gray-200">
                <div class="flex-[1] bg-blue-500 text-white flex items-center justify-center font-bold">Plats froids</div>
                <div class="flex-[1] bg-yellow-500 text-white flex items-center justify-center font-bold">Hot-dogs</div>
                <div class="flex-[2] bg-red-500 text-white flex items-center justify-center font-bold">Plats chauds</div>
            </div>

            <!-- Zone principale d'affichage -->
            <div class="flex flex-1 bg-white text-black text-center border-t border-gray-300">
                <!-- Section des plats froids -->
                <div class="w-1/4 p-4 border-r border-gray-300">
                    <ul class="space-y-2">
                        @foreach ($commandes->where("categorieCommande", 0) as $commande)
                            <!-- 0 = froid -->
                            <li class="bg-gray-100 p-2 rounded shadow">
                                <p><strong>Commande #{{ $commande->numeroCommande }}</strong></p>
                                <p>{{ $commande->menu }}</p>
                                <p><small>{{ $commande->commentaire }}</small></p>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Section des hot-dogs -->
                <div class="w-1/4 p-4 border-r border-gray-300">
                    <ul class="space-y-2">
                        @foreach ($commandes->where("categorieCommande", 1) as $commande)
                            <!-- 1 = hot-dog -->
                            <li class="bg-gray-100 p-2 rounded shadow">
                                <p><strong>Commande #{{ $commande->numeroCommande }}</strong></p>
                                <p>{{ $commande->menu }}</p>
                                <p><small>{{ $commande->commentaire }}</small></p>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Section des plats chauds -->
                <div class="w-2/4 p-4">
                    <ul class="space-y-2">
                        @foreach ($commandes->where("categorieCommande", 2) as $commande)
                            <!-- 2 = chaud -->
                            <li class="bg-gray-100 p-2 rounded shadow">
                                <p><strong>Commande #{{ $commande->numeroCommande }}</strong></p>
                                <p>{{ $commande->menu }}</p>
                                <p><small>{{ $commande->commentaire }}</small></p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Script pour l'affichage de l'heure -->
        <script>
            function mettreAJourHeure() {
                const maintenant = new Date();
                document.getElementById('heureActuelle').textContent = maintenant.toLocaleTimeString('fr-FR', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                });
            }

            setInterval(mettreAJourHeure, 1000);
            mettreAJourHeure();
        </script>
    </body>
</html>
