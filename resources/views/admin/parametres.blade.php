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
                    <!-- Mode service -->
                    <button @click="basculer('modeService')" :class="modeService ? 'bg-red-800 text-white' : 'bg-green-600 text-white'" class="w-full py-3 rounded-lg font-semibold text-lg transition">Service</button>
                    <!-- Mode événement -->
                    <button @click="basculer('modeEvent')" :class="modeEvent ? 'bg-red-800 text-white' : 'bg-green-600 text-white'" class="w-full py-3 rounded-lg font-semibold text-lg transition">Événement</button>
                </div>

                <!-- Formulaire caché pour envoyer modeService -->
                <form x-ref="formService" method="POST" action="{{ route('admin.parametres.modes-site') }}">
                    @csrf
                    <input type="hidden" name="modeService" x-model="modeService">
                    <input type="hidden" name="modeEvent" x-model="modeEvent">
                    <button type="button" @click="confirmer()" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold text-lg transition hover:bg-green-700">Confirmer les modifications</button>
                </form>
            </section>

            <!-- Section Changer le logo -->
            <section class="w-full bg-white rounded-xl border-2 border-black p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Changer le logo</h2>
                <form class="flex flex-col gap-4" method="POST" action="{{ route('admin.parametres.majLogo') }}" enctype="multipart/form-data">
                    @csrf
                    <label class="block">
                        <span class="text-gray-700 text-lg">Choisir un fichier</span>
                        <input type="file" name="logo" accept="image/png" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-800 hover:file:bg-red-100 mt-2" required />
                    </label>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold text-lg transition hover:bg-blue-700">Enregistrer le logo</button>
                </form>
            </section>

            <!-- Section Modifier le titre -->
            <section class="w-full bg-white rounded-xl border-2 border-black p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Modifier le titre du site</h2>
                <form class="flex flex-col gap-4" name="modifierTitre" method="POST" action="{{ route('admin.parametres.majTitre') }}">
                    @csrf
                    <label class="block">
                        <span class="text-gray-700 text-lg">Nouveau titre</span>
                        <input type="text" name="titre" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-lg focus:outline-none focus:ring-2 focus:ring-red-800 mt-2" placeholder="Entrez le nouveau titre" value="{{ $parametres->titreHeader }}"/>
                    </label>
                    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold text-lg transition hover:bg-green-700">Confirmer le titre</button>
                </form>
            </section>
        </section>

        <!-- Script pour la mémorisation des états des boutons -->
        <script>
            function options() {
                return {
                    modeService: {{ $parametres->service ? 'false' : 'true' }},
                    modeEvent: {{ $parametres->modeEvent ? 'false' : 'true' }},
                    modificationsConfirmees: {
                        modeService: false,
                        modeEvent: false,
                    },

                    basculer(option) {
                        this[option] = !this[option];
                    },

                    confirmer() {
                        this.modificationsConfirmees.modeService = this.modeService;
                        this.modificationsConfirmees.modeEvent = this.modeEvent;
                        this.$refs.formService.submit();
                    },

                    estActif(option) {
                        return this[option] || this.modificationsConfirmees[option];
                    },
                };
            }
        </script>
    </body>
</html>
