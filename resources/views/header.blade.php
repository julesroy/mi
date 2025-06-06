<header class="fixed top-0 left-0 w-full bg-primaire text-white text-3xl py-0 z-50 h-24 xl:h-32">
    <div class="flex items-center justify-between xl:justify-around h-full">
        <!-- Pour les grands écrans -->
        <span class="hidden xl:flex justify-between w-5/12 items-center h-full">
            <span class="text-5xl pl-4 xl:pl-0 py-6 xl:py-0 font-bold">
                <a href="/">{{ $donneesParametres->titreHeader }}</a>
            </span>

            <div class="h-full items-center hover:bg-secondaire transition hidden xl:flex">
                <a href="/contact" class="w-full text-center px-8 h-full flex items-center">Contact</a>
            </div>
            <div class="h-full items-center hover:bg-secondaire transition hidden xl:flex">
                <a href="/actus" class="w-full text-center px-8 h-full flex items-center">Actus</a>
            </div>
        </span>
        <img src="{{ asset("images/logo.png") }}" alt="Logo {{ $donneesParametres->titreHeader }}" class="hidden xl:block w-48 h-auto relative -mb-20" />
        <span class="hidden xl:flex justify-between w-5/12 items-center h-full">
            <div class="h-full items-center hover:bg-secondaire transition hidden xl:flex">
                <a href="/commander" class="w-full text-center px-8 h-full flex items-center">Commander</a>
            </div>
            <div class="h-full items-center hover:bg-secondaire transition hidden xl:flex">
                <a href="/carte" class="w-full text-center px-8 h-full flex items-center">Carte</a>
            </div>
            @auth
                <div class="h-full items-center hover:bg-secondaire transition hidden xl:flex">
                    <span class="w-full text-center px-8 h-full flex items-center">Solde : {{ $donneesUtilisateur->solde }}€</span>
                </div>
            @endauth

            <!-- dropdown (sous-menu) pour le compte -->
            <div class="relative h-full items-center hidden xl:flex">
                <button id="compte-btn" class="w-full text-center px-8 h-full flex items-center justify-center hover:bg-secondaire transition">
                    @auth
                        {{ $donneesUtilisateur->prenom }}
                    @endauth

                    @guest
                        Compte
                    @endguest

                    <svg id="compte-arrow" class="ml-2 w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="compte-dropdown" class="overflow-hidden max-h-0 text-2xl text-center xl:text-left transition-all duration-500 bg-secondaire w-full absolute left-0 top-full z-10">
                    @auth
                        @can("verifier-acces-serveur")
                            <a href="/admin/panneau-admin" class="block px-4 py-2 hover:bg-secondaire">Admin</a>
                        @endcan

                        <a href="/compte" class="block px-4 py-2 hover:bg-secondaire">Profil</a>
                        <a href="/deconnexion" class="block px-4 py-2 hover:bg-secondaire">Déconnexion</a>
                    @endauth

                    @guest
                        <a href="/connexion" class="block px-4 py-2 hover:bg-secondaire">Connexion</a>
                        <a href="/inscription" class="block px-4 py-2 hover:bg-secondaire">Inscription</a>
                    @endguest
                </div>
            </div>
        </span>

        <!-- Pour les petits écrans -->
        <span id="cote-gauche" class="flex items-center justify-between xl:hidden w-full pl-4">
            <!-- menu déroulant pour petits écrans -->
            <nav id="menu" class="overflow-hidden h-0 transition-all text-2xl duration-500 ease-in-out flex flex-col items-center bg-primaire absolute w-full left-0 top-full xl:static xl:flex-row xl:items-stretch xl:justify-start xl:h-auto xl:overflow-visible">
                <a href="/actus" class="w-full px-8 py-6 hover:bg-secondaire">Actus</a>
                <a href="/contact" class="w-full px-8 py-6 hover:bg-secondaire">Contact</a>
                <a href="/carte" class="w-full px-8 py-6 hover:bg-secondaire">Carte</a>
                <a href="/commander" class="w-full px-8 py-6 hover:bg-secondaire">Commander</a>
                <!-- dropdown (sous-menu) pour le compte -->
                <div class="relative w-full">
                    <button id="compte-btn" class="w-full text-center px-8 py-6 hover:bg-secondaire flex items-center">
                        @auth
                            {{ $donneesUtilisateur->prenom }}
                        @endauth

                        @guest
                            Compte
                        @endguest

                        <svg id="compte-arrow" class="ml-2 w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="compte-dropdown" class="overflow-hidden max-h-0 text-xl transition-all duration-500 bg-secondaire w-full absolute left-0 z-10">
                        @auth
                            @can("verifier-acces-serveur")
                                <a href="/admin/panneau-admin" class="block px-4 py-2 hover:bg-secondaire">Admin</a>
                            @endcan

                            <a href="/compte" class="block px-4 py-2 hover:bg-secondaire">Profil</a>
                            <a href="/deconnexion" class="block px-4 py-2 hover:bg-secondaire">Déconnexion</a>
                        @endauth

                        @guest
                            <a href="/connexion" class="block px-4 py-2 hover:bg-secondaire">Connexion</a>
                            <a href="/inscription" class="block px-4 py-2 hover:bg-secondaire">Inscription</a>
                        @endguest
                    </div>
                </div>
            </nav>
            <!-- bouton du menu déroulant -->
            <button id="burger" class="xl:hidden flex flex-col justify-center w-9 h-9 relative group">
                <span class="block absolute h-0.5 w-7 bg-white transition-all duration-300 ease-in-out top-2 left-1 group-[.open]:rotate-45 group-[.open]:top-4"></span>
                <span class="block absolute h-0.5 w-7 bg-white transition-all duration-300 ease-in-out top-4 left-1 group-[.open]:opacity-0"></span>
                <span class="block absolute h-0.5 w-7 bg-white transition-all duration-300 ease-in-out top-6 left-1 group-[.open]:-rotate-45 group-[.open]:top-4"></span>
            </button>

            @auth
                <span class="text-base pr-2">Solde : {{ $donneesUtilisateur->solde }}€</span>
            @endauth

            <span class="xl:hidden text-3xl xl:text-5xl pr-4 py-6 xl:py-0 font-bold">
                <a href="/">{{ $donneesParametres->titreHeader }}</a>
            </span>
        </span>
    </div>
