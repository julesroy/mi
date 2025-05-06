<header class="fixed top-0 left-0 w-full bg-white z-50">
    <div class="flex items-center justify-between px-4 py-8 md:py-6">
        <span class="text-2xl font-bold text-black"><a href="/">Par'MI'Giano</a></span>
        <span id="cote-droit" class="flex items-center justify-between">
            <span class="pr-9 md:pr-0 text-lg text-black">0.0€</span>
            <!-- bouton du menu déroulant -->
            <button id="burger" class="md:hidden flex flex-col justify-center w-9 h-9 relative group">
                <span class="block absolute h-0.5 w-7 bg-black transition-all duration-300 ease-in-out top-2 left-1 group-[.open]:rotate-45 group-[.open]:top-4"></span>
                <span class="block absolute h-0.5 w-7 bg-black transition-all duration-300 ease-in-out top-4 left-1 group-[.open]:opacity-0"></span>
                <span class="block absolute h-0.5 w-7 bg-black transition-all duration-300 ease-in-out top-6 left-1 group-[.open]:-rotate-45 group-[.open]:top-4"></span>
            </button>
        </span>
    </div>
    <!-- menu déroulant que l'on fait apparaître pour les petits écrans (genre téléphone) -->
    <nav id="menu" class="overflow-hidden h-0 transition-all duration-500 ease-in-out flex flex-col items-center bg-white absolute w-full left-0 top-full md:static md:flex-row md:items-stretch md:justify-start md:h-auto md:overflow-visible">
        <a href="#" class="w-full text-center px-4 py-4 hover:bg-gray-100 text-black">Carte</a>
        <a href="#" class="w-full text-center px-4 py-4 hover:bg-gray-100 text-black">Commander</a>
        <a href="#" class="w-full text-center px-4 py-4 hover:bg-gray-100 text-black">Contact</a>
        <!-- dropdown (sous-menu) pour le compte -->
        <div class="relative w-full">
            <button id="compte-btn" class="w-full text-center px-4 py-4 hover:bg-gray-100 text-black flex items-center justify-center">
                Compte
                <svg id="compte-arrow" class="ml-2 w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="compte-dropdown" class="overflow-hidden max-h-0 transition-all duration-500 bg-white w-full absolute left-0 z-10">
                <a href="/compte" class="block px-4 py-2 hover:bg-gray-100 text-black">Profil</a>
                <a href="/deconnexion" class="block px-4 py-2 hover:bg-gray-100 text-black">Déconnexion</a>
            </div>
        </div>
    </nav>
</header>

<script>
    /**
     * ici on gère l'ouverture et la fermeture du menu déroulant avec le bouton "hamburger" et l'ouverture du menu déroulant sur
     * toute la hauteur de l'écran sur les petits écrans (genre téléphone)
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
     * ici on gère l'ouverture et la fermeture du dropdown pour le compte
     */
    const compteBtn = document.getElementById('compte-btn');
    const compteDropdown = document.getElementById('compte-dropdown');
    const compteArrow = document.getElementById('compte-arrow');
    let dropdownOpen = false;

    compteBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownOpen = !dropdownOpen;
        compteDropdown.classList.toggle('max-h-0', !dropdownOpen);
        compteDropdown.classList.toggle('max-h-40', dropdownOpen);
        compteArrow.classList.toggle('rotate-180', dropdownOpen);
    });

    // on ferme le dropdown si on clique ailleurs
    document.addEventListener('click', () => {
        if (dropdownOpen) {
            dropdownOpen = false;
            compteDropdown.classList.add('max-h-0');
            compteDropdown.classList.remove('max-h-40');
            compteArrow.classList.remove('rotate-180');
        }
    });
</script>
