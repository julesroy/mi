<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Panneau Admin</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-10 md:pt-10 pb-10">
        @include('header')

        <div class="flex flex-col items-center justify-center gap-10 mt-15 mb-35">
            <div class="text-center mt-1 pt-10">
                <h1 class="text-4xl font-bold mb-4">Bonjour User</h1>
                <p class="text-lg mb-4">Bienvenue sur le panneau d'administration !</p>
            </div>
            
            <div class="flex flex-row items-start justify-center">
                <!-- Admin -->
                <div class="flex flex-col justify-between m-4 p-4 w-48 h-full">
                    <h2 class="text-center text-2xl font-bold mb-4 border-b-2 border-white">Admin</h2>
                    <div class="flex flex-col items-center gap-4 ">
                        <a href="/tresorerie" class="text-center text-lg font-bold hover:underline">
                            <p>Trésorerie</p>
                        </a>
                        <a href="/gestion-comptes" class="text-center text-lg font-bold hover:underline">
                            <p>Gestion des comptes</p>
                        </a>
                        <a href="/parametres" class="text-center text-lg font-bold hover:underline">
                            <p>Paramètres</p>
                        </a>
                    </div>
                </div>

                <!-- Resp -->
                <div class="flex flex-col justify-between m-4 p-4 w-48 h-full">
                    <h2 class="text-center text-2xl font-bold mb-4 border-b-2 border-white">Respo</h2>
                    <div class="flex flex-col items-center gap-4">
                        <a href="/inventaire" class="text-center text-lg font-bold hover:underline">
                            <p>Inventaire</p>
                        </a>
                        <a href="/gestion-stocks" class="text-center text-lg font-bold hover:underline">
                            <p>Gestion des stocks</p>
                        </a>
                        <a href="/gestion-carte" class="text-center text-lg font-bold hover:underline">
                            <p>Gestion de la carte</p>
                        </a>
                        <a href="/gestion-actus" class="text-center text-lg font-bold hover:underline">
                            <p>Gestion des actus</p>
                        </a>
                        <a href="/salle-securite" class="text-center text-lg font-bold hover:underline">
                            <p>Salle et Sécurité</p>
                        </a>
                    </div>
                </div>

                <!-- Serveurs -->
                <div class="flex flex-col justify-between m-4 p-4 w-48 h-full">
                    <h2 class="text-center text-2xl font-bold mb-4 border-b-2 border-white">Serveurs</h2>
                    <div class="flex flex-col items-center gap-4">
                        <a href="/affichage-cuisine" class="text-center text-lg font-bold hover:underline">
                            <p>Affichage pour la cuisine</p>
                        </a>
                        <a href="/planning" class="text-center text-lg font-bold hover:underline">
                            <p>Planning</p>
                        </a>
                        <a href="/prise-commande" class="text-center text-lg font-bold hover:underline">
                            <p>Prise de commande</p>
                        </a>
                    </div>
                </div>
            </div>

            <a href="/" class="mt-4 text-blue-500 hover:underline">Retour à l'accueil</a>
        </div>
        
        @include('footer')
    </body>
</html>
