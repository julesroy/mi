<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Panneau Admin</title>
    </head>
    <body class="bg-[#0a0a0a] text-white pt-10 md:pt-10">
        @include('header')

        <div class="flex flex-col items-center justify-center gap-10 mt-15 mb-35 px-4">
            <div class="text-center mt-1 pt-10">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">Bienvenue sur le panneau d'administration !</h1>
                <p class="text-base md:text-lg mb-4">Accède à tout ce dont tu as besoin depuis ici</p>
            </div>

            <div class="flex flex-col md:flex-row items-stretch justify-center w-full gap-6">
                <!-- Admin -->
                @can('verifier-acces-super-administrateur')
                    <div class="flex flex-col justify-between m-0 md:m-4 p-4 w-full md:w-72 h-full bg-[#151515] rounded-lg shadow">
                        <h2 class="text-center text-xl md:text-2xl font-bold mb-4 border-b-2 border-white">Admin</h2>
                        <div class="flex flex-col items-center gap-4">
                            <a href="/admin/tresorerie" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Trésorerie</p>
                            </a>
                            <a href="/admin/gestion-comptes" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Gestion des comptes</p>
                            </a>
                            <a href="/admin/parametres" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Paramètres</p>
                            </a>
                        </div>
                    </div>
                @endcan

                @can('verifier-acces-administrateur')
                    <!-- Resp -->
                    <div class="flex flex-col justify-between m-0 md:m-4 p-4 w-full md:w-72 h-full bg-[#151515] rounded-lg shadow">
                        <h2 class="text-center text-xl md:text-2xl font-bold mb-4 border-b-2 border-white">Respo</h2>
                        <div class="flex flex-col items-center gap-4">
                            <a href="/admin/inventaire" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Inventaire</p>
                            </a>
                            <a href="/admin/gestion-stocks" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Gestion des stocks</p>
                            </a>
                            <a href="/admin/gestion-carte" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Gestion de la carte</p>
                            </a>
                            <a href="/admin/gestion-actus" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Gestion des actus</p>
                            </a>
                            <a href="/admin/salle-securite" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Salle et Sécurité</p>
                            </a>
                        </div>
                    </div>
                @endcan

                @can('verifier-acces-serveur')
                    <!-- Serveurs -->
                    <div class="flex flex-col justify-between m-0 md:m-4 p-4 w-full md:w-72 h-full bg-[#151515] rounded-lg shadow">
                        <h2 class="text-center text-xl md:text-2xl font-bold mb-4 border-b-2 border-white">Serveurs</h2>
                        <div class="flex flex-col items-center gap-4">
                            <a href="/admin/affichage-cuisine" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Affichage pour la cuisine</p>
                            </a>
                            <a href="/admin/planning" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Planning</p>
                            </a>
                            <a href="/prise-commande" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Prise de commande</p>
                            </a>
                            <a href="/admin/commandes" class="text-center text-base md:text-lg font-bold hover:underline">
                                <p>Commandes en cours</p>
                            </a>
                        </div>
                    </div>
                @endcan
            </div>

            <a href="/" class="mt-4 text-blue-500 hover:underline">Retour à l'accueil</a>
        </div>

        @include('footer')
    </body>
</html>
