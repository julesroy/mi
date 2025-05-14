<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Trésorerie</title>
    </head>
    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include('header')

        <div class="max-w-4xl mx-auto py-4 px-4">
            <!-- Section Trésorerie -->
            <section class="mb-10 text-center">
                <h2 class="text-2xl font-semibold mb-4">Trésorerie</h2>
                <div class="flex justify-center">
                    <div class="bg-gray-800 text-white p-4 rounded shadow-md w-full sm:w-auto">
                        <h3 class="text-lg font-semibold">Solde total des comptes</h3>
                        <p class="text-3xl font-bold"><span class="font-bold">{{ number_format($solde, 2, ',', ' ') }}€</span></p>
                    </div>
                </div>
            </section>

            <!-- Section Statistiques des Comptes -->
            <section class="mb-10 text-center">
                <h2 class="text-2xl font-semibold mb-4">Statistiques des comptes</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-gray-800 text-white p-4 rounded shadow-md flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold">Total des comptes</h3>
                        <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
                        <p class="text-sm">comptes</p>
                    </div>
                    <div class="bg-green-500 text-white p-4 rounded shadow-md flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold">Comptes crédités</h3>
                        <p class="text-3xl font-bold">{{ $stats['credites'] }}</p>
                        <p class="text-sm">comptes</p>
                    </div>
                    <div class="bg-orange-500 text-white p-4 rounded shadow-md flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold">Comptes non crédités</h3>
                        <p class="text-3xl font-bold">{{ $stats['non_credites'] }}</p>
                        <p class="text-sm">comptes</p>
                        <button class="mt-4 bg-white text-orange-500 px-4 py-2 rounded hover:bg-orange-100" onclick="document.getElementById('nonCreditesDialog').showModal()">Voir détails</button>
                    </div>
                    <div class="bg-red-500 text-white p-4 rounded shadow-md flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold">Comptes à découvert</h3>
                        <p class="text-3xl font-bold">{{ $stats['decouverts'] }}</p>
                        <p class="text-sm">comptes</p>
                        <button class="mt-4 bg-white text-red-500 px-4 py-2 rounded hover:bg-red-100" onclick="document.getElementById('decouvertsDialog').showModal()">Voir détails</button>
                    </div>
                </div>
            </section>

            <!-- Dialog pour les comptes non crédités -->
            <dialog id="nonCreditesDialog" class="rounded-lg shadow-lg w-full max-w-2xl items-center justify-center">
                <div class="bg-white text-black p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Comptes non crédités</h2>
                    <table class="min-w-full bg-gray-100 border border-gray-300">
                        <thead>
                            <tr class="bg-gray-300">
                                <th class="py-2 px-4 border">Identifiant</th>
                                <th class="py-2 px-4 border">Nom</th>
                                <th class="py-2 px-4 border">Prénom</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($comptesNonCredites && $comptesNonCredites->count() > 0)
                                @foreach ($comptesNonCredites as $compte)
                                    <tr>
                                        <td class="py-2 px-4 border">{{ $compte->numeroCompte }}</td>
                                        <td class="py-2 px-4 border">{{ $compte->nom }}</td>
                                        <td class="py-2 px-4 border">{{ $compte->prenom }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="py-2 px-4 border text-center">Aucun compte non crédité trouvé</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="document.getElementById('nonCreditesDialog').close()">Fermer</button>
                </div>
            </dialog>

            <!-- Dialog pour les comptes à découvert -->
            <dialog id="decouvertsDialog" class="rounded-lg shadow-lg w-full max-w-2xl items-center justify-center">
                <div class="bg-white text-black p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Comptes à découvert</h2>
                    <table class="min-w-full bg-gray-100 border border-gray-300">
                        <thead>
                            <tr class="bg-gray-300">
                                <th class="py-2 px-4 border">Identifiant</th>
                                <th class="py-2 px-4 border">Nom</th>
                                <th class="py-2 px-4 border">Prénom</th>
                                <th class="py-2 px-4 border">Solde</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($comptesDecouverts && $comptesDecouverts->count() > 0)
                                @foreach ($comptesDecouverts as $compte)
                                    <tr>
                                        <td class="py-2 px-4 border">{{ $compte->numeroCompte }}</td>
                                        <td class="py-2 px-4 border">{{ $compte->nom }}</td>
                                        <td class="py-2 px-4 border">{{ $compte->prenom }}</td>
                                        <td class="py-2 px-4 border text-red-500">{{ $compte->solde }}€</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="py-2 px-4 border text-center">Aucun compte à découvert trouvé</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="document.getElementById('decouvertsDialog').close()">Fermer</button>
                </div>
            </dialog>

            <!-- Section Commandes -->
            <section class="mb-10 text-center">
                <h2 class="text-2xl font-semibold mb-4">Commandes</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-gray-800 text-white p-4 rounded shadow-md">
                        <h3 class="text-lg font-semibold">Cette année</h3>
                        <p class="text-3xl font-bold">{{ $commandesAnnee }}</p>
                        <p class="text-sm">commandes validées</p>
                    </div>
                    <div class="bg-gray-800 text-white p-4 rounded shadow-md">
                        <h3 class="text-lg font-semibold">Ce mois-ci</h3>
                        <p class="text-3xl font-bold">{{ $commandesMois }}</p>
                        <p class="text-sm">commandes validées</p>
                    </div>
                    <div class="bg-gray-800 text-white p-4 rounded shadow-md">
                        <h3 class="text-lg font-semibold">Cette semaine</h3>
                        <p class="text-3xl font-bold">{{ $commandesSemaine }}</p>
                        <p class="text-sm">commandes validées</p>
                    </div>
                    <div class="bg-gray-800 text-white p-4 rounded shadow-md">
                        <h3 class="text-lg font-semibold">Aujourd'hui</h3>
                        <p class="text-3xl font-bold">{{ $commandesJour }}</p>
                        <p class="text-sm">commandes validées</p>
                    </div>
                </div>
            </section>
        </div>
        @include('footer')
    </body>
</html>
