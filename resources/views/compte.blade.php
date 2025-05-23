<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('head')
    <title>Profil</title>
    <style>
        .transition-max-height {
            transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            max-height: 0;
        }

        .expanded {
            max-height: unset !important;
        }

        .arrow {
            transition: transform 0.3s;
            display: inline-block;
        }

        .arrow-rotated {
            transform: rotate(90deg);
        }

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

<body class="bg-white text-white pt-28 md:pt-45 h-full flex flex-col [&_*]:box-border box-border">
    @include('header')
    <main class="flex flex-col items-center md:h-full grow-0 flex-1">
        <div class="w-full max-w-5xl flex flex-col md:flex-row gap-8 py-8 px-4 md:h-full">
            <!-- Profil décoré -->
            <div
                class="flex-1 bg-white text-black rounded-2xl p-6 border-2 border-gray-800 min-w-[350px] max-w-[350px] mx-auto md:mx-0">
                <!-- Bloc décoration titre -->
                <div class="flex flex-col items-center mb-2 pb-5">
                    <div class="flex items-center justify-center mb-1">
                        <!-- Feuille gauche -->
                        <svg class="w-5 h-5 text-green-600 mx-1" fill="none" viewBox="0 0 24 24">
                            <ellipse cx="12" cy="12" rx="4" ry="8"
                                transform="rotate(-30 12 12)" fill="currentColor" />
                        </svg>
                        <svg class="w-5 h-5 text-green-600 mx-1" fill="none" viewBox="0 0 24 24">
                            <ellipse cx="12" cy="12" rx="4" ry="8"
                                transform="rotate(-60 12 12)" fill="currentColor" />
                        </svg>
                        <span class="text-xl font-semibold mx-2">Profil</span>
                        <svg class="w-5 h-5 text-green-600 mx-1" fill="none" viewBox="0 0 24 24">
                            <ellipse cx="12" cy="12" rx="4" ry="8"
                                transform="rotate(60 12 12)" fill="currentColor" />
                        </svg>
                        <svg class="w-5 h-5 text-green-600 mx-1" fill="none" viewBox="0 0 24 24">
                            <ellipse cx="12" cy="12" rx="4" ry="8"
                                transform="rotate(30 12 12)" fill="currentColor" />
                        </svg>
                    </div>
                    <!-- Trait décoratif sous le titre -->
                    <div class="border-t-2 border-gray-400 w-3/4 mx-auto mt-2"></div>
                </div>
                <div class="mb-5 pb-5">
                    <div class="mb-5">
                        <span class="font-semibold">Nom :</span>
                        {{ $user->nom }}
                    </div>
                    <div class="mb-5">
                        <span class="font-semibold">Prénom :</span>
                        {{ $user->prenom }}
                    </div>
                    <div class="mb-5">
                        <span class="font-semibold">Email :</span>
                        {{ $user->email }}
                    </div>
                    <div class="mb-5">
                        <span class="font-semibold">ID de compte :</span>
                        {{ $user->idUtilisateur }}
                    </div>
                </div>
                <hr class="my-2 border-gray-400" />
                <div class="text-center text-lg font-semibold mb-2">Solde :
                    {{ number_format($user->solde, 2, ',', ' ') }} €</div>
                <div class="text-xs text-center text-gray-700">Rends toi au comptoir pour recharger ton compte.</div>
            </div>

            <!-- Historique des transactions -->
            <div class="flex-1 bg-white text-black rounded-2xl p-6 border-2 border-gray-800 min-w-[340px] h-full flex flex-col">
                <div class="flex flex-col items-center mb-2">
                    <span class="text-xl font-semibold mb-2 border-b-2 border-gray-400 px-4 pb-1">Historique des
                        transactions</span>
                </div>
                <div class="overflow-y-scroll grow-0">
                    <table class="w-full">
                        <thead>
                            <tr class="text-gray-800">
                                <th class="py-2 px-3 text-left sticky top-0 z-10 bg-white">Date</th>
                                <th class="py-2 px-3 text-left sticky top-0 z-10 bg-white">Mode paiement</th>
                                <th class="hidden md:table-cell py-2 px-3 text-left sticky top-0 z-10 bg-white">N°
                                    Commande</th>
                                <th class="py-2 px-3 text-right sticky top-0 z-10 bg-white">Prix</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paiements as $paiement)
                                <tr class="bg-primaire hover:bg-secondaire cursor-pointer transition"
                                    onclick="toggleRow('{{ $paiement->idPaiement }}')">
                                    <td class="py-2 px-3 text-white min-w-[130px] rounded-l-2xl">
                                        {{ \Carbon\Carbon::parse($paiement->date)->translatedFormat('l d/m/Y') }}
                                        <span id="arrow-{{ $paiement->idPaiement }}" class="arrow">&#9654;</span>
                                    </td>
                                    <td class="text-white py-2 px-3">
                                        @if ($paiement->type == 0)
                                            Espèces
                                        @elseif ($paiement->type == 1)
                                            Carte bancaire
                                        @elseif ($paiement->type == 2)
                                            Compte
                                        @endif
                                    </td>
                                    <td class="hidden md:table-cell py-2 px-3 text-white">#{{ $paiement->idPaiement }}
                                    </td>
                                    <td class="py-2 px-3 text-white text-right rounded-r-2xl">
                                        {{ number_format($paiement->montant, 2, ',', ' ') }}€</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="p-0 font-sans">
                                        <div id="details-{{ $paiement->idPaiement }}"
                                            class="transition-max-height bg-gray-200 rounded-2xl">
                                            <div class="px-6 py-2 text-black">
                                                @if ($paiement->commandes)
                                                    <ul class="list-disc pl-4">
                                                        @foreach ($paiement->commandes as $commande)
                                                            <li class="mb-2">
                                                                <div>
                                                                    <span class="font-semibold">Commande
                                                                        {{ $commande->numeroCommande }} :</span>
                                                                    <span>
                                                                        @php
                                                                            if ($commande->stock) {
                                                                                foreach (
                                                                                    explode(';', $commande->stock)
                                                                                    as $item
                                                                                ) {
                                                                                    [
                                                                                        $idArticle,
                                                                                        $quantite,
                                                                                        $obligatoire,
                                                                                    ] = explode(',', $item);

                                                                                    $nomArticle =
                                                                                        $articlesMap[$idArticle] ??
                                                                                        'Article #' . $idArticle;
                                                                                    $articles[] =
                                                                                        $quantite . ' x ' . $nomArticle;
                                                                                }
                                                                            }
                                                                        @endphp

                                                                        {{ implode(', ', $articles) }}
                                                                    </span>
                                                                </div>
                                                                @if ($commande->commentaire)
                                                                    <div>
                                                                        <span class="font-semibold">Remarque :</span>
                                                                        <span>{{ $commande->commentaire }}</span>
                                                                    </div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <div class="text-gray-600 text-sm">Aucune commande associée à ce
                                                        paiement.</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if (!$loop->last)
                                    <tr>
                                        <td colspan="4"
                                            style="height: 8px; padding: 0; border: none; background: transparent"></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    @include('footer')

    <script>
        let openId = null;

        function toggleRow(id) {
            let details = document.getElementById('details-' + id);
            let arrow = document.getElementById('arrow-' + id);
            if (!details) return;

            // Si déjà ouvert, on referme et on ne rouvre rien
            if (details.classList.contains('expanded')) {
                details.classList.remove('expanded');
                if (arrow) arrow.classList.remove('arrow-rotated');
                openId = null;
                return;
            }

            // Sinon, on ferme tous les autres puis on ouvre celui-ci
            document.querySelectorAll('.transition-max-height.expanded').forEach(function(el) {
                el.classList.remove('expanded');
            });
            document.querySelectorAll('.arrow.arrow-rotated').forEach(function(el) {
                el.classList.remove('arrow-rotated');
            });

            details.classList.add('expanded');
            if (arrow) arrow.classList.add('arrow-rotated');
            openId = id;
        }
    </script>
</body>

</html>
