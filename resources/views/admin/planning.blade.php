<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Planning admin</title>
        <script>
            function updateSearchParams(param, value) {
                let url = new URL(window.location);
                url.searchParams.set(param, value);
                window.location = url.href;
            }

            function deleteInscription(idInscription) {
                console.log('test');
                fetch('planning/supprimer-inscription/' + idInscription, {
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    method: 'DELETE',
                    credentials: 'same-origin',
                }).then(() => window.location.reload());
            }
        </script>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include('header')

        {{-- Dialoge d'inscription pour le planning --}}
        <dialog id="inscriptionDialog" class="backdrop-brightness-50 backdrop-blur-xs flex items-center justify-center w-full bg-transparent h-full absolute top-0 d not-open:hidden">
            <form method="POST" action="planning/ajouter-inscription" class="bg-gray-800 flex flex-col [&_*]:text-white border border-white rounded-2xl p-2.5 pr-3.5 pl-3.5 [&_label]:text-2xl [&>input,&>select]:mb-1.5 [&>input,&>select]:bg-gray-900">
                @csrf
                <!-- {{ csrf_field() }} -->

                <h3 class="text-center text-3xl font-bold mt-2.5 mb-2.5">Inscription planning</h3>

                @if ($acces == 3)
                    <label for="serveur">Serveur</label>
                    <select name="serveur" required>
                        @foreach ($servers as $server)
                            <option value="{{ $server->idUtilisateur }}" {{ $server->idUtilisateur == $userId ? 'selected' : '' }}>{{ $server->prenom . ' ' . $server->nom }}</option>
                        @endforeach
                    </select>
                @else
                    <input type="hidden" value="{{ $userId }}" name="serveur" />
                @endif

                <label for="poste">Poste</label>
                <select name="poste" required>
                    <option value="0">Devant</option>
                    <option value="1">Derrière</option>
                    <option value="2">Transit</option>
                    <option value="3">Courses Match</option>
                </select>

                <label for="date">Date</label>
                <input type="date" name="date" required min="{{ date('Y-m-d') }}" />

                <span class="flex flex-row">
                    <button type="button" class="border border-white m-auto cursor-pointer" onclick="document.getElementById('inscriptionDialog').close()">Annuler</button>
                    <input name="inscription" class="border border-white m-auto cursor-pointer" type="submit" />
                </span>
            </form>
        </dialog>

        <span class="flex-row flex gap-2.5 m-2.5">
            <label>Période :</label>
            <button class="hover:underline cursor-pointer {{ $scope == 'day' ? 'underline' : '' }}" onclick="updateSearchParams('scope','day')">Jour</button>
            <button class="hover:underline cursor-pointer {{ $scope == 'week' || ($scope != 'day' && $scope != 'month') ? 'underline' : '' }}" onclick="updateSearchParams('scope','week')">Semaine</button>
            <button class="hover:underline cursor-pointer {{ $scope == 'month' ? 'underline' : '' }}" onclick="updateSearchParams('scope','month')">Mois</button>
        </span>

        <span class="flex-row flex gap-2.5 m-2.5">
            <label>Date :</label>
            <input class="border border-white" type="date" value="{{ $date }}" onchange="updateSearchParams('date',this.value)" />
        </span>

        <button class="border-white border cursor-pointer m-1.5 p-1" onclick="document.getElementById('inscriptionDialog').show()">Inscription</button>

        <!--
        Tableau de debug & affichage provisoire à changer plus tard
     -->
        <table class="[&_th,&_td]:border-2 [&_th,&_td]:border-white [&_td,&_th]:p-1 [&_td,&_th]:border-collapse">
            <thead class="bg-gray-700">
                <tr>
                    <th>Jour</th>
                    <th>Personne</th>
                    <th>Poste</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($planning as $inscription)
                    <tr class="even:bg-gray-800">
                        <td>
                            {{ $inscription->date }}
                        </td>
                        <td>
                            {{ $inscription->prenom . ' ' . $inscription->nom }}
                        </td>
                        <td>
                            @switch($inscription->poste)
                                @case(0)
                                    Devant

                                    @break
                                @case(1)
                                    Derrière

                                    @break
                                @case(2)
                                    Transit

                                    @break
                                @case(3)
                                    Courses Match

                                    @break
                                @default
                                    Erreur BDD
                            @endswitch
                        </td>
                        <td>
                            @if ($acces == 3 || $userId == $inscription->numeroCompte)
                                <button class="cursor-pointer border-none m-auto" onclick="deleteInscription({{ $inscription->idInscription }})">Suppr</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('footer')
    </body>
</html>
