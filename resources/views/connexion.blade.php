<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Connexion</title>
        <style>
            .dialog-container {
                background-color: rgba(0, 0, 0, 0.5);
            }
            .dialog-panel {
                background-color: #1a1a1a;
                border: 1px solid #333;
            }
            .input-field {
                background-color: #FFFFFF;
                border: 1px solid #000000;
            }
        </style>
    </head>

    <body class="bg-[#FFFFFF] text-black pt-18 md:pt-40">
        @include('header')

        <div class="flex min-h-full flex-col justify-center px-6 py-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class="mt-10 text-center text-5xl font-medium tracking-tight">Bienvenue !</h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm pb-8 border-2 border-black rounded-[13px] p-8">
                <h1 class="mt-2 text-center text-xl font-semibold text-black">Connexion</h3>
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-900/50 text-red-300 rounded border border-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="space-y-6" action="/connexion" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-xl text-black font-medium">Email</label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" autocomplete="email" required 
                                   class="input-field w-full rounded-[13px] px-3 py-2 border-2 text-black placeholder-gray-500 focus:ring-secondaire focus:ring-2" />
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="mdp" class="block text-xl font-medium">Mot de passe</label>
                            <div class="text-sm">
                                <button type="button" onclick="showDialog('forgotPasswordDialog')" 
                                        class="font-medium text-base underline decoration-secondaire text-black">
                                    Mot de passe oublié ?
                                </button>
                            </div>
                        </div>
                        <div class="mt-1">
                            <input type="password" name="mdp" id="mdp" required 
                                   class="input-field w-full rounded-[13px] border-2 px-3 py-2 text-black placeholder-gray-500 focus:ring-secondaire focus:ring-2" />
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-[100px] shadow-sm text-2xl font-medium text-black bg-secondaire focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondaire">
                            Connexion
                        </button>
                    </div>
                </form>

            </div>
        </div>
        <div class="mt-1 text-center text-base pb-39 pt-0.5">
            <span class="text-black">Pas de compte ?</span>
            <a href="/inscription" class="ml-1 font-medium  hover:text-secondaire text-black underline">Inscription</a>
        </div>

        <!-- Dialog Mot de passe oublié -->
        <dialog id="forgotPasswordDialog" class=" top-80 left-176 w-130 flex items-center border-5 border-black rounded-[13px] justify-center z-50 invisible transition-opacity duration-300 bg-opacity-50">
            <div class="bg-white w-full max-w-md p-6 relative mx- my-auto">
                <!-- Croix de fermeture -->
                <button onclick="hideDialog('forgotPasswordDialog')" 
                        class="absolute top-2 right-0 text-gray-500 hover:text-black focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-medium text-black">Mot de passe oublié</h3>
                    </div>
                    
                    <div>
                        <label class="block text-lg font-medium text-black mb-2">Email</label>
                        <input type="email" id="resetEmail" 
                            class="w-full rounded-[100px] border border-black px-4 py-2 text-gray-900" />
                    </div>
                    
                    <button onclick="submitResetRequest()" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-[100px] shadow-sm text-lg font-medium text-white bg-secondaire hover:bg-secondaire-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondaire">
                        Nouveau mot de passe
                    </button>
                </div>
            </div>
        </dialog>

        <!-- Dialog Confirmation envoi email -->
        <dialog id="resetConfirmationDialog" class="top-80 left-176 w-130 flex items-center border-5 border-black rounded-[13px] justify-center z-50 invisible transition-opacity duration-300 bg-opacity-55">
            <div class="bg-white w-full max-w-md p-6 relative mx- my-auto">
                <button onclick="hideDialog('forgotPasswordDialog')" 
                        class="absolute top-2 right-0 text-gray-500 hover:text-black focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="text-center">
                    <h3 class="text-lg font-bold mb-2">Mot de passe oublié</h3>
                    <br>
                    <p class="mb-4">Nouveau mot de passe envoyé à <span id="sentEmail" class="font-medium">nom.prenom@student.junia.com</span></p>
                </div>
            </div>
        </dialog>

        @include('footer')

        <script>
            // Gestion des dialogs
            function showDialog(id) {
                const dialog = document.getElementById(id);
                dialog.classList.remove('invisible', 'opacity-0');
                dialog.showModal();
            }
            
            function hideDialog(id) {
                const dialog = document.getElementById(id);
                dialog.classList.add('opacity-0');
                setTimeout(() => {
                    dialog.classList.add('invisible');
                    dialog.close();
                }, 300);
            }

            // Simulation d'envoi de réinitialisation
            function submitResetRequest() {
                const email = document.getElementById('resetEmail').value;
                if (email) {
                    document.getElementById('sentEmail').textContent = email;
                    hideDialog('forgotPasswordDialog');
                    showDialog('resetConfirmationDialog');
                }
            }

            // Fermer les dialogs en cliquant à l'extérieur
            document.querySelectorAll('dialog').forEach(dialog => {
                dialog.addEventListener('click', (e) => {
                    if (e.target === dialog) {
                        hideDialog(dialog.id);
                    }
                });
            });
        </script>
    </body>
</html>