<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Compte</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include('header')

        <div class="flex min-h-full flex-lin justify-center px-6 py-6 lg:px-8"> <!-- div main compte -->

            <div> <!-- Données de compte -->
            </div>


            <div> <!-- liste des commandes actuelles -->
            </div>


            <div> <!-- Changer mot de passe ? & Déconnexion-->
                
                <div class="flex justify-center min-h-20 min-w-80"><!-- Changer mot de passe ? -->
                    <button class="bg-gray-700 px-5 py-2 hover:bg-gray-400 hover:cursor-pointer m-2 min-w-full min-h-full"> 
                        Changer votre mot de passe 
                    </button>
                </div>

                <div class="flex justify-center min-h-20 min-w-80"> <!-- Déconnexion -->
                    <button class="bg-gray-700 px-5 py-2 hover:bg-gray-400 hover:cursor-pointer m-2 min-w-full min-h-full">
                        Déconnexion
                    </button>
                </div>

            </div>

        </div>

        @include('footer')
    </body>
</html>
