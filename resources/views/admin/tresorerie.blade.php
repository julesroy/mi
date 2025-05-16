<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        @include("head")
        <title>Trésorerie</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-60">
        @include("header")

        <div class="max-w-4xl mx-auto py-4 px-4">
            <!-- Section Trésorerie -->
            <section class="mb-10 text-center gap-4">
                <h2 class="text-2xl font-semibold mb-4">Trésorerie</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Solde total des comptes -->
                    <div class="bg-gray-800 text-white p-6 rounded shadow-md flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold">Solde total des comptes</h3>
                        <p class="text-3xl font-bold"><span class="font-bold">{{ number_format($solde, 2, ",", " ") }}€</span></p>
                    </div>

                    <!-- Solde de la caisse -->
                    <div class="bg-gray-800 text-white p-6 rounded shadow-md flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold">Solde de la caisse</h3>
                        <p class="text-3xl font-bold"><span class="font-bold">{{ number_format($caisse, 2, ',', ' ') }}€</span></p>                        
                        <button class="mt-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition transform hover:scale-105" onclick="openDialog('modifyCaisseDialog')">Modifier</button>
                    </div>
                </div>
            </section>

            <!-- Dialog pour modifier le solde de la caisse -->
            <div id="modifyCaisseDialog" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white text-black p-6 rounded-lg shadow-lg max-w-md w-full mx-auto">
                    <h2 class="text-xl font-semibold mb-4">Modifier le solde de la caisse</h2>
                    <form>
                        <label class="block mb-4">
                            <span class="text-gray-700 text-lg">Nouveau solde (€)</span>
                            <input type="number" step="0.01" placeholder="Entrez un montant" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mt-2">
                        </label>
                        <div class="flex justify-end gap-4">
                            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                onclick="closeDialog('modifyCaisseDialog')">Annuler</button>
                            <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Section Statistiques des Comptes -->
            <section class="mb-10 text-center">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-gray-800 text-white p-4 rounded shadow-md flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold">Total des comptes</h3>
                        <p class="text-3xl font-bold">{{ $stats["total"] }}</p>
                        <p class="text-sm">comptes</p>
                    </div>
                    <div class="bg-green-500 text-white p-4 rounded shadow-md flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold">Comptes crédités</h3>
                        <p class="text-3xl font-bold">{{ $stats["credites"] }}</p>
                        <p class="text-sm">comptes</p>
                        <button class="mt-4 bg-white text-green-500 px-4 py-2 rounded hover:bg-orange-100" onclick="document.getElementById('creditesDialog').showModal()">Voir détails</button>
                    </div>
                    <div class="bg-orange-500 text-white p-4 rounded shadow-md flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold">Comptes non crédités</h3>
                        <p class="text-3xl font-bold">{{ $stats["non_credites"] }}</p>
                        <p class="text-sm">comptes</p>
                        <button class="mt-4 bg-white text-orange-500 px-4 py-2 rounded hover:bg-orange-100" onclick="document.getElementById('nonCreditesDialog').showModal()">Voir détails</button>
                    </div>
                    <div class="bg-red-500 text-white p-4 rounded shadow-md flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold">Comptes à découvert</h3>
                        <p class="text-3xl font-bold">{{ $stats["decouverts"] }}</p>
                        <p class="text-sm">comptes</p>
                        <button class="mt-4 bg-white text-red-500 px-4 py-2 rounded hover:bg-red-100" onclick="document.getElementById('decouvertsDialog').showModal()">Voir détails</button>
                    </div>
                </div>
            </section>

           <!-- Dialog pour modifier le solde de la caisse -->
            <dialog id="modifyCaisseDialog" class="rounded-lg shadow-lg w-full max-w-2xl">
                <div class="bg-white text-black p-6 rounded-lg flex flex-col max-h-[80vh]">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Modifier le solde de la caisse</h2>
                        <button class="text-red-500 hover:text-red-700 font-bold text-lg" onclick="closeDialog('modifyCaisseDialog')">X</button>
                    </div>
                    <form>
                        <label class="block mb-4">
                            <span class="text-gray-700 text-lg">Nouveau solde (€)</span>
                            <input type="number" step="0.01" placeholder="Entrez un montant" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mt-2">
                        </label>
                        <div class="flex justify-end gap-4">
                            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                onclick="closeDialog('modifyCaisseDialog')">Annuler</button>
                            <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </dialog>

            <!-- Dialog pour les comptes crédités -->
            <dialog id="creditesDialog" class="rounded-lg shadow-lg w-full max-w-2xl">
                <div class="bg-white text-black p-6 rounded-lg flex flex-col max-h-[80vh]">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Comptes crédités</h2>
                        <button class="text-red-500 hover:text-red-700 font-bold text-lg" onclick="closeDialog('creditesDialog')">X</button>
                    </div>
                    <div class="overflow-y-auto flex-grow border-t border-gray-300">
                        <table class="min-w-full bg-gray-100 border border-gray-300">
                            <thead>
                                <tr class="bg-gray-300">
                                    <th class="py-2 px-4 border">Identifiant</th>
                                    <th class="py-2 px-4 border">Nom</th>
                                    <th class="py-2 px-4 border">Prénom</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($comptesCredites && $comptesCredites->count() > 0)
                                    @foreach ($comptesCredites as $compte)
                                        <tr>
                                            <td class="py-2 px-4 border">{{ $compte->numeroCompte }}</td>
                                            <td class="py-2 px-4 border">{{ $compte->nom }}</td>
                                            <td class="py-2 px-4 border">{{ $compte->prenom }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="py-2 px-4 border text-center">Aucun compte crédité trouvé</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="closeDialog('creditesDialog')">Fermer</button>
                    </div>
                </div>
            </dialog>

            <!-- Dialog pour les comptes non crédités -->
            <dialog id="nonCreditesDialog" class="rounded-lg shadow-lg w-full max-w-2xl">
                <div class="bg-white text-black p-6 rounded-lg flex flex-col max-h-[80vh]">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Comptes non crédités</h2>
                        <button class="text-red-500 hover:text-red-700 font-bold text-lg" onclick="closeDialog('nonCreditesDialog')">X</button>
                    </div>
                    <div class="overflow-y-auto flex-grow border-t border-gray-300">
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
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="closeDialog('nonCreditesDialog')">Fermer</button>
                    </div>
                </div>
            </dialog>

            <!-- Dialog pour les comptes à découvert -->
            <dialog id="decouvertsDialog" class="rounded-lg shadow-lg w-full max-w-2xl">
                <div class="bg-white text-black p-6 rounded-lg flex flex-col max-h-[80vh]">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Comptes à découvert</h2>
                        <button class="text-red-500 hover:text-red-700 font-bold text-lg" onclick="closeDialog('decouvertsDialog')">X</button>
                    </div>
                    <div class="overflow-y-auto flex-grow border-t border-gray-300">
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
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="closeDialog('decouvertsDialog')">Fermer</button>
                    </div>
                </div>
            </dialog>

            <!-- Section Commandes -->
            <section class="mb-10 text-center">
                <h2 class="text-2xl font-semibold mb-4">Commandes</h2>
                <div class="mb-4">
                    <select id="timePeriod" class="bg-gray-800 text-white p-2 rounded">
                        <option value="year">Cette année</option>
                        <option value="month">Ce mois-ci</option>
                        <option value="week">Cette semaine</option>
                        <option value="day">Aujourd'hui</option>
                    </select>
                </div>
                <!-- Chart container -->
                <canvas id="commandesChart" class="w-full max-w-4xl mx-auto"></canvas>
            </section>
        </div>

        @include("footer")

        
        <script>
            // Scripte pour les dialogues
            function openDialog(id) {
            const dialog = document.getElementById(id);
                if (dialog) {
                    dialog.showModal();
                }
            }

            function closeDialog(id) {
            const dialog = document.getElementById(id);
                if (dialog) {
                    dialog.close();
                }
            }

            // Scripte pour le graphe data
            const commandesAnnee = @json($commandesAnnee);
            const commandesMois = @json($commandesMois);
            const commandesSemaine = @json($commandesSemaine);
            const commandesJour = @json($commandesJour);

            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('commandesChart').getContext('2d');
                const timePeriodSelect = document.getElementById('timePeriod');

                // Initialize the chart
                let commandesChart = new Chart(ctx, {
                    type: 'line', // You can change this to 'bar', 'pie', etc.
                    data: {
                        labels: [], // Labels will be dynamically updated
                        datasets: [{
                            label: 'Commandes',
                            data: [], // Data will be dynamically updated
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Période'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Nombre de commandes'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Function to update chart data
                function updateChart(timePeriod) {
                    let data = [];
                    let labels = [];

                    switch (timePeriod) {
                        case 'year':
                            data = commandesAnnee.map(item => item.count);
                            labels = commandesAnnee.map(item => `Mois ${item.month}`);
                            break;
                        case 'month':
                            data = commandesMois.map(item => item.count);
                            labels = commandesMois.map(item => `Jour ${item.day}`);
                            break;
                        case 'week':
                            data = commandesSemaine.map(item => item.count);
                            labels = commandesSemaine.map(item => `Jour ${item.day}`);
                            break;
                        case 'day':
                            data = commandesJour.map(item => item.count);
                            labels = commandesJour.map(item => `${item.hour}h`);
                            break;
                    }

                    // Update chart data
                    commandesChart.data.labels = labels;
                    commandesChart.data.datasets[0].data = data;
                    commandesChart.update();
                }

                // Initial chart load
                updateChart(timePeriodSelect.value);

                // Update chart when the time period changes
                timePeriodSelect.addEventListener('change', function () {
                    updateChart(this.value);
                });
            });

        </script>
    </body>
</html>
