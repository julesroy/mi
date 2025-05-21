<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include("head")
    <title>Accueil</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-white pt-28 md:pt-58">
    @include("header")
    @auth
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4 sm:px-6 md:px-20 pb-8">
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4 sm:px-6 md:px-20 pb-24">
    @endauth
        <!-- Coté gauche-->
        <section class="space-y-6">
            <!-- Maison/Service status -->
            <div id="status-box" class="bg-white border rounded-lg shadow p-4 sm:p-6 md:p-8 text-lg sm:text-xl md:text-2xl">
                <div class="font-bold">
                    Par'MI'Giano :
                    <span class="{{ $ouvert ? 'text-[var(--color-secondaire)]' : 'text-red-600' }}">
                        {{ $ouvert ? 'Ouverte' : 'Fermée' }}
                    </span>
                </div>

                @if ($ouvert)
                    <div class="font-bold mt-2 flex flex-wrap items-center text-sm sm:text-base">
                        <p>Service ce midi de&nbsp;</p>
                        <p class="text-[var(--color-secondaire)]">{{ $horairesDebutCommandes }}</p>
                        <p>&nbsp;à&nbsp;</p>
                        <p class="text-[var(--color-secondaire)]">{{ $horairesFinCommandes }}</p>
                    </div>
                @endif
            </div>

            <!-- Stats MI -->
            <div x-data="
                {
                    activeSlide: 0,
                    totalSlides: 3,
                    startAutoSlide() {
                        setInterval(() => {
                            this.activeSlide = (this.activeSlide + 1) % this.totalSlides
                        }, 5000)
                    },
                }
                " x-init="startAutoSlide()" class="bg-white border rounded-lg shadow p-4 relative">
                <div id="stats-mi" class="font-bold mb-2 text-center text-lg sm:text-xl md:text-2xl">Statistiques MI</div>
                <div class="relative overflow-hidden h-20 sm:h-24 text-sm sm:text-lg md:text-xl">
                    <template x-if="activeSlide === 0">
                        <div class="text-center transition-opacity duration-300" x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                            <div class="text-lg sm:text-xl md:text-2xl font-bold">{{ $stats["today"] ?? 0 }}</div>
                            <div class="text-gray-500">Commandes aujourd'hui</div>
                        </div>
                    </template>
                    <template x-if="activeSlide === 1">
                        <div class="text-center transition-opacity duration-300" x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                            <div class="text-lg sm:text-xl md:text-2xl font-bold">{{ $stats["thisMonth"] ?? 0 }}</div>
                            <div class="text-gray-500">Commandes ce mois-ci</div>
                        </div>
                    </template>
                    <template x-if="activeSlide === 2">
                        <div class="text-center transition-opacity duration-300" x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                            <div class="text-lg sm:text-xl md:text-2xl font-bold">{{ $stats["thisYear"] ?? 0 }}</div>
                            <div class="text-gray-500">Commandes cette année</div>
                        </div>
                    </template>
                </div>
                <div class="absolute inset-0 flex justify-between items-center px-2 sm:px-4 z-10">
                <!-- Bouton reculer -->
                    <button 
                        @click="activeSlide = (activeSlide - 1 + totalSlides) % totalSlides" 
                        class="cursor-pointer bg-[var(--color-primaire)] hover:bg-[var(--color-secondaire)] text-white font-bold py-2 px-3 sm:py-3 sm:px-4 rounded-full shadow-lg transition-all duration-200 transform hover:scale-105">
                        &#8592;
                    </button>

                <!-- Bouton avancer -->
                    <button 
                        @click="activeSlide = (activeSlide + 1) % totalSlides" 
                        class="cursor-pointer bg-[var(--color-primaire)] hover:bg-[var(--color-secondaire)] text-white font-bold py-2 px-3 sm:py-3 sm:px-4 rounded-full shadow-lg transition-all duration-200 transform hover:scale-105">
                        &#8594;
                    </button>
                </div>
                <div class="flex justify-center mt-2 sm:mt-4 space-x-2 sm:space-x-4">
                    <button @click="activeSlide = 0" :class="activeSlide === 0 ? 'bg-[var(--color-secondaire)]' : 'bg-gray-300'" class="w-2 h-2 sm:w-3 sm:h-3 rounded-full transition-colors duration-300"></button>
                    <button @click="activeSlide = 1" :class="activeSlide === 1 ? 'bg-[var(--color-secondaire)]' : 'bg-gray-300'" class="w-2 h-2 sm:w-3 sm:h-3 rounded-full transition-colors duration-300"></button>
                    <button @click="activeSlide = 2" :class="activeSlide === 2 ? 'bg-[var(--color-secondaire)]' : 'bg-gray-300'" class="w-2 h-2 sm:w-3 sm:h-3 rounded-full transition-colors duration-300"></button>
                </div>
            </div>

            <!-- Stats utilisateur -->
            <div id="stats-user">
                @auth
                    <div x-data="{
                    activeSlide: 0,
                    totalSlides: 4,
                    startAutoSlide() {
                        setInterval(() => {
                            this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                        }, 5000);
                    }
                }" x-init="startAutoSlide()" class="bg-white border rounded-lg shadow p-4 relative">
                    <div class="font-bold mb-2 text-center text-sm sm:text-lg md:text-xl">Tes statistiques</div>
                    <div class="relative overflow-hidden h-20 sm:h-24 text-sm sm:text-lg md:text-xl">
                        <template x-if="activeSlide === 0">
                            <div class="text-center transition-opacity duration-300" x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                                <div class="text-lg sm:text-xl md:text-2xl font-bold">{{ $userStats["paninis"] ?? 0 }}</div>
                                <div class="text-gray-500">Paninis commandés</div>
                            </div>
                        </template>
                        <template x-if="activeSlide === 1">
                            <div class="text-center transition-opacity duration-300" x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                                <div class="text-lg sm:text-xl md:text-2xl font-bold">{{ $userStats["sandwiches"] ?? 0 }}</div>
                                <div class="text-gray-500">Sandwiches commandés</div>
                            </div>
                        </template>
                        <template x-if="activeSlide === 2">
                            <div class="text-center transition-opacity duration-300" x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                                <div class="text-lg sm:text-xl md:text-2xl font-bold">{{ $userStats["croques"] ?? 0 }}</div>
                                <div class="text-gray-500">Croques commandés</div>
                            </div>
                        </template>
                        <template x-if="activeSlide === 3">
                            <div class="text-center transition-opacity duration-300" x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                                <div class="text-lg sm:text-xl md:text-2xl font-bold">{{ $userStats["hotdogs"] ?? 0 }}</div>
                                <div class="text-gray-500">Hotdogs commandés</div>
                            </div>
                        </template>
                    </div>
                    <div class="absolute inset-0 flex justify-between items-center px-2 sm:px-4 z-10">
                    <!-- Bouton reculer -->
                        <button 
                            @click="activeSlide = (activeSlide - 1 + totalSlides) % totalSlides" 
                            class="cursor-pointer bg-[var(--color-primaire)] hover:bg-[var(--color-secondaire)] text-white font-bold py-2 px-3 sm:py-3 sm:px-4 rounded-full shadow-lg transition-all duration-200 transform hover:scale-105">
                            &#8592;
                        </button>

                    <!-- Bouton avancer -->
                        <button 
                            @click="activeSlide = (activeSlide + 1) % totalSlides" 
                            class="cursor-pointer bg-[var(--color-primaire)] hover:bg-[var(--color-secondaire)] text-white font-bold py-2 px-3 sm:py-3 sm:px-4 rounded-full shadow-lg transition-all duration-200 transform hover:scale-105">
                            &#8594;
                        </button>
                    </div>
                    <div class="flex justify-center mt-2 sm:mt-4 space-x-2 sm:space-x-4">
                        <button @click="activeSlide = 0" :class="activeSlide === 0 ? 'bg-[var(--color-secondaire)]' : 'bg-gray-300'" class="w-2 h-2 sm:w-3 sm:h-3 rounded-full transition-colors duration-300"></button>
                        <button @click="activeSlide = 1" :class="activeSlide === 1 ? 'bg-[var(--color-secondaire)]' : 'bg-gray-300'" class="w-2 h-2 sm:w-3 sm:h-3 rounded-full transition-colors duration-300"></button>
                        <button @click="activeSlide = 2" :class="activeSlide === 2 ? 'bg-[var(--color-secondaire)]' : 'bg-gray-300'" class="w-2 h-2 sm:w-3 sm:h-3 rounded-full transition-colors duration-300"></button>
                        <button @click="activeSlide = 3" :class="activeSlide === 3 ? 'bg-[var(--color-secondaire)]' : 'bg-gray-300'" class="w-2 h-2 sm:w-3 sm:h-3 rounded-full transition-colors duration-300"></button>
                    </div>
                </div>
                @endauth
                @guest
                <div class="bg-white border rounded-lg shadow p-4">
                    <div class="font-bold">Statistiques utilisateur</div>
                    <div class="text-gray-500">Connectez-vous pour voir vos statistiques.</div>
                </div>
                @endguest
            </div>
        </section>

        <!-- Milieu -->
        <section id="actus" class="space-y-6">
            <!-- Actu du moment -->
            <div class="bg-yellow-50 border rounded-lg shadow p-6 sm:p-8 flex flex-col items-center text-center">
                <div class="text-lg font-bold mb-2">Actu du moment</div>
                @if (isset($actus) && $actus->isNotEmpty())
                    @foreach ($actus as $actu)
                        <div class="mb-1 font-semibold">{{ $actu->titre }}</div>
                        <div class="mb-1 text-sm">{{ \Carbon\Carbon::parse($actu->date)->format('d/m/Y') }}</div>
                        <div class="bg-white border rounded px-4 py-2 shadow mb-2">{{ $actu->contenu }}</div>
                    @endforeach
                @else
                    <div class="text-gray-500">Aucune actu disponible pour le moment.</div>
                @endif
            </div>

            <!-- Festi'vendredi -->
            <div class="bg-blue-50 border rounded-lg shadow p-6 sm:p-8 flex flex-col items-center text-center">
                <div class="text-lg font-bold mb-2">Festi'vendredi</div>
                <div class="mb-1 text-sm">Vendredi 16/05/25</div>
                <div class="mb-2">Crêpes + soft (au choix)</div>
                <div class="bg-yellow-400 rounded-full px-3 py-1 font-bold">3,30€</div>
            </div>
        </section>

        <!-- Coté droit -->
        <section class="space-y-6 text-xl gap-2">
            <!-- Commande info -->
            <div id="commande-info">
                @auth
                    @if ($commandeEnCours)
                        <div class="bg-white border rounded-lg shadow p-4">
                            <div class="font-bold">Commande : #{{ $commandeEnCours['numeroCommande'] }}</div>
                            <div>Classement attente :</div>
                            <div>
                                Chaud :
                                <span class="font-semibold">{{ $commandeEnCours['positionChaud'] ? $commandeEnCours['positionChaud'] . 'ème' : 'aucun' }}</span>
                            </div>
                            <div>
                                Froid :
                                <span class="font-semibold">{{ $commandeEnCours['positionFroid'] ? $commandeEnCours['positionFroid'] . 'ème' : 'aucun' }}</span>
                            </div>
                        </div>
                    @else
                        <div class="bg-white border rounded-lg shadow p-4">
                            <div class="font-bold">Commande</div>
                            <div class="text-gray-500">Aucune commande en cours.</div>
                        </div>
                     @endif
                @endauth
                @guest
                    <div class="bg-white border rounded-lg shadow p-4">
                        <div class="font-bold">Commandes</div>
                        <div class="text-gray-500">Connectez-vous pour voir vos informations de commande.</div>
                    </div>
                @endguest
            </div>

            <!-- Menus -->
            <div id="menu" class="bg-white border rounded-lg shadow p-4 sm:p-6 min-h-[400px]">
                <div class="font-bold mb-4 text-lg text-center">Nos menus</div>
                <ul class="space-y-4">
                    <li>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Ch'ite faim</span>
                            <span class="text-[var(--color-secondaire)] font-bold">3,30€</span>
                        </div>
                        <div class="text-sm text-gray-500">1 plat + 2 périphériques</div>
                    </li>
                    <li>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">P'tit quinquin</span>
                            <span class="text-[var(--color-secondaire)] font-bold">3,80€</span>
                        </div>
                        <div class="text-sm text-gray-500">1 plat + 1 hot-dog/croque + 1 périphérique</div>
                    </li>
                    <li>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">T'cho biloute</span>
                            <span class="text-[var(--color-secondaire)] font-bold">4,10€</span>
                        </div>
                        <div class="text-sm text-gray-500">2 plats</div>
                    </li>
                </ul>
                <a href="/carte">
                    <button class="cursor-pointer mt-6 w-full bg-[var(--color-primaire)] text-white rounded py-3 font-bold hover:bg-[var(--color-secondaire)] hover:scale-102 transition-transform duration-200">
                        Voir la carte en détail
                    </button>
                </a>
            </div>
        </section>
    </div>
    @include("footer")
</body>
</html>
