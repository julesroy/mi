<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        @include("head")
        <title>Actus</title>
        <style>
            html,
            body {
                height: 100%;
            }
            body {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            main {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
        </style>
    </head>
    <body class="bg-white pt-28 md:pt-57 min-h-screen flex flex-col">
        @include("header")

        <main class="flex-1">
            <div class="w-full flex justify-center mb-10 px-2 md:px-0">
                <div class="flex flex-col md:flex-row gap-8 w-full max-w-5xl">
                    <!-- Bloc Actualités principal -->
                    <div class="flex-1 bg-white border-2 border-gray-800 rounded-2xl p-0 min-w-[0] max-w-full sm:min-w-[350px] sm:max-w-[600px] flex flex-col h-[400px]">
                        <!-- Titre centré + engrenage -->
                        <div class="relative mb-4 p-4 pb-0">
                            <div class="flex items-center justify-between">
                                <span class="block w-10 h-10"></span>
                                <span class="text-2xl font-bold text-center flex-1">Actualités</span>

                                @if (isset($user) && ($user->acces == 3 or $user->acces == 2))
                                    <a href="/admin/gestion-actus" class="ml-2 hover:opacity-75" title="Gestion des actualités">
                                        <img src="{{ asset("images/icons/admin_parameter.png") }}" alt="Gestion carte" class="w-10 h-10" />
                                    </a>
                                @else
                                    <span class="block w-10 h-10"></span>
                                @endif
                            </div>
                            <!-- Ligne décorative -->
                            <div class="absolute left-0 right-0 -bottom-2 border-b-2 border-gray-400 w-full"></div>
                        </div>
                        <!-- Contenu scrollable -->
                        <div class="overflow-y-auto flex-1 p-4 pt-2">
                            <!-- Sous-titre Prochainement -->
                            <div class="mt-2 mb-2 text-lg font-semibold text-green-800 flex items-center">
                                <svg class="w-5 h-5 mr-1 text-green-700" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" /></svg>
                                Prochainement
                            </div>
                            <div>
                                @forelse ($actusAvenir as $actu)
                                    <div class="cursor-pointer group mt-2" onclick="toggleActuImage({{ $actu->idActu }})">
                                        <div class="flex items-center justify-between bg-primaire hover:bg-secondaire text-white p-2 rounded-2xl border-1 border-gray-700">
                                            <div>
                                                <span>{{ $actu->type == 1 ? 'Festi\'vendredi' : "Actu" }} :</span>
                                                <span>{{ $actu->titre }}</span>
                                            </div>
                                            <span>{{ \Carbon\Carbon::parse($actu->date)->format("d/m/Y") }}</span>
                                        </div>
                                        <!-- Déroulant : image ou message -->
                                        <div id="actu-image-{{ $actu->idActu }}" class="hidden">
                                            @if ($actu->image)
                                                <img src="{{ asset("storage/" . $actu->image) }}" alt="Image actu" class="w-full max-h-52 object-contain rounded-xl border border-gray-300" />
                                            @else
                                                <div class="text-gray-400 italic p-4 text-center">Aucune image associée</div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-gray-500 italic">Aucune actualité à venir.</div>
                                @endforelse
                            </div>

                            <!-- Sous-titre Passée -->
                            <div class="mt-4 mb-2 text-lg font-semibold text-gray-600 flex items-center">
                                <svg class="w-5 h-5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" /></svg>
                                Passée
                            </div>
                            <div>
                                @forelse ($actusPassees as $actu)
                                    <div class="cursor-pointer group" onclick="toggleActuImage({{ $actu->idActu }})">
                                        <div class="flex items-center justify-between bg-primaire hover:bg-secondaire focus:bg-secondaire text-white p-2 rounded-2xl border-1 border-gray-700">
                                            <div>
                                                <span>{{ $actu->type == 1 ? 'Festi\'vendredi' : "Actu" }} :</span>
                                                <span>{{ $actu->titre }}</span>
                                            </div>
                                            <span>{{ \Carbon\Carbon::parse($actu->date)->format("d/m/Y") }}</span>
                                        </div>
                                        <!-- Déroulant : image ou message -->
                                        <div id="actu-image-{{ $actu->idActu }}" class="hidden">
                                            @if ($actu->image)
                                                <img src="{{ asset("storage/" . $actu->image) }}" alt="Image actu" class="w-full max-h-52 object-contain rounded-xl border border-gray-300" />
                                            @else
                                                <div class="text-gray-400 italic p-4 text-center">Aucune image associée</div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-gray-400 italic">Aucune actualité passée.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Bloc "À venir" à droite -->
                    <div class="w-full md:w-[320px] bg-white border-2 border-gray-800 rounded-2xl p-0 flex flex-col min-w-[0] max-w-full sm:min-w-[250px] sm:max-w-[350px] h-[400px]">
                        <!-- Titre et ligne décorative -->
                        <div class="p-4 pb-0 relative mb-4">
                            <div class="flex items-center">
                                <span class="text-xl font-semibold flex-1 text-center">À venir</span>
                                <svg class="w-6 h-6 text-gray-700 ml-2" fill="none" viewBox="0 0 24 24">
                                    <rect x="4" y="5" width="16" height="15" rx="2" stroke="currentColor" stroke-width="2" />
                                    <path d="M16 3v4M8 3v4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div class="absolute left-0 right-0 -bottom-2 border-b-2 border-gray-400 w-full"></div>
                        </div>
                        <!-- Contenu scrollable -->
                        <div class="overflow-y-auto flex-1 p-4 pt-2">
                            <ul>
                                @forelse ($eventsAvenir as $event)
                                    <li class="flex items-center justify-between py-2 border-b border-gray-200">
                                        <div>
                                            <div class="font-semibold">{{ $event->nom }}</div>
                                            <div class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($event->date)->format("l d/m/Y") }}</div>
                                        </div>
                                        <div class="text-lg font-bold text-green-800 whitespace-nowrap">{{ number_format($event->prix, 2, ",", " ") }} €</div>
                                    </li>
                                @empty
                                    <li class="text-gray-400 italic">Aucun événement à venir.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function toggleActuImage(id) {
                    const el = document.getElementById('actu-image-' + id);
                    if (!el) return;
                    el.classList.toggle('hidden');
                }
            </script>
        </main>
        @include("footer")
    </body>
</html>
