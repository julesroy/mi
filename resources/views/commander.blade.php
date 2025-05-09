<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Commander</title>
        <link rel="stylesheet" href="{{ asset('css/dialog.css') }}" />
    </head>

    <body class="bg-[#0a0a0a] text-white pt-20 md:pt-32">
        @include('header')

        <div class="flex flex-col items-center justify-center gap-10 mt-15 px-4">
            <!-- Conteneur principal -->
            <div class="w-full max-w-6xl">
                <!-- Conteneur des blocs + dialog -->
                <div class="hidden flex-col items-stretch justify-center md:gap-4 pb-6 transition-all duration-300 bg-white text-black rounded-2xl" id="ecran-1">
                    <div class="pt-2 text-xl text-center">Fais ton choix</div>

                    <div class="h-148 md:h-132 flex flex-col md:flex-row justify-around items-center" id="elements-commande">
                        <div class="text-center border-2 h-4/10 w-10/12 md:h-128 md:w-1/3 rounded-xl flex flex-col items-center justify-center hover:bg-black hover:text-white transition duration-300 ease-in-out" id="bouton-menus">
                            <span>img menu</span>
                            <p>Menus</p>
                        </div>

                        <div class="text-center border-2 h-4/10 w-10/12 md:h-128 md:w-1/3 rounded-xl flex flex-col items-center justify-center hover:bg-black hover:text-white transition duration-300 ease-in-out">
                            <span>img plat</span>
                            <p>Plats individuels</p>
                        </div>
                    </div>

                    <div class="text-center border-2 w-10/12 md:w-1/3 rounded-lg bg-black text-white flex justify-center mx-auto py-2">Ton panier : 0.0€</div>
                </div>

                <div class="hidden flex-col items-stretch justify-center md:gap-4 pb-6 transition-all duration-300 bg-white text-black rounded-2xl" id="ecran-2">
                    <div class="pt-2 text-xl text-center">Menus</div>

                    <div class="h-148 md:h-132 flex flex-col md:flex-row justify-around items-center" id="elements-commande">
                        <div class="text-center border-2 h-3/10 w-10/12 md:h-128 md:w-1/4 rounded-xl flex flex-col items-center justify-center hover:bg-black hover:text-white transition duration-300 ease-in-out" id="bouton-menu-1">
                            <span>img menu 1</span>
                            <p>Menu 1</p>
                        </div>

                        <div class="text-center border-2 h-3/10 w-10/12 md:h-128 md:w-1/4 rounded-xl flex flex-col items-center justify-center hover:bg-black hover:text-white transition duration-300 ease-in-out">
                            <span>img menu 2</span>
                            <p>Menu 2</p>
                        </div>

                        <div class="text-center border-2 h-3/10 w-10/12 md:h-128 md:w-1/4 rounded-xl flex flex-col items-center justify-center hover:bg-black hover:text-white transition duration-300 ease-in-out">
                            <span>img menu 3</span>
                            <p>Menu 3</p>
                        </div>
                    </div>

                    <div class="text-center border-2 w-10/12 md:w-1/3 rounded-lg bg-black text-white flex justify-center mx-auto py-2">Ton panier : 0.0€</div>
                </div>

                <div class="hidden flex-col items-stretch justify-center md:gap-4 pb-6 transition-all duration-300 bg-white text-black rounded-2xl" id="ecran-menu-1">
                    <div class="pt-2 text-xl text-center">Choisis ton plat</div>

                    <div class="h-148 md:h-132 flex flex-col md:flex-row justify-around items-center" id="elements-commande">
                        <div class="text-center border-2 h-3/10 w-10/12 md:h-128 md:w-1/4 rounded-xl flex flex-col items-center justify-center hover:bg-black hover:text-white transition duration-300 ease-in-out">
                            <span>img menu 1</span>
                            <p>Menu 1</p>
                        </div>

                        <div class="text-center border-2 h-3/10 w-10/12 md:h-128 md:w-1/4 rounded-xl flex flex-col items-center justify-center hover:bg-black hover:text-white transition duration-300 ease-in-out">
                            <span>img menu 2</span>
                            <p>Menu 2</p>
                        </div>

                        <div class="text-center border-2 h-3/10 w-10/12 md:h-128 md:w-1/4 rounded-xl flex flex-col items-center justify-center hover:bg-black hover:text-white transition duration-300 ease-in-out">
                            <span>img menu 3</span>
                            <p>Menu 3</p>
                        </div>
                    </div>

                    <div class="text-center border-2 w-10/12 md:w-1/3 rounded-lg bg-black text-white flex justify-center mx-auto py-2">Ton panier : 0.0€</div>
                </div>

                <div class="flex flex-col items-stretch justify-center md:gap-4 pb-6 transition-all duration-300 bg-white text-black rounded-2xl" id="ecran-snacks">
                    <div class="pt-2 text-xl text-center">Choisis tes snacks/boissons</div>

                    <div class="flex justify-around">
                        <span id="onglet-snacks" class="border-b-2 border-black font-semibold">Snacks</span>
                        <span id="onglet-boissons">Boissons</span>
                    </div>

                    <div class="h-148 md:h-128 grid grid-cols-5 md:grid-cols-10 justify-items-center" id="elements-snacks">
                        <div class="border w-10/12 h-24 rounded-xl flex flex-col items-center justify-center hover:bg-black hover:text-white transition duration-300 ease-in-out" data-selected="false" onclick="toggleSelection(this)">
                            <span>img snack</span>
                            <p>Snack</p>
                        </div>
                    </div>

                    <div class="h-148 md:h-128 hidden grid-cols-5 md:grid-cols-10 justify-items-center" id="elements-boissons">
                        <div class="border w-10/12 h-24 rounded-xl flex flex-col items-center justify-center hover:bg-black hover:text-white transition duration-300 ease-in-out" data-selected="false" onclick="toggleSelection(this)">
                            <span>img boisson</span>
                            <p>Boisson</p>
                        </div>
                    </div>

                    <div class="text-center border-2 w-10/12 md:w-1/3 rounded-lg bg-black text-white flex justify-center mx-auto py-2">Ton panier : 0.0€</div>
                </div>
            </div>
        </div>

        @include('footer')

        <script src="{{ asset('js/dialog.js') }}"></script>

        <script>
            // je dois le placer dans un fichier séparé quand le developpement sera terminé

            document.addEventListener('DOMContentLoaded', function () {
                const ecran1 = document.getElementById('ecran-1');
                const ecran2 = document.getElementById('ecran-2');

                const elements1 = ecran1.querySelector('#elements-commande');
                const elements2 = ecran2.querySelector('#elements-commande');
                const elementsMenu1 = document.getElementById('ecran-menu-1');
                const boutonMenus = document.getElementById('bouton-menus');
                const boutonMenu1 = document.getElementById('bouton-menu-1');

                if (boutonMenus && elements1 && elements2) {
                    boutonMenus.addEventListener('click', () => {
                        elements1.classList.add('transition-opacity', 'duration-500', 'opacity-0');

                        setTimeout(() => {
                            ecran1.classList.add('hidden');
                            ecran2.classList.remove('hidden');

                            elements2.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                            void elements2.offsetWidth; // reflow
                            elements2.classList.remove('opacity-0');
                        }, 500);
                    });

                    boutonMenu1.addEventListener('click', () => {
                        elements2.classList.add('transition-opacity', 'duration-500', 'opacity-0');

                        setTimeout(() => {
                            ecran2.classList.add('hidden');
                            elementsMenu1.classList.remove('hidden');

                            elementsMenu1.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                            void elementsMenu1.offsetWidth; // reflow
                            elementsMenu1.classList.remove('opacity-0');
                        }, 500);
                    });
                }
            });

            /**
             * Pour changer d'onglet snacks/boissons et la sélection des éléments
             */
            function toggleSelection(el) {
                const selected = el.getAttribute('data-selected') === 'true';
                el.setAttribute('data-selected', !selected);
                el.classList.toggle('bg-black', !selected);
                el.classList.toggle('text-white', !selected);
            }

            const ongletSnacks = document.getElementById('onglet-snacks');
            const ongletBoissons = document.getElementById('onglet-boissons');
            const sectionSnacks = document.getElementById('elements-snacks');
            const sectionBoissons = document.getElementById('elements-boissons');

            ongletSnacks.addEventListener('click', () => {
                sectionSnacks.classList.remove('hidden');
                sectionBoissons.classList.add('hidden');
                ongletSnacks.classList.add('border-b-2', 'border-black', 'font-semibold');
                ongletBoissons.classList.remove('border-b-2', 'border-black', 'font-semibold');
            });

            ongletBoissons.addEventListener('click', () => {
                sectionBoissons.classList.remove('hidden');
                sectionSnacks.classList.add('hidden');
                ongletBoissons.classList.add('border-b-2', 'border-black', 'font-semibold');
                ongletSnacks.classList.remove('border-b-2', 'border-black', 'font-semibold');
            });
        </script>
    </body>
</html>
