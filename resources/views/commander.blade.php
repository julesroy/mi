<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('head')
    <title>Commander</title>
    <link rel="stylesheet" href="{{ asset('css/dialog.css') }}">
</head>

<body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
    @include('header')

    <div class="flex flex-col items-center justify-center gap-10 mt-15 mb-35 px-4">
        <div class="text-center mt-1 pt-10">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Passe ta commande !</h1>
        </div>
        
        <!-- Conteneur principal -->
        <div class="w-full max-w-6xl">
            <!-- Conteneur des blocs + dialog -->
            <div class="flex flex-col md:flex-row items-stretch justify-center gap-4 md:gap-4 transition-all duration-300" id="main-container">
                <!-- Bloc Carte -->
                <div class="flex flex-col justify-between p-4 w-full md:w-52 bg-[#151515] rounded-lg shadow transition-all duration-300" id="carte-block">
                    <h2 class="text-center text-xl md:text-2xl font-bold mb-4 border-b-2 border-white">Carte</h2>
                    <div class="flex flex-col items-center gap-10">
                        <button class="openDialogBtn text-center text-base md:text-lg font-bold hover:underline cursor-pointer" data-target="dialog-menu">
                            <p>Menus</p>
                            <img src="{{ asset('images/menus.png') }}" alt="Menus" class="w-8 h-8 mt-2">
                        </button>
                        <button class="openDialogBtn text-center text-base md:text-lg font-bold hover:underline cursor-pointer" data-target="dialog-plat">
                            <p>Plats</p>
                            <img src="{{ asset('images/plat.png') }}" alt="Plats" class="w-8 h-8 mt-2">
                        </button>
                        <button class="openDialogBtn text-center text-base md:text-lg font-bold hover:underline cursor-pointer" data-target="dialog-boisson">
                            <p>Boissons</p>
                            <img src="{{ asset('images/boisson.png') }}" alt="Boissons" class="w-8 h-8 mt-2">
                        </button>
                        <button class="openDialogBtn text-center text-base md:text-lg font-bold hover:underline cursor-pointer" data-target="dialog-snack">
                            <p>Snack</p>
                            <img src="{{ asset('images/snack.png') }}" alt="Snack" class="w-8 h-8 mt-2">
                        </button>
                    </div>
                </div>

                <!-- Bloc Panier -->
                <div class="flex flex-col justify-between p-4 w-full md:w-72 bg-[#151515] rounded-lg shadow transition-all duration-300" id="panier-block">
                    <h2 class="text-center text-xl md:text-2xl font-bold mb-4 border-b-2 border-white">Panier</h2>
                    <div class="flex flex-col items-center gap-5">
                        <p><span class="font-bold">Article 1</span></p>
                        <p><span class="font-bold">Article 2</span></p>
                        <p><span class="font-bold">Article 3</span></p>
                    </div>
                    <p class="text-center text-base md:text-lg font-bold mt-4">
                        <span class="font-bold">Total :</span> 0,00 €
                    </p>
                    <div class="flex justify-center gap-4 mt-4">
                        <button class="text-center text-base md:text-lg font-bold hover:underline cursor-pointer bg-[#229747] rounded-lg p-2">
                            <p>Valider</p>
                        </button>
                        <button class="text-center text-base md:text-lg font-bold hover:underline cursor-pointer bg-[#c32d2c] rounded-lg p-2">
                            <p>Annuler</p>
                        </button>
                    </div>
                </div>

                <!-- Dialog central (invisible par défaut) -->
                <div class="fixed inset-0 flex items-center justify-center z-50 pointer-events-none">
                    <!-- Dialog Menu -->
                    <dialog id="dialog-menu" class="dialog-center bg-[#151515] rounded-lg shadow-lg p-3 w-1/2 md:w-1/2 max-h-[80vh] pointer-events-auto">
                        <button class="closeDialogBtn text-base md:text-lg font-bold hover:underline cursor-pointer text-[#c32d2c] rounded-lg p-1">X</button>
                        <h2 class="text-center text-xl md:text-2xl font-bold mb-6 border-b-2 text-gray-300 border-white pb-2">Nos Menus</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 overflow-y-auto max-h-[60vh] px-10">
                            <!-- Menu 1 -->
                            <div class="bg-[#1e1e1e] rounded-lg p-3 flex flex-col h-full">
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-gray-300 mb-2 text-center">Petite Faim</h3>
                                    <p class="text-sm text-gray-300 text-center mb-3">1 plat au choix (sandwich / panini / 2 hot-dog / 2 croques) </p>
                                    <p class="text-sm text-gray-300 text-center mb-3">+</p>
                                    <p class="text-sm text-gray-300 text-center mb-3">1 hot dog / 1 croque</p>
                                    <p class="text-sm text-gray-300 text-center mb-3">+</p>
                                    <p class="text-sm text-gray-300 text-center mb-3">1 snack / boisson</p>
                                </div>
                                <div class="mt-auto pt-4">
                                    <p class="font-bold text-gray-300 text-lg mb-3 text-center">3,30 €</p>
                                    <button class="add-to-cart bg-[#229747] rounded-lg px-2 py-2 text-sm font-bold w-full hover:underline">Sélectionner</button>
                                </div>
                            </div>
                            
                            <!-- Menu 2 -->
                            <div class="bg-[#1e1e1e] rounded-lg p-3 flex flex-col h-full">
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-gray-300 mb-2 text-center">Moyenne Faim</h3>
                                    <p class="text-sm text-gray-300 text-center mb-3">1 plat au choix (sandwich / panini / 2 hot-dog / 2 croques) </p>
                                    <p class="text-sm text-gray-300 text-center mb-3">+</p>
                                    <p class="text-sm text-gray-300 text-center mb-3">2 snack / boisson</p>
                                </div>
                                <div class="mt-auto pt-4">
                                    <p class="font-bold text-gray-300 text-lg mb-3 text-center">3,80 €</p>
                                    <button class="add-to-cart bg-[#229747] rounded-lg px-2 py-2 text-sm font-bold w-full hover:underline">Sélectionner</button>
                                </div>
                            </div>
                            
                            <!-- Menu 3 -->
                            <div class="bg-[#1e1e1e] rounded-lg p-3 flex flex-col h-full">
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-gray-300 mb-2 text-center">Gros Sac</h3>
                                    <p class="text-sm text-gray-300 text-center mb-3">2 plat au choix (sandwich / panini / 2 hot-dog / 2 croques) </p>
                                </div>
                                <div class="mt-auto pt-4">
                                    <p class="font-bold text-gray-300 text-lg mb-3 text-center">4,10 €</p>
                                    <button class="add-to-cart bg-[#229747] rounded-lg px-2 py-2 text-sm font-bold w-full hover:underline">Sélectionner</button>
                                </div>
                            </div>
                        </div>
                    </dialog>
                
                    <!-- Dialog Plat -->
                    <dialog id="dialog-plat" class="dialog-center bg-[#151515] rounded-lg shadow-lg p-6 w-11/12 md:w-4/5 max-h-[80vh] pointer-events-auto">
                        <button class="closeDialogBtn text-base md:text-lg font-bold hover:underline cursor-pointer text-[#c32d2c] rounded-lg p-1">X</button>
                        <h2 class="text-center text-xl md:text-2xl font-bold mb-6 border-b-2 text-gray-300 border-white pb-2">Nos Plats</h2>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 overflow-y-auto max-h-[60vh] px-2">
                            <!-- Plat 1 -->
                            <div class="bg-[#1e1e1e] rounded-lg p-4 flex flex-col h-full">
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-gray-300 mb-2 text-center">Sandwich</h3>
                                    <img src="{{ asset('images/sandwich.png') }}" alt="Sandwich" class="w-24 h-24 mb-3 mx-auto">
                                </div>
                                <div class="mt-auto pt-4">
                                    <p class="font-bold text-gray-300 text-lg mb-3 text-center">2,10 €</p>
                                    <button class="add-to-cart bg-[#229747] rounded-lg px-4 py-2 text-sm font-bold w-full hover:underline">Ajouter</button>
                                </div>
                            </div>
                            
                            <!-- Plat 2 -->
                            <div class="bg-[#1e1e1e] rounded-lg p-4 flex flex-col h-full">
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-gray-300 mb-2 text-center">Panini</h3>
                                    <img src="{{ asset('images/panini.png') }}" alt="Panini" class="w-24 h-24 mb-3 mx-auto">
                                </div>
                                <div class="mt-auto pt-4">
                                    <p class="font-bold text-gray-300 text-lg mb-3 text-center">2,10 €</p>
                                    <button class="add-to-cart bg-[#229747] rounded-lg px-4 py-2 text-sm font-bold w-full hover:underline">Ajouter</button>
                                </div>
                            </div>
                            
                            <!-- Plat 3 -->
                            <div class="bg-[#1e1e1e] rounded-lg p-4 flex flex-col h-full">
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-gray-300 mb-2 text-center">Hot-Dog</h3>
                                    <img src="{{ asset('images/hd.png') }}" alt="HD" class="w-24 h-24 mb-3 mx-auto">
                                </div>
                                <div class="mt-auto pt-4">
                                    <p class="font-bold text-gray-300 text-lg mb-3 text-center">1,10 €</p>
                                    <button class="add-to-cart bg-[#229747] rounded-lg px-4 py-2 text-sm font-bold w-full hover:underline">Ajouter</button>
                                </div>
                            </div>
                            <!-- Plat 4 -->
                            <div class="bg-[#1e1e1e] rounded-lg p-4 flex flex-col h-full">
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-gray-300 mb-2 text-center">Croques</h3>
                                    <img src="{{ asset('images/croques.png') }}" alt="Croques" class="w-24 h-24 mb-3 mx-auto">
                                </div>
                                <div class="mt-auto pt-4">
                                    <p class="font-bold text-gray-300 text-lg mb-3 text-center">1,10 €</p>
                                    <button class="add-to-cart bg-[#229747] rounded-lg px-4 py-2 text-sm font-bold w-full hover:underline">Ajouter</button>
                                </div>
                            </div>
                        </div>
                    </dialog>
                </div>
            </div>
        </div>
    </div>

    @include('footer')

    <script src="{{ asset('js/dialog.js') }}"></script>

</body>
</html>