<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @includeIf('head')
    <title>Gestion Salle Sécurité</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-900 text-gray-100">
    @include('header')

    <main class="container mx-auto px-4 py-12">
        <section class="mb-12">
            <h1 class="text-3xl font-bold mb-6">Suivi des Températures</h1>
            
            <div class="bg-gray-800 p-6 rounded-lg mb-8">
                <canvas id="tempChart" height="120"></canvas>
            </div>

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Historique</h2>
                <button onclick="showDialog('tempDialog')" 
                        class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">
                    + Nouveau relevé
                </button>
            </div>

            <div class="overflow-x-auto bg-gray-800 rounded-lg">
                <table class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Frigo 1</th>
                            <th class="p-3 text-left">Frigo 2</th>
                            <th class="p-3 text-left">Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($temperatureReleves ?? [] as $salleEtSecurite)
                        <tr class="border-t border-gray-700 hover:bg-gray-700/50">
                            <td class="p-3">{{ $salleEtSecurite->date->format('d/m/Y H:i') }}</td>
                            <td class="p-3">{{ $salleEtSecurite->temperature1 }}°C</td>
                            <td class="p-3">{{ $salleEtSecurite->temperature2 }}°C</td>
                            <td class="p-3">{{ $salleEtSecurite->nom }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center">Aucun relevé enregistré</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="mb-12">
            <h1 class="text-3xl font-bold mb-6">Journal des Nettoyages</h1>
            
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Historique</h2>
                <button onclick="showDialog('cleanDialog')" 
                        class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded">
                    + Nouveau nettoyage
                </button>
            </div>

            <div class="overflow-x-auto bg-gray-800 rounded-lg">
                <table class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">Commentaire</th>
                            <th class="p-3 text-left">Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cleaningReleves ?? [] as $salleEtSecurite)
                        <tr class="border-t border-gray-700 hover:bg-gray-700/50">
                            <td class="p-3">{{ $salleEtSecurite->date->format('d/m/Y H:i') }}</td>
                            <td class="p-3">{{ $salleEtSecurite->commentaire }}</td>
                            <td class="p-3">{{ $salleEtSecurite->nom }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="p-3 text-center">Aucun nettoyage enregistré</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Dialog Température -->
    <dialog id="tempDialog" class="bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Nouveau Relevé</h3>
            <button onclick="hideDialog('tempDialog')" class="text-gray-400 hover:text-white text-2xl">&times;</button>
        </div>
        <form action="{{ route('admin.salle-securite.ajouter-releve-frigo') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block mb-2">Température Frigo 1 (°C)</label>
                    <input type="number" step="0.1" name="temperature1" required 
                           class="w-full bg-gray-700 border border-gray-600 rounded p-2">
                </div>
                <div>
                    <label class="block mb-2">Température Frigo 2 (°C)</label>
                    <input type="number" step="0.1" name="temperature2" required 
                           class="w-full bg-gray-700 border border-gray-600 rounded p-2">
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="hideDialog('tempDialog')" 
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded">
                        Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </dialog>

    <!-- Dialog Nettoyage -->
    <dialog id="cleanDialog" class="bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Nouveau Nettoyage</h3>
            <button onclick="hideDialog('cleanDialog')" class="text-gray-400 hover:text-white text-2xl">&times;</button>
        </div>
        <form action="{{ route('admin.salle-securite.ajouter-nettoyage') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block mb-2">Commentaire</label>
                    <textarea name="commentaire" rows="3" required
                              class="w-full bg-gray-700 border border-gray-600 rounded p-2"></textarea>
                </div>
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="hideDialog('cleanDialog')" 
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded">
                        Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </dialog>

    @include('footer')

    <script>
        // Gestion des dialogs
        function showDialog(id) {
            document.getElementById(id).showModal();
        }
        function hideDialog(id) {
            document.getElementById(id).close();
        }

        // Graphique des températures
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('tempChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartData['dates'] ?? []),
                    datasets: [
                        {
                            label: 'Frigo 1 (°C)',
                            data: @json($chartData['temp1'] ?? []),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.3
                        },
                        {
                            label: 'Frigo 2 (°C)',
                            data: @json($chartData['temp2'] ?? []),
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: false }
                    }
                }
            });
        });
    </script>
</body>
</html>