</header>

<script>
    /**
     * Gestion du menu déroulant "hamburger" pour les petits écrans
     */
    const burger = document.getElementById('burger');
    const menu = document.getElementById('menu');
    let open = false;
    burger.addEventListener('click', function () {
        open = !open;
        burger.classList.toggle('open', open);

        if (open) {
            menu.classList.remove('h-0');
            menu.classList.add('h-screen');
        } else {
            menu.classList.add('h-0');
            menu.classList.remove('h-screen');
        }
    });

    /**
     * Gestion des dropdowns pour le compte (grands et petits écrans)
     */
    const compteBtns = document.querySelectorAll('#compte-btn'); // Sélectionne tous les boutons "Compte"
    const compteDropdowns = document.querySelectorAll('#compte-dropdown'); // Sélectionne tous les dropdowns "Compte"
    const compteArrows = document.querySelectorAll('#compte-arrow'); // Sélectionne toutes les flèches "Compte"
    let dropdownStates = Array.from(compteBtns).map(() => false); // État d'ouverture pour chaque dropdown

    compteBtns.forEach((compteBtn, index) => {
        compteBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownStates[index] = !dropdownStates[index];

            // Gère l'ouverture/fermeture du dropdown correspondant
            compteDropdowns[index].classList.toggle('max-h-0', !dropdownStates[index]);
            compteDropdowns[index].classList.toggle('max-h-40', dropdownStates[index]);
            compteArrows[index].classList.toggle('rotate-180', dropdownStates[index]);
        });
    });

    // Ferme tous les dropdowns si on clique ailleurs
    document.addEventListener('click', () => {
        dropdownStates.forEach((state, index) => {
            if (state) {
                dropdownStates[index] = false;
                compteDropdowns[index].classList.add('max-h-0');
                compteDropdowns[index].classList.remove('max-h-40');
                compteArrows[index].classList.remove('rotate-180');
            }
        });
    });
</script>
