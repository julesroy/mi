<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('head')
    <title>Planning admin</title>
    <style>
        .week-job-0>*,
        .job-0 {
            background-color: rgba(41, 128, 185, 0.2);
            color: #3498db;
        }

        .week-job-1>*,
        .job-1 {
            background-color: rgba(192, 57, 43, 0.2);
            color: #e74c3c;
        }

        .week-job-2>*,
        .job-2 {
            background-color: rgba(243, 156, 18, 0.2);
            color: #f39c12;
        }

        .week-job-3>*,
        .job-3 {
            background-color: rgba(39, 174, 96, 0.2);
            color: #2ecc71;
        }

        #planningWrapper:not(.day) tr:has(td.selected) td,
        #planningWrapper td.selected {
            color: oklch(0.546 0.245 262.881);
        }

        #planningWrapper:not(.day) #displayMode__week,
        #planningWrapper.day #displayMode__day {
            text-decoration: 2px solid underline white;
            color: white;
        }

        #planningWrapper:not(.day) #day,
        #planningWrapper.day #week {
            display: none;
        }
    </style>

</head>

<?php setlocale(LC_ALL, 'fr_FR'); ?>

<body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
    @include('header')

    {{-- Dialogue de suppression d'inscription  --}}
    <dialog id="deleteDialog"
        class="backdrop-brightness-50 backdrop-blur-xs flex items-center justify-center w-full bg-transparent h-full absolute top-0 d not-open:hidden z-10 [&_button]:hover:cursor-pointer">
        <div class="rounded-lg bg-gray-800 p-6 shadow-lg m-8">
            <input type="hidden" value="0" id="deleteDialog__id" />
            <div class="flex items-start justify-between">
                <h2 class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white">
                    Désinscription
                </h2>

                <button type="button"
                    class="-me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                    onclick="document.getElementById('deleteDialog').close()" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-4">
                <p class="text-pretty text-gray-700 dark:text-gray-200">
                    Voulez-vous vraiment désinscrire <b id="deleteDialog__name">Test</b> du poste
                    <b id="deleteDialog__job">Poste</b> le
                    <b id="deleteDialog__date">dd/mm/yyy</b> ?
                </p>
            </div>

            <footer class="mt-6 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('deleteDialog').close()"
                    class="rounded bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                    Annuler
                </button>

                <button type="button" onclick="deleteInscription()"
                    class="rounded bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700">
                    Désinscrire
                </button>
            </footer>
        </div>
    </dialog>

    {{-- Dialoge d'inscription pour le planning --}}
    <dialog id="inscriptionDialog"
        class="backdrop-brightness-50 backdrop-blur-xs flex items-center justify-center w-full bg-transparent h-full absolute top-0 d not-open:hidden z-10 [&_button]:hover:cursor-pointer">
        <form id="inscriptionDialog__form" class="rounded-lg bg-gray-800 p-6 shadow-lg m-8" method="dialog">
            <input type="hidden" value="0" id="deleteDialog__id" />
            <div class="flex items-start justify-between">
                <h2 class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white">
                    Inscription
                </h2>

                <button type="button"
                    class="-me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                    onclick="document.getElementById('inscriptionDialog').close()" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div
                class="flex flex-col text-gray-200 mt-4 [&_label]:text-lg [&>select]:mb-1.5 [&>select]:bg-gray-900 [&>select]:rounded-full [&>select]:py-2 [&>select]:px-4 [&>select]:cursor-pointer [&>select]:hover:bg-gray-700 [&>select]:transition-colors">

                <p class="text-pretty mb-2.5">
                    Pour le
                    <b id="inscriptionDialog__dateDisplay">yyyy-mm-dd</b>
                </p>

                <input type="hidden" id="inscriptionDialog__date" name="date" />

                @csrf

                @can('verifier-acces-super-administrateur')
                    <label for="serveur">Serveur</label>
                    <select name="serveur" required>
                        @foreach ($servers as $server)
                            <option value="{{ $server->idUtilisateur }}"
                                {{ $server->idUtilisateur == $userId ? 'selected' : '' }}>
                                {{ $server->prenom . ' ' . $server->nom }} </option>
                        @endforeach
                    </select>
                @else
                    <input type="hidden" value="{{ $userId }}" name="serveur" />
                @endcan

                <label for="poste">Poste</label>
                <select name="poste" id="inscriptionDialog__job" required>
                    <option value="0">Bar</option>
                    <option value="1">Cuisine</option>
                    <option value="2">Transit</option>
                    <option value="3">Courses Match</option>
                </select>
            </div>

            <footer class="mt-6 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('inscriptionDialog').close()"
                    class="rounded bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                    Annuler
                </button>

                <button type="submit"
                    class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">
                    Inscire
                </button>
            </footer>
        </form>
    </dialog>

    <!-- Wrapper global -->
    <div id="planningWrapper"
        class="flex flex-col md:flex-row justify-center items-center gap-8
      [&>*]:bg-gray-800 [&>*]:border-gray-700 [&>*]:border [&>*]:rounded-2xl
      day
    ">
        <div id="calendar" class="flex flex-col items-center">
            <span
                class="flex flex-row gap-2 m-2.5
            [&>button]:cursor-pointer [&>button]:hover:bg-gray-700 [&>button]:transition-all [&>button]:px-1.5 [&>button]:rounded-md
            [&>button]:text-[#5d52f2] [&>button]:disabled:pointer-events-none [&>button]:disabled:brightness-50">
                <button id="prev-month">&lt;</button>
                <h6 id="calendar__title">{{ date('M Y') }}</h6>
                <button id="next-month">&gt;</button>
            </span>
            <span id="displayMode" class="flex flex-row justify-center gap-5 mb-2.5 [&_button]:text-gray-500">
                <button onclick="setDisplayMode(true)" id="displayMode__day"
                    class="font-bold hover:text-gray-300 cursor-pointer">Jour</button>
                <button onclick="setDisplayMode(false)" id="displayMode__week"
                    class="font-bold hover:text-gray-300 cursor-pointer">Semaine</button>
            </span>
            <div class="border-t border-t-gray-700 px-5 py-2.5">
                <table>
                    <thead>
                        <tr class="[&_*]:text-xs [&_*]:p-1">
                            <th>L</th>
                            <th>M</th>
                            <th>M</th>
                            <th>J</th>
                            <th>V</th>
                        </tr>
                    </thead>
                    <tbody id="calendar__inner">

                    </tbody>
                </table>
            </div>
        </div>

        {{-- Affichage par jour --}}
        <div id="day" class="flex flex-col w-sm md:w-md lg:w-xl">
            @foreach ([['blue', 'Bar'], ['red', 'Cuisine'], ['yellow', 'Transit'], ['green', 'Courses']] as $index => $job)
                <section class="p-5 pb-3 border-t-gray-700 {{ $index == 0 ? '' : 'border-t' }}">
                    <h3 class="flex flex-row gap-2 text-2xl font-bold relative">
                        <span class="bg-{{ $job[0] }}-600 w-2 block"></span>
                        {{ $job[1] }}
                        <button type="button"
                            class="absolute right-1 cursor-pointer rounded-full text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                            onclick="showInscriptionDialog({{ $index }})" aria-label="Inscription">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 12L18 12M12 6L12 18" />
                            </svg>
                        </button>
                    </h3>
                    <div id="day__{{ $index }}" class="flex flex-col m-1">
                    </div>
                </section>
            @endforeach
        </div>

        {{-- Affichage par semaine --}}
        <div id="week" class="flex flex-col w-sm md:w-md lg:w-xl">
            @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'] as $index => $day)
                <section class="p-5 pb-3 border-t-gray-700 {{ $index == 0 ? '' : 'border-t' }}">
                    <h3 class="flex flex-row gap-2 text-2xl font-bold relative">
                        {{ $day }}
                        <button type="button" id="week__inscription__{{ $index }}"
                            class="absolute right-1 cursor-pointer rounded-full text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                            aria-label="Inscription">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 12L18 12M12 6L12 18" />
                            </svg>
                        </button>
                    </h3>
                    <div class="flex flex-col gap-2.5 m-1">
                        {{-- Affichage de chacuns des postes pour le jour --}}
                        @for ($i = 0; $i < 4; $i++)
                            <div id="week__{{ $index }}__{{ $i }}"
                                class="week-job-{{ $i }} flex flex-row flex-wrap gap-1.5 empty:hidden">
                            </div>
                        @endfor
                    </div>
                </section>
            @endforeach
        </div>
    </div>

    @php
        $date = date('Y-m-d');
        // Si l'on est le weekend
if (intval(date('w')) % 6 == 0) {
    $date = date('Y-m-d', strtotime('Monday next week'));
        }

    @endphp

    <script>
        const JOBS = ['Bar', 'Cuisine', 'Transit', 'Courses'];
        const calendarTitle = document.getElementById('calendar__title');
        const inscriptionForm = document.getElementById('inscriptionDialog__form');

        var scope = "month",
            currentDate = new Date("{{ $date }}"),
            selectedDay = undefined,
            planning = {};


        function dateSQLFormat(date) {
            return `${date.getYear() + 1900}-${(date.getMonth()+1).toString().padStart(2, '0')}-${(date.getDate()).toString().padStart(2, '0')}`
        }

        document.getElementById('next-month').addEventListener('click', () => {
            let month = currentDate.getMonth();

            // Remets le jour au 1er du mois
            currentDate.setDate(1);
            if (month == 11) {
                currentDate.setMonth(0);
                currentDate.setYear(currentDate.getYear() + 1901);
            } else currentDate.setMonth(month + 1);

            // Va chercher le 1er jour de semaine du mois
            while (currentDate.getDay() % 6 == 0) currentDate.setDate(currentDate.getDate() + 1);

            // Récupère les nouvelles données à afficher
            fetchCalendar();
        });

        document.getElementById('prev-month').addEventListener('click', () => {
            let month = currentDate.getMonth();

            // Remets le jour au 1er du mois
            currentDate.setDate(1);
            if (month == 0) {
                currentDate.setMonth(11);
                currentDate.setYear(currentDate.getYear() + 1899);
            } else currentDate.setMonth(month - 1);

            // Va chercher le 1er jour de semaine du mois
            while (currentDate.getDay() % 6 == 0) currentDate.setDate(currentDate.getDate() + 1);

            // Récupère les nouvelles données à afficher
            fetchCalendar();
        });

        // On fait un fetch au lieu d'un form submit pour éviter de devoir recharger la page (moins smooth)
        inscriptionForm.addEventListener('submit', e => {
            e.preventDefault();
            document.getElementById('inscriptionDialog').close();

            // Récupération des infos du form
            const formData = new FormData(inscriptionForm);

            // Poste l'inscription, et récupère les nouvelles données d'inscriptions
            fetch('planning/ajouter-inscription', {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            }).then(r => r.json()).then(updateCalendar);
        })

        function selectDay(day) {
            let e = document.getElementById(day);

            // Si l'on sélectionne le même jour, pas besoin d'update. Idem si le jour est invalide
            if (e == selectDay || e == undefined) return;

            // Change le jour sélectionné
            if (selectedDay != undefined) selectedDay.classList.remove('selected');
            selectedDay = e;
            selectedDay.classList.add('selected');

            // Met à jour la date sélectionnée
            currentDate = new Date(day);

            // Met à jour le contenu du détail du jour
            for (let job in planning[day]) {
                let html = '';
                for (let index in planning[day][job]) {
                    html += `<span class="p-0.5 text-lg flex flex-row gap-2">${planning[day][job][index].nom}`;
                    if (planning[day][job][index].numeroCompte == {{ Auth::id() }} || {{ Auth::user()->acces }} == 3)
                        html += `<img class="w-7 cursor-pointer hover:bg-gray-700 rounded-lg px-1 py-1"
                            onclick="showDeleteDialog('${day}', ${job}, ${index})"
                                src="{{ asset('images/icons/delete.svg') }}" />`;
                    html += '</span>';
                }
                if (html == '') html = '<span class="text-gray-500 w-full text-xl">Personne !</span>';
                document.getElementById('day__' + job).innerHTML = html;
            }

            // Met la date au début de la semaine sélectionnée
            let weekDate = new Date(currentDate);
            weekDate.setDate(weekDate.getDate() - weekDate.getDay());

            // Itère à travers tous les jours ouvrés de la semaine
            for (let i = 0; i < 5; i++) {
                weekDate.setDate(weekDate.getDate() + 1);
                let day = dateSQLFormat(weekDate);

                // Ajoute les gens inscrits aux postes ce jour là
                for (let job in planning[day]) {
                    let html = '';
                    for (let index in planning[day][job]) {
                        html += `<span class="px-2.5 py-0.5 rounded-full">${planning[day][job][index].nom}</span>`;
                    }
                    document.getElementById('week__' + i + '__' + job).innerHTML = html;
                }

                // Met à jour la date du bouton d'inscription de ce jour
                document.getElementById('week__inscription__' + i).onclick = showInscriptionDialog.bind(null, 0, day);
            }
        }

        function setDisplayMode(day) {
            if (!day)
                document.getElementById('planningWrapper').classList.remove('day');
            else
                document.getElementById('planningWrapper').classList.add('day');
        }

        function deleteInscription() {
            // Ferme le dialogue
            document.getElementById('deleteDialog').close();

            // Requête de suppression de l'inscription + récupération des nouvelles données pour le mois
            fetch('planning/supprimer-inscription/' + document.getElementById('deleteDialog__id').value + '/' +
                dateSQLFormat(currentDate), {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    method: 'DELETE',
                    credentials: 'same-origin',
                }).then(r => r.json()).then(updateCalendar);
        }

        function fetchCalendar() {
            document.getElementById('calendar__inner').innerHTML = '<span>Loading...</span>';

            calendarTitle.innerText = currentDate.toLocaleString('fr-FR', {
                year: '2-digit',
                month: 'long'
            });

            let month = currentDate.getMonth(),
                // L'année retournée est relative à 1900, donc 125 pour 2025 par exemple
                year = currentDate.getYear() + 1900,
                // En JS, les mois commencent à 0. En PHP, à 1. On rajoute donc 1 pour la conversion entre les 2
                dateString = `${year}-${(month+1).toString().padStart(2, '0')}-01`;

            // Va chercher les données, puis update l'affichage une fois les données récupérées
            fetch(window.location.pathname + '/data/' + dateString).then(r => r.json()).then(updateCalendar);
        }

        function updateCalendar(data) {
            planning = data;

            const trStart = '<tr class="rounded-2xl p-5">';
            let html = trStart,
                i = 0;

            // Itération à travers les clés (dates)
            for (let day in data) {
                const reservations = data[day],
                    date = new Date(day),
                    inCurrentMonth = date.getMonth() == currentDate.getMonth();

                // 4 postes différents : 1 pastille pour chaque poste, représentant le nombre de personnes inscrites dans ce poste au jour donné
                let jobs = "";
                for (let job in reservations) jobs +=
                    `<span class="text-xs px-1.5 py-0.5 rounded-full job-${job + (reservations[job].length == 0 ? ' opacity-30' : '')}">${reservations[job].length}</span>`;

                html += `<td id="${day}" onclick="selectDay(this.id)" class="p-1.5 select-none rounded-xl text-lg text-center
                    ${!inCurrentMonth ? 'brightness-50 pointer-events-none' : 'hover:bg-gray-700 cursor-pointer'}" >
                        ${parseInt(day.slice(-2))}
                        <div class="grid-cols-2 grid-rows-2 grid gap-1">
                            ${jobs}
                            </div>
                        </td>`;

                i++;
                // Toutes les semaines, nouvelle ligne
                // Seulement 5 jours, car aucun service le weekend
                if (i == 5) {
                    i = 0;
                    html += '</tr>' + trStart;
                }
            }
            html += '</tr>';

            // Applique les changements
            document.getElementById('calendar__inner').innerHTML = html;

            // Met à jour l'affichage détaillé du jour
            selectDay(dateSQLFormat(currentDate));
        }

        function showDeleteDialog(day, job, index) {
            document.getElementById('deleteDialog__id').value = planning[day][job][index].id;
            document.getElementById('deleteDialog__name').innerHTML = planning[day][job][index].nom;
            document.getElementById('deleteDialog__job').innerHTML = JOBS[job];
            document.getElementById('deleteDialog__date').innerHTML = day;
            document.getElementById('deleteDialog').show();
        }

        function showInscriptionDialog(job, newDate) {
            let inscriptionDate = newDate == undefined ? currentDate : new Date(newDate);

            if (job != undefined && job >= 0 && job <= 4) document.getElementById('inscriptionDialog__job').value = job;
            let dateString = dateSQLFormat(inscriptionDate);
            // Met à jour les données et l'affichage du form d'inscription
            document.getElementById('inscriptionDialog__dateDisplay').innerHTML = dateString;
            document.getElementById('inscriptionDialog__date').value = dateString;

            // Affiche le form d'inscription
            document.getElementById('inscriptionDialog').show();
        }

        fetchCalendar();
    </script>

    @include('footer')
</body>

</html>
