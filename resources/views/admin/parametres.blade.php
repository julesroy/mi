<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        @include("head")
        <title>Paramètres</title>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </head>

    <body class="pt-28 md:pt-60">
        @include("header")

        <section class="flex flex-col items-center gap-10 p-6 rounded-2xl w-[90%] max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold text-center">Paramètres</h1>

            @if (session("success"))
                <div class="w-full bg-green-100 text-green-800 px-4 py-2 rounded-lg shadow">
                    {{ session("success") }}
                </div>
            @endif

            <!-- Section Options Générales -->
            <section x-data="options()" class="w-full bg-white rounded-xl border-2 border-black p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Options générales</h2>
                <div class="flex flex-col gap-4 mb-6">
                    <!-- Mode événement -->
                    <button @click="basculer('modeEvenement')" :class="modeEvenement ? 'bg-red-800 text-white' : 'bg-gray-200 text-gray-900'" class="w-full py-3 rounded-lg font-semibold text-lg transition">Mode événement</button>

                    <!-- Commandes en ligne -->
                    <button @click="basculer('commandesEnLigne')" :class="commandesEnLigne ? 'bg-red-800 text-white' : 'bg-gray-200 text-gray-900'" class="w-full py-3 rounded-lg font-semibold text-lg transition">Activer les commandes en ligne</button>

                    <!-- Limitation des heures -->
                    <button @click="basculer('limitationHeures')" :class="limitationHeures ? 'bg-red-800 text-white' : 'bg-gray-200 text-gray-900'" class="w-full py-3 rounded-lg font-semibold text-lg transition">Limiter les heures d'ouverture</button>
                </div>

                <!-- Bouton de confirmation -->
                <button @click="confirmer()" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold text-lg transition hover:bg-green-700">Confirmer les modifications</button>
            </section>

            <!-- Section Changer le logo -->
            <section class="w-full bg-white rounded-xl border-2 border-black p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Changer le logo</h2>
                <div class="flex flex-col gap-4">
                    <label class="block">
                        <span class="text-gray-700 text-lg">Choisir un fichier</span>
                        <input type="file" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-800 hover:file:bg-red-100 mt-2" />
                    </label>
                    <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold text-lg transition hover:bg-blue-700">Enregistrer le logo</button>
                </div>
            </section>

            <!-- Section Modifier le titre -->
            <section class="w-full bg-white rounded-xl border-2 border-black p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Modifier le titre du site</h2>
                <div class="flex flex-col gap-4">
                    <label class="block">
                        <span class="text-gray-700 text-lg">Nouveau titre</span>
                        <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-lg focus:outline-none focus:ring-2 focus:ring-red-800 mt-2" placeholder="Entrez le nouveau titre" />
                    </label>
                </div>
            </section>
        </section>

        <!-- Script pour la mémorisation des états des boutons -->
        <script>
            function options() {
                return {
                    modeEvenement: false,
                    commandesEnLigne: false,
                    limitationHeures: false,
                    modificationsConfirmees: {
                        modeEvenement: false,
                        commandesEnLigne: false,
                        limitationHeures: false,
                    },

                    basculer(option) {
                        this[option] = !this[option];
                    },

                    confirmer() {
                        // Enregistrer les états actuels comme confirmés
                        this.modificationsConfirmees.modeEvenement = this.modeEvenement;
                        this.modificationsConfirmees.commandesEnLigne = this.commandesEnLigne;
                        this.modificationsConfirmees.limitationHeures = this.limitationHeures;

                        alert('Modifications confirmées !');
                    },

                    estActif(option) {
                        return this[option] || this.modificationsConfirmees[option];
                    },
                };
            }
        </script>
    </body>
</html>
