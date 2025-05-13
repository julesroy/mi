<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Salle et Sécurité</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include('header')

        <main class="container mx-auto px-4 pb-20">
            <!-- Section Relevés des températures -->
            <section class="mb-16">
                <h1 class="text-3xl font-bold mb-6">Relevés des températures</h1>

                <!-- Graphique des températures -->
                <div class="mb-8 bg-gray-800 p-4 rounded-lg">
                    <canvas id="temperatureChart"></canvas>
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold mb-4">Historique des relevés</h2>
                    <button onclick="document.getElementById('addTemperatureDialog').showModal()" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded mb-4">+ Ajouter un relevé</button>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-800">
                                    <th class="p-3 text-left">Date</th>
                                    <th class="p-3 text-left">Temp frigo 1</th>
                                    <th class="p-3 text-left">Temp frigo 2</th>
                                    <th class="p-3 text-left">Membre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($temperatureReleves as $releve)
                                    <tr class="border-b border-gray-700 hover:bg-gray-800">
                                        <td class="p-3">{{ $releve->date->format('d/m/Y H:i') }}</td>
                                        <td class="p-3">{{ $releve->temperature1 }}</td>
                                        <td class="p-3">{{ $releve->temperature2 }}</td>
                                        <td class="p-3">{{ $releve->nom }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <hr class="border-gray-700 my-8" />

            <!-- Section Nettoyages -->
            <section>
                <h1 class="text-3xl font-bold mb-6">Nettoyages</h1>

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold mb-4">Historique des nettoyages</h2>
                    <button onclick="document.getElementById('addCleaningDialog').showModal()" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded mb-4">+ Ajouter un nettoyage</button>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-800">
                                    <th class="p-3 text-left">Date et heure</th>
                                    <th class="p-3 text-left">Commentaire</th>
                                    <th class="p-3 text-left">Membre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cleaningReleves as $releve)
                                    <tr class="border-b border-gray-700 hover:bg-gray-800">
                                        <td class="p-3">{{ $releve->date->format('d/m/Y H:i') }}</td>
                                        <td class="p-3">{{ $releve->commentaire ?? '-' }}</td>
                                        <td class="p-3">{{ $releve->nom }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>

        <!-- Dialog pour ajouter un relevé de température -->
        <dialog id="addTemperatureDialog" class="bg-gray-800 rounded-lg shadow-xl text-white p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Ajouter un relevé de température</h3>
                <button onclick="document.getElementById('addTemperatureDialog').close()" class="text-gray-400 hover:text-white">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.salle-securite.ajouter-releve-frigo') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="0" />

                <div>
                    <label for="temperature1" class="block mb-2">Température frigo 1 (°C)</label>
                    <input type="number" step="0.1" id="temperature1" name="temperature1" class="w-full bg-gray-700 border border-gray-600 rounded p-2" required />
                </div>

                <div>
                    <label for="temperature2" class="block mb-2">Température frigo 2 (°C)</label>
                    <input type="number" step="0.1" id="temperature2" name="temperature2" class="w-full bg-gray-700 border border-gray-600 rounded p-2" required />
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" onclick="document.getElementById('addTemperatureDialog').close()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded">Enregistrer</button>
                </div>
            </form>
        </dialog>

        <!-- Dialog pour ajouter un nettoyage -->
        <dialog id="addCleaningDialog" class="bg-gray-800 rounded-lg shadow-xl text-white p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Ajouter un nettoyage</h3>
                <button onclick="document.getElementById('addCleaningDialog').close()" class="text-gray-400 hover:text-white">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.salle-securite.ajouter-nettoyage') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="1" />

                <div>
                    <label for="commentaire" class="block mb-2">Commentaire</label>
                    <textarea id="commentaire" name="commentaire" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded p-2" required></textarea>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" onclick="document.getElementById('addCleaningDialog').close()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded">Enregistrer</button>
                </div>
            </form>
        </dialog>

        @include('footer')

        <script>
            // Fermer les dialogs quand on clique à l'extérieur
            document.querySelectorAll('dialog').forEach((dialog) => {
                dialog.addEventListener('click', function (e) {
                    if (e.target === dialog) {
                        dialog.close();
                    }
                });
            });

            // Graphique des températures
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('temperatureChart').getContext('2d');
                const temperatureChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($temperatureDates),
                        datasets: [
                            {
                                label: 'Frigo 1 (°C)',
                                data: @json($temperature1Values),
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 0.1,
                            },
                            {
                                label: 'Frigo 2 (°C)',
                                data: @json($temperature2Values),
                                borderColor: 'rgb(255, 99, 132)',
                                tension: 0.1,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: false,
                            },
                        },
                    },
                });
            });
        </script>
    </body>
</html>
