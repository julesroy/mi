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
                fetch('planning/supprimer-inscription', {
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    method: 'POST',
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        idInscription,
                    }),
                }).then(() => window.location.reload());
            }
        </script>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include('header')

        <span class="flex-row flex gap-2.5 m-2.5">
            <label>Période :</label>
            <button class="hover:underline cursor-pointer {{ $scope == 'day' ? 'underline' : '' }}" onclick="updateSearchParams('scope','day')">Jour</button>
            <button class="hover:underline cursor-pointer {{ $scope == 'week' ? 'underline' : '' }}" onclick="updateSearchParams('scope','week')">Semaine</button>
            <button class="hover:underline cursor-pointer {{ $scope == 'month' ? 'underline' : '' }}" onclick="updateSearchParams('scope','month')">Mois</button>
        </span>

        <span class="flex-row flex gap-2.5 m-2.5">
            <label>Date :</label>
            <input class="border border-white" type="date" value="{{ $date }}" onchange="updateSearchParams('date',this.value)" />
        </span>

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
                <?php foreach ($planning as $inscription) {
                     ?>

                <tr class="even:bg-gray-800">
                    <td>
                        {{ $inscription->date }}
                    </td>
                    <td>
                        {{ $inscription->prenom . ' ' . $inscription->nom }}
                    </td>
                    <td>
                        <?php
                        switch ($inscription->poste) {
                            case 0:
                                echo 'Devant';
                                break;
                            case 1:
                                echo 'Derrière';
                                break;
                            case 2:
                                echo 'Transit';
                                break;
                            case 3:
                                echo 'Courses Match';
                                break;

                            default:
                                echo 'Erreur poste';
                        }
                        ?>
                    </td>
                    <td>
                        <?php if($acces == 3 || $userId == $inscription->numeroCompte){ ?>

                        <button class="cursor-pointer border-none m-auto" onclick="deleteInscription({{ $inscription->idInscription }})">Suppr</button>

                        <?php } ?>
                    </td>
                </tr>

                <?php } ?>
            </tbody>
        </table>

        @include('footer')
    </body>
</html>
