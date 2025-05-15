<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Compte</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-60">
        @include('header')

        <div class="flex place-self-center relative min-h-full flex-col justify-center px-6 py-6">
            <!-- div main compte -->

            <div class="flex flex-col border-3 border-y-gray-600 mb-8">
                <!-- liste des commandes actuelles -->
                <div class="bg-gray-900">
                    <p class="text-2xl place-self-center p-1">Vos commandes</p>
                </div>

                <div class="flex flex-col bg-gray-800 p-2">
                    <p>...</p>
                    <p>...</p>
                </div>
            </div>

            <div class="flex flex-col border-3 border-y-gray-600">
                <!-- Données de compte -->

                <div class="bg-gray-900">
                    <!-- Titre -->
                    <p class="text-2xl place-self-center p-1">Vos données</p>
                </div>

                <div class="flex flex-col bg-gray-800 p-2">
                    <!-- Données -->
                    <div class="flex flex-row">
                        <!-- Nom -->
                        <p class="font-bold pr-3">Nom :</p>
                        <p>{{ $donneesUtilisateur->nom }}</p>
                    </div>

                    <div class="flex flex-row">
                        <!-- Prenom -->
                        <p class="font-bold pr-3">Prenom :</p>
                        <p>{{ $donneesUtilisateur->prenom }}</p>
                    </div>

                    <div class="flex flex-row">
                        <!-- Adresse mail -->
                        <p class="font-bold pr-3">Adresse mail :</p>
                        <p>{{ $donneesUtilisateur->email }}</p>
                    </div>

                    <div class="flex flex-row">
                        <!-- Numéro compte (identifiant) -->
                        <p class="font-bold pr-3">Numéro de compte :</p>
                        <p>{{ $donneesUtilisateur->numeroCompte }}</p>
                    </div>

                    <div class="flex flex-row">
                        <!-- Nombre de commande passé -->
                        <p class="font-bold pr-3">Nombre de commandes passées :</p>
                        <p>...</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col justify-center min-h-40 min-w-80">
                <!-- Changer mot de passe ? & Déconnexion-->

                <div>
                    <!-- Changer mot de passe ? -->
                    <button class="bg-gray-800 px-5 py-2 hover:bg-gray-400 hover:cursor-pointer mb-1 min-w-full min-h-full">Changer votre mot de passe</button>
                </div>

                <div>
                    <!-- Déconnexion -->
                    <button type="submit" class="bg-red-950 px-5 py-2 hover:bg-red-900 hover:cursor-pointer mt-1 min-w-full min-h-full">
                        <a href="/deconnexion">Déconnexion</a>
                    </button>
                </div>
            </div>
        </div>

        @include('footer')
    </body>
</html>
