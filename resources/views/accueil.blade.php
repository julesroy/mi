<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        @include("head")
        <title>Accueil</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-48">
        @include("header")
        <div class="flex-grow flex flex-col items-center justify-center text-center">
            @guest
                <h1 class="text-4xl font-bold mb-6">Bienvenue chez la Par'MI'Giano !</h1>
                <p class="text-lg text-gray-400 mb-10">Inscris-toi ou connecte-toi pour profiter de nos services.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-lg mx-auto items-center justify-items-center">
                    <!-- Inscription -->
                    <a href="/inscription" class="bg-blue-500 text-white py-4 px-6 rounded-lg shadow-md hover:bg-blue-600 transition transform hover:scale-105 flex flex-col items-center justify-center">
                        <h3 class="text-xl font-semibold">Inscription</h3>
                        <p class="text-sm text-gray-200 mt-2">Pas de compte ? Alors inscris-toi !</p>
                    </a>

                    <!-- Connexion -->
                    <a href="/connexion" class="bg-green-500 text-white py-4 px-6 rounded-lg shadow-md hover:bg-green-600 transition transform hover:scale-105 flex flex-col items-center justify-center">
                        <h3 class="text-xl font-semibold">Connexion</h3>
                        <p class="text-sm text-gray-200 mt-2">Tu as déjà un compte ? Parfait !</p>
                    </a>
                </div>
            @endguest

            @auth
                <h1 class="text-4xl font-bold mb-6">Bonjour {{ $donneesUtilisateur->prenom }} !</h1>
                <p class="text-lg text-gray-400 mb-10">Re-bienvenue chez la Par'MI'Giano !</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-4xl mx-auto items-center justify-items-center">
                    <!-- Compte -->
                    <a href="/compte" class="bg-purple-500 text-white py-4 px-6 rounded-lg shadow-md hover:bg-purple-600 transition transform hover:scale-105 flex flex-col items-center justify-center">
                        <h3 class="text-xl font-semibold">Mon Compte</h3>
                        <p class="text-sm text-gray-200 mt-2">Tes informations personnelles</p>
                    </a>

                    <!-- Commander -->
                    <a href="/commander" class="bg-yellow-500 text-white py-4 px-6 rounded-lg shadow-md hover:bg-yellow-600 transition transform hover:scale-105 flex flex-col items-center justify-center">
                        <h3 class="text-xl font-semibold">Passer une Commande</h3>
                        <p class="text-sm text-gray-200 mt-2">Commande tes plats préférés</p>
                    </a>

                    <!-- Panneau admin -->
                    @can("verifier-acces-serveur")
                        <a href="/admin/panneau-admin" class="bg-red-500 text-white py-4 px-6 rounded-lg shadow-md hover:bg-red-600 transition transform hover:scale-105 flex flex-col items-center justify-center">
                            <h3 class="text-xl font-semibold">Panneau administratif</h3>
                            <p class="text-sm text-gray-200 mt-2">Accède au panneau administratif</p>
                        </a>
                    @endcan
                </div>
            @endauth
        </div>
        @include("footer")
    </body>

    <script>
        //Tri des comptes dans le rouge
        const comptes = document.querySelectorAll('.compte');
    </script>
</html>
