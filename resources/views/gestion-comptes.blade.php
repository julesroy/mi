<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Gestion des comptes</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include('header')
    <div class="px-8">
        <!--Barre de recherche-->
        <div class="bg-white py-6 px-8 w-full max-w-7x1 mx-auto">
            <form method="GET" action="{{ route('gestion-comptes') }}">
                <label for="recherche" class="block mb-2 font-semibold text-black">Rechercher un utilisateur :</label>
                <input 
                    id="recherche" 
                    name="recherche" 
                    type="text" 
                    value="{{ $recherche ?? '' }}" 
                    placeholder="Rechercher par nom/prénom/numéro" 
                    class="w-full border border-gray-500 rounded px-4 py-2 focus:outline-none text-gray-500 focus:ring-2 focus:ring-black focus:text-black" 
                />

                <div class="flex items-center gap-4 mt-4">
                    <!-- Bouton selection type de tri -->
                    <div class="relative">
                        <button 
                            type="button" 
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-black transition transform hover:scale-105 active:scale-95"
                            id="dropdownButton">
                            Trier par
                        </button>
                        <div 
                            class="absolute mt-2 bg-white border border-gray-300 rounded shadow-lg hidden" 
                            id="dropdownMenu">
                            <!-- Options de triage -->
                            <a href="{{ route('gestion-comptes', array_merge(request()->all(), ['triage' => 'solde_desc'])) }}" 
                               class="block px-4 py-2 text-black hover:bg-gray-200 {{ request('triage') == 'solde_desc' ? 'font-bold' : '' }}">
                                Solde (plus élevé au plus bas)
                            </a>
                            <a href="{{ route('gestion-comptes', array_merge(request()->all(), ['triage' => 'solde_asc'])) }}" 
                               class="block px-4 py-2 text-black hover:bg-gray-200 {{ request('triage') == 'solde_asc' ? 'font-bold' : '' }}">
                                Solde (plus bas au plus élevé)
                            </a>
                            <a href="{{ route('gestion-comptes', array_merge(request()->all(), ['triage' => 'nom_asc'])) }}" 
                               class="block px-4 py-2 text-black hover:bg-gray-200 {{ request('triage') == 'nom_asc' ? 'font-bold' : '' }}">
                                Nom (A-Z)
                            </a>
                            <a href="{{ route('gestion-comptes', array_merge(request()->all(), ['triage' => 'nom_desc'])) }}" 
                               class="block px-4 py-2 text-black hover:bg-gray-200 {{ request('triage') == 'nom_desc' ? 'font-bold' : '' }}">
                                Nom (Z-A)
                            </a>
                            <a href="{{ route('gestion-comptes', array_merge(request()->all(), ['triage' => 'prenom_asc'])) }}" 
                               class="block px-4 py-2 text-black hover:bg-gray-200 {{ request('triage') == 'prenom_asc' ? 'font-bold' : '' }}">
                                Prénom (A-Z)
                            </a>
                            <a href="{{ route('gestion-comptes', array_merge(request()->all(), ['triage' => 'prenom_desc'])) }}" 
                               class="block px-4 py-2 text-black hover:bg-gray-200 {{ request('triage') == 'prenom_desc' ? 'font-bold' : '' }}">
                                Prénom (Z-A)
                            </a>
                            <a href="{{ route('gestion-comptes', array_merge(request()->all(), ['triage' => 'numeroCompte_asc'])) }}" 
                               class="block px-4 py-2 text-black hover:bg-gray-200 {{ request('triage') == 'numeroCompte_asc' ? 'font-bold' : '' }}">
                                Numéro (croissant)
                            </a>
                            <a href="{{ route('gestion-comptes', array_merge(request()->all(), ['triage' => 'numeroCompte_desc'])) }}" 
                               class="block px-4 py-2 text-black hover:bg-gray-200 {{ request('triage') == 'numeroCompte_desc' ? 'font-bold' : '' }}">
                                Numéro (décroissant)
                            </a>
                        </div>
                    </div>

                    <!-- Boutons Recherche et Rénitialiser -->
                    <button 
                        type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition transform hover:scale-105 active:scale-95">
                        Rechercher 
                    </button>
                    <a 
                        href="{{ route('gestion-comptes') }}" 
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition transform hover:scale-105 active:scale-95">
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        <!-- Tableau -->
        <div class="overflow-x-auto px-8 py-6">
            <table class="min-w-full bg-white border border-white">
                <thead>
                    <tr class="bg-green-500">
                        <th class="py-2 px-4 border">Identifiant</th>
                        <th class="py-2 px-4 border">Nom</th>
                        <th class="py-2 px-4 border">Prénom</th>
                        <th class="py-2 px-4 border">Solde</th>
                        <th class="py-2 px-4 border">Accès</th>
                        <th class="py-2 px-4 border">Modifier</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Affichage des utilisateurs -->
                    <!-- Si l'utilisateur n'existe pas, afficher un message d'erreur -->
                    @if ($utilisateurs->isEmpty())
                        <tr>
                            <td colspan="6" class="py-2 px-4 border border-white text-center text-black">Aucun utilisateur trouvé</td>
                        </tr>
                    @endif
                    <!-- Sinon, afficher les utilisateurs -->
                    @foreach ($utilisateurs as $donneesUtilisateur)
                    <tr class="text-center">
                        <td class="py-2 px-4 border border-white text-black">{{ $donneesUtilisateur->numeroCompte ?? 'NA' }}</td>
                        <td class="py-2 px-4 border border-white text-black">{{ $donneesUtilisateur->nom ?? 'NA' }}</td>
                        <td class="py-2 px-4 border border-white text-black">{{ $donneesUtilisateur->prenom ?? 'NA' }}</td>
                        <td class="py-2 px-4 border border-white text-black">
                            <span class="{{ $donneesUtilisateur->solde > 0 ? 'text-green-500' : ($donneesUtilisateur->solde < 0 ? 'text-red-500' : 'text-gray-500') }}">
                                {{ $donneesUtilisateur->solde ?? '0' }}€
                            </span>
                        </td>
                        <td class="py-2 px-4 border border-white text-black">
                            <a href="/gestion-comptes/modifier-acces" class="text-blue-500 hover:underline">Modifier</a>
                        </td>
                        <td class="py-2 px-4 border border-white text-black">
                            <a href="/gestion-comptes/modifier-compte/" class="text-blue-500 hover:underline">Modifier</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('footer')
        <script>
            document.getElementById('dropdownButton').addEventListener('click', function () {
                const dropdownMenu = document.getElementById('dropdownMenu');
                dropdownMenu.classList.toggle('hidden');
                this.blur(); // Remove focus from the button
            });
        
            // Close dropdown if clicked outside
            window.addEventListener('click', function (event) {
                const dropdownMenu = document.getElementById('dropdownMenu');
                if (!event.target.matches('#dropdownButton') && !event.target.closest('#dropdownMenu')) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        </script>
    </body>
</html>