<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Planning admin</title>
        <style>
            .calendar-day {
                @apply rounded-lg w-5 h-5;
            }
        </style>
    </head>

    <?php setlocale(LC_ALL, 'fr_FR'); ?>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include('header')

        {{-- Dialoge d'inscription pour le planning --}}
        <dialog id="inscriptionDialog" class="backdrop-brightness-50 backdrop-blur-xs flex items-center justify-center w-full bg-transparent h-full absolute top-0 d not-open:hidden">
            <form method="POST" action="planning/ajouter-inscription" class="bg-gray-800 flex flex-col [&_*]:text-white border border-white rounded-2xl p-2.5 pr-3.5 pl-3.5 [&_label]:text-2xl [&>input,&>select]:mb-1.5 [&>input,&>select]:bg-gray-900">
                @csrf

                <h3 class="text-center text-3xl font-bold mt-2.5 mb-2.5">Inscription planning</h3>

                @can('verifier-acces-super-administrateur')
                    <label for="serveur">Serveur</label>
                    <select name="serveur" required>
                        @foreach ($servers as $server)
                            <option value="{{ $server->idUtilisateur }}" {{ $server->idUtilisateur == $userId ? 'selected' : '' }}>{{ $server->prenom . ' ' . $server->nom }}</option>
                        @endforeach
                    </select>
                @else
                    <input type="hidden" value="{{ $userId }}" name="serveur" />
                @endcan

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

        {{--
            <span class="flex-row flex gap-2.5 m-2.5">
            <label>Période :</label>
            <button class="hover:underline cursor-pointer" onclick="updateSearchParams('scope','day')">Jour</button>
            <button class="hover:underline cursor-pointer" onclick="updateSearchParams('scope','week')">Semaine</button>
            <button class="hover:underline cursor-pointer " onclick="updateSearchParams('scope','month')">Mois</button>
            </span>
        --}}

        <span class="flex-row flex gap-2.5 m-2.5">
            <label>Date :</label>
            <input class="border border-white" type="date" value="{{ date('Y-m-d') }}" onchange="updateSearchParams('date',this.value)" />
        </span>

        <button class="border-white border cursor-pointer m-1.5 p-1" onclick="document.getElementById('inscriptionDialog').show()">Inscription</button>

        <!--
        Tableau de debug & affichage provisoire à changer plus tard
     -->
        {{--
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
            @if (Auth::user()->can('verifier-acces-super-administrateur') || $userId == $inscription->numeroCompte)
            <button class="cursor-pointer border-none m-auto"
            onclick="deleteInscription({{ $inscription->idInscription }})">Suppr</button>
            @endif
            
            </td>
            </tr>
            @endforeach
            
            </tbody>
            </table>
        --}}

        <!-- Wrapper global -->
        <div class="flex flex-column md:flex-row justify-center items-center gap-8 [&>*]:bg-gray-800 [&>*]:border-gray-700 [&>*]:border [&>*]:rounded-2xl [&>*]:p-5">
            <div id="calendar">
                <span class="flex flex-row gap-2 [&>button]:cursor-pointer [&>button]:hover:bg-gray-700 [&>button]:transition-all [&>button]:px-1.5 [&>button]:rounded-md [&>button]:text-[#5d52f2]">
                    <button id="prev-month">&lt;</button>
                    <h6 id="calendar__title">{{ date('M Y') }}</h6>
                    <button id="next-month">&gt;</button>
                </span>
                <div id="calendar__inner"></div>
            </div>
            <div id="day" class="flex flex-col">
                <section>
                    <h3 class="flex flex-row gap-2 text-2xl font-bold">
                        <span class="bg-green-600 w-2 block"></span>
                        Bar
                    </h3>
                    <div></div>
                </section>
            </div>
        </div>

        <script>
            var date = {{ date('Y-m-d') }},
                scope = 'month',
                currentDate = new Date();

            const calendarBody = document.getElementById('calendar__inner');
            const calendarTitle = document.getElementById('calendar__title');

            document.getElementById('next-month').addEventListener('click', () => {
                let month = currentDate.getMonth();
                if (month == 11) {
                    currentDate.setMonth(0);
                    currentDate.setYear(currentDate.getYear() + 1);
                } else currentDate.setMonth(month + 1);
                updateCalendar();
            });

            document.getElementById('prev-month').addEventListener('click', () => {
                let month = currentDate.getMonth();
                if (month == 0) {
                    currentDate.setMonth(11);
                    currentDate.setYear(currentDate.getYear() - 1);
                } else currentDate.setMonth(month - 1);
                updateCalendar();
            });

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

            function updateCalendar() {
                calendarBody.innerHtml = 'Loading..;';

                calendarTitle.innerText = currentDate.toLocaleString('fr-FR', {
                    year: '2-digit',
                    month: 'long',
                });

                let month = currentDate.getMonth(),
                    // L'année retournée est relative à 1900, donc 125 pour 2025 par exemple
                    year = currentDate.getYear() + 1900,
                    dateString = `${year}-${month}`;

                fetch(window.location + '/data/' + dateString)
                    .then((r) => r.json())
                    .then((data) => {
                        console.log(data);

                        let monthData = [],
                            startPad = new Date(year, month, 1).getDay() - 1,
                            daysInMonth = new Date(year, month + 1, 0).getDate(),
                            daysInPreviousMonth = new Date(year, month, 0).getDate();

                        for (let i = 0; i < startPad; i++)
                            monthData.push({
                                day: daysInPreviousMonth - (startPad - i),
                            });
                    });
            }

            function afficherInscriptions() {
                const superAdmin = {{ Auth::user()->can('verifier-acces-super-administrateur') }};
            }
        </script>

        @include('footer')
    </body>
</html>
