<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Accueil</title>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </head>

    <body class="bg-white pt-28 md:pt-60 overflow-hidden">
    @include('header')
        {{--debug {{ dd ('Page loaded successfully') }} --}}

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-20 pb-2">
            <!-- Coté gauche-->
            <section class="space-y-6">
                <!-- Maison/Service status -->
                <div class="bg-white border rounded-lg shadow p-8 text-4xl">
                    <div class="font-bold">
                        Par'MI'Giano : 
                        <span class="{{ $ouvert ? 'text-green-600' : 'text-red-600' }}">
                            {{ $ouvert ? 'Ouverte' : 'Fermée' }}
                        </span>
                    </div>
                    <div class="font-bold">
                        Service ce midi de  
                        <span class="{{ $serviceMidi === 'Non disponible' ? 'text-red-600' : 'text-green-600' }}">
                            {{ $serviceMidi }}
                        </span>
                    </div>
                </div>
                <!-- Stats MI -->
                <div x-data="{
                        activeSlide: 0,
                        totalSlides: 3,
                        startAutoSlide() {
                            setInterval(() => {
                                this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                            }, 5000); // Change slide every 5 seconds
                        }
                    }"
                    x-init="startAutoSlide()"
                    class="bg-white border rounded-lg shadow p-4 relative">
                    <div class="font-bold mb-2 text-center text-4xl">Statistiques MI</div>

                    <!-- Slides -->
                    <div class="relative overflow-hidden h-24 text-2xl">
                        <!-- Slide 1: Commandes du jour -->
                        <template x-if="activeSlide === 0">
                            <div 
                                class="text-center transition-opacity duration-300"
                                x-transition:enter="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="opacity-100"
                                x-transition:leave-end="opacity-0">
                                <div class="text-3xl font-bold">{{ $stats['today'] ?? 0 }}</div>
                                <div class="text-gray-500">Commandes aujourd'hui</div>
                            </div>
                        </template>

                        <!-- Slide 2: Commandes du mois -->
                        <template x-if="activeSlide === 1">
                            <div 
                                class="text-center transition-opacity duration-300"
                                x-transition:enter="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="opacity-100"
                                x-transition:leave-end="opacity-0">
                                <div class="text-3xl font-bold">{{ $stats['thisMonth'] ?? 0 }}</div>
                                <div class="text-gray-500">Commandes ce mois-ci</div>
                            </div>
                        </template>

                        <!-- Slide 3: Commandes de l'année -->
                        <template x-if="activeSlide === 2">
                            <div 
                                class="text-center transition-opacity duration-300"
                                x-transition:enter="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="opacity-100"
                                x-transition:leave-end="opacity-0">
                                <div class="text-3xl font-bold">{{ $stats['thisYear'] ?? 0 }}</div>
                                <div class="text-gray-500">Commandes cette année</div>
                            </div>
                        </template>
                    </div>

                    <!-- Flèches de navigation -->
                    <div class="absolute inset-0 flex justify-between items-center px-4">
                        <!-- Flèche gauche -->
                        <button 
                            @click="activeSlide = (activeSlide - 1 + totalSlides) % totalSlides" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-full">
                            &#8592; 
                        </button>

                        <!-- Flèche droite -->
                        <button 
                            @click="activeSlide = (activeSlide + 1) % totalSlides" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-full">
                            &#8594;
                        </button>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-center mt-4 space-x-4">
                        <button 
                            @click="activeSlide = 0" 
                            :class="{ 'bg-green-500': activeSlide === 0 }" 
                            class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300">
                        </button>
                        <button 
                            @click="activeSlide = 1" 
                            :class="{ 'bg-green-500': activeSlide === 1 }" 
                            class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300">
                        </button>
                        <button 
                            @click="activeSlide = 2" 
                            :class="{ 'bg-green-500': activeSlide === 2 }" 
                            class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300">
                        </button>
                    </div>
                </div>

                <!-- Stats utilisateur -->
                <div>
                    @auth
                    <div x-data="{
                            activeSlide: 0,
                            totalSlides: 4,
                            startAutoSlide() {
                                setInterval(() => {
                                    this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                                }, 5000); // Change slide every 5 seconds
                            }
                        }"
                        x-init="startAutoSlide()"
                        class="bg-white border rounded-lg shadow p-4 relative">
                        <div class="font-bold mb-2 text-center">Tes statistiques</div>

                        <!-- Slides -->
                        <div class="relative overflow-hidden h-24">
                            <!-- Slide 1: Paninis -->
                            <template x-if="activeSlide === 0">
                                <div 
                                    class="text-center transition-opacity duration-300"
                                    x-transition:enter="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="opacity-100"
                                    x-transition:leave-end="opacity-0">
                                    <div class="text-2xl font-bold">{{ $userStats['paninis'] ?? 0 }}</div>
                                    <div class="text-gray-500">Paninis commandés</div>
                                </div>
                            </template>

                            <!-- Slide 2: Sandwiches -->
                            <template x-if="activeSlide === 1">
                                <div 
                                    class="text-center transition-opacity duration-300"
                                    x-transition:enter="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="opacity-100"
                                    x-transition:leave-end="opacity-0">
                                    <div class="text-2xl font-bold">{{ $userStats['sandwiches'] ?? 0 }}</div>
                                    <div class="text-gray-500">Sandwiches commandés</div>
                                </div>
                            </template>

                            <!-- Slide 3: Croques -->
                            <template x-if="activeSlide === 2">
                                <div 
                                    class="text-center transition-opacity duration-300"
                                    x-transition:enter="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="opacity-100"
                                    x-transition:leave-end="opacity-0">
                                    <div class="text-2xl font-bold">{{ $userStats['croques'] ?? 0 }}</div>
                                    <div class="text-gray-500">Croques commandés</div>
                                </div>
                            </template>

                            <!-- Slide 4: Hotdogs -->
                            <template x-if="activeSlide === 3">
                                <div 
                                    class="text-center transition-opacity duration-300"
                                    x-transition:enter="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="opacity-100"
                                    x-transition:leave-end="opacity-0">
                                    <div class="text-2xl font-bold">{{ $userStats['hotdogs'] ?? 0 }}</div>
                                    <div class="text-gray-500">Hotdogs commandés</div>
                                </div>
                            </template>
                        </div>

                        <!-- Flèches de navigation -->
                        <div class="absolute inset-0 flex justify-between items-center px-4">
                            <!-- Flèche gauche -->
                            <button 
                                @click="activeSlide = (activeSlide - 1 + totalSlides) % totalSlides" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-full">
                                &#8592; 
                            </button>

                            <!-- Flèche droite -->
                            <button 
                                @click="activeSlide = (activeSlide + 1) % totalSlides" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-full">
                                &#8594;
                            </button>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-center mt-4 space-x-4">
                            <button 
                                @click="activeSlide = 0" 
                                :class="{ 'bg-green-500': activeSlide === 0 }" 
                                class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300">
                            </button>
                            <button 
                                @click="activeSlide = 1" 
                                :class="{ 'bg-green-500': activeSlide === 1 }" 
                                class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300">
                            </button>
                            <button 
                                @click="activeSlide = 2" 
                                :class="{ 'bg-green-500': activeSlide === 2 }" 
                                class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300">
                            </button>
                            <button 
                                @click="activeSlide = 3" 
                                :class="{ 'bg-green-500': activeSlide === 3 }" 
                                class="w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300">
                            </button>
                        </div>
                    </div>
                    @endauth
                    @guest
                    <div class="bg-white border rounded-lg shadow p-4">
                        <div class="font-bold">Statistiques utilisateur</div>
                        <div class="text-gray-500">Connectez-vous pour voir vos statistiques.</div>
                    @endguest
                </div>
                </section>

            <!-- Milieu -->
            <section class="space-y-6">
                <!-- Actu du moment -->
                <div class="bg-yellow-50 border rounded-lg shadow p-8 flex flex-col items-center">
                    <div class="text-lg font-bold mb-2">Actu du moment</div>
                    @if(isset($actus) && $actus->isNotEmpty())
                        @foreach($actus as $actu)
                            <div class="mb-1 font-semibold">{{ $actu->titre }}</div>
                            <div class="mb-1 text-sm">{{ \Carbon\Carbon::parse($actu->date)->format('d/m/Y H:i') }}</div>
                            <div class="bg-white border rounded px-4 py-2 shadow mb-2">
                                {{ $actu->contenu }}
                            </div>
                        @endforeach
                    @else
                        <div class="text-gray-500">Aucune actu disponible pour le moment.</div>
                    @endif
                </div>
                <!-- Festi'vendredi -->
                <div class="bg-blue-50 border rounded-lg shadow p-8 flex flex-col items-center">
                    <div class="text-lg font-bold mb-2">Festi'vendredi</div>
                    <div class="mb-1 text-sm">Vendredi 16/05/25</div>
                    <div class="mb-2">Crêpes + soft (au choix)</div>
                    <div class="bg-yellow-400 rounded-full px-3 py-1 font-bold">3,30€</div>
                </div>
            </section>

            <!-- Coté droit -->
            <section class="space-y-6 text-2xl gap-2">
                <!-- Commande info -->
            <div>
                @auth
                <div class="bg-white border rounded-lg shadow p-4">
                    <div class="font-bold">Commande : #027</div>
                    <div>Classement attente :</div>
                    <div>Chaud : <span class="font-semibold">5ème</span></div>
                    <div>Froid : <span class="font-semibold">aucun</span></div>
                </div>
                 @endauth
                 @guest
                <div class="bg-white border rounded-lg shadow p-4">
                    <div class="font-bold">Commandes</div>
                    <div class="text-gray-500">Connectez-vous pour voir vos informations de commande.</div>
                </div>
                 @endguest
            </div>
                <!-- Menus -->
                <div class="bg-white border rounded-lg shadow p-6 min-h-[400px]">
                    <div class="font-bold mb-4 text-lg text-center">Nos menus</div>
                    <ul class="space-y-4">
                        <li>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold">Ch'ite faim</span>
                                <span class="text-green-600 font-bold">3,30€</span>
                            </div>
                            <div class="text-sm text-gray-500">1 plat + 2 périphériques</div>
                        </li>
                        <li>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold">P'tit quinquin</span>
                                <span class="text-green-600 font-bold">3,80€</span>
                            </div>
                            <div class="text-sm text-gray-500">1 plat + 1 hot-dog/croque + 1 périphérique</div>
                        </li>
                        <li>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold">T'cho biloute</span>
                                <span class="text-green-600 font-bold">4,10€</span>
                            </div>
                            <div class="text-sm text-gray-500">2 plats</div>
                        </li>
                    </ul>
                    <a href="/carte">
                        <button class="mt-10 w-full bg-green-600 text-white rounded py-3 font-bold">Voir la carte en détail</button>
                    </a>
                </div>
            </section>
        </div>
    @include('footer')
</body>
</html>