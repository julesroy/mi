<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Gestion stocks</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36">
        @include('header')

        @include('header')

        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Gestions des stocks</h1>

            <form method="GET" action="{{ url()->current() }}" class="min-w-full text-black p-2 mb-4 bg-white flex flex-wrap gap-4 items-end border-4 border-gray-500">
                <div>
                    <label for="nom" class="block text-sm">Nom</label>
                    <input type="text" name="nom" id="nom" value="{{ request('nom') }}" class="border-1 border-black bg-gray-100 rounded p-1" />
                </div>
                <div>
                    <label for="categorie" class="block text-sm">Catégorie</label>
                    <input type="text" name="categorie" id="categorie" value="{{ request('categorie') }}" class="border-1 border-black bg-gray-100 rounded p-1" />
                </div>
                <div>
                    <label for="etat" class="block text-sm">État</label>
                    <select name="etat" id="etat" class="border-1 border-black bg-gray-100 rounded p-1">
                        <option value="">Tous</option>
                        <option value="0" @if(request('etat')==='0') selected @endif>Fermé</option>
                        <option value="1" @if(request('etat')==='1') selected @endif>Ouvert</option>
                        <option value="2" @if(request('etat')==='2') selected @endif>Périmé</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-700 text-white px-4 py-1 rounded hover:bg-blue-800">Filtrer</button>
                <a href="{{ url()->current() }}" class="ml-2 text-sm text-blue-400 underline">Réinitialiser</a>
            </form>

            <div class="overflow-x-auto">
                <p class="mb-2 text-sm text-gray-400">
                    Trié par
                    <span class="font-semibold text-white">
                        @switch($sort)
                            @case('nom')
                                Nom

                                @break
                            @case('categorieElement')
                                Catégorie

                                @break
                            @case('numeroLot')
                                Lot

                                @break
                            @case('datePeremption')
                                Date péremption

                                @break
                            @case('nombrePortions')
                                Portions

                                @break
                            @case('dateOuverture')
                                Ouverture

                                @break
                            @case('dateFermeture')
                                Fermeture

                                @break
                            @case('etat')
                                État

                                @break
                            @default
                                {{ $sort }}
                        @endswitch
                    </span>
                    ({{ $direction === 'asc' ? 'croissant' : 'décroissant' }})
                </p>

                <table class="min-w-full bg-white text-black rounded shadow">
                    @php
                        // Pour afficher la flèche de tri
                        function sort_arrow($column, $sort, $direction)
                        {
                            if ($column !== $sort) {
                                return '';
                            }
                            return $direction === 'asc' ? '▲' : '▼';
                        }
                    @endphp

                    <thead>
                        <tr class="bg-gray-700">
                            <th class="py-2 px-4 border-b">
                                <a href="{{
                                    request()->fullUrlWithQuery([
                                        'sort' => 'nom',
                                        'direction' => $sort === 'nom' && $direction === 'asc' ? 'desc' : 'asc',
                                    ])
                                }}" class="flex items-center gap-1">Nom {!! sort_arrow('nom', $sort, $direction) !!}</a>
                            </th>
                            <th class="py-2 px-4 border-b">
                                <a href="{{
                                    request()->fullUrlWithQuery([
                                        'sort' => 'categorieElement',
                                        'direction' => $sort === 'categorieElement' && $direction === 'asc' ? 'desc' : 'asc',
                                    ])
                                }}" class="flex items-center gap-1">Catégorie {!! sort_arrow('categorieElement', $sort, $direction) !!}</a>
                            </th>
                            <th class="py-2 px-4 border-b">
                                <a href="{{
                                    request()->fullUrlWithQuery([
                                        'sort' => 'numeroLot',
                                        'direction' => $sort === 'numeroLot' && $direction === 'asc' ? 'desc' : 'asc',
                                    ])
                                }}" class="flex items-center gap-1">Lot {!! sort_arrow('numeroLot', $sort, $direction) !!}</a>
                            </th>
                            <th class="py-2 px-4 border-b">
                                <a href="{{
                                    request()->fullUrlWithQuery([
                                        'sort' => 'datePeremption',
                                        'direction' => $sort === 'datePeremption' && $direction === 'asc' ? 'desc' : 'asc',
                                    ])
                                }}" class="flex items-center gap-1">Date péremption {!! sort_arrow('datePeremption', $sort, $direction) !!}</a>
                            </th>
                            <th class="py-2 px-4 border-b">
                                <a href="{{
                                    request()->fullUrlWithQuery([
                                        'sort' => 'nombrePortions',
                                        'direction' => $sort === 'nombrePortions' && $direction === 'asc' ? 'desc' : 'asc',
                                    ])
                                }}" class="flex items-center gap-1">Portions {!! sort_arrow('nombrePortions', $sort, $direction) !!}</a>
                            </th>
                            <th class="py-2 px-4 border-b">
                                <a href="{{
                                    request()->fullUrlWithQuery([
                                        'sort' => 'dateOuverture',
                                        'direction' => $sort === 'dateOuverture' && $direction === 'asc' ? 'desc' : 'asc',
                                    ])
                                }}" class="flex items-center gap-1">Ouverture {!! sort_arrow('dateOuverture', $sort, $direction) !!}</a>
                            </th>
                            <th class="py-2 px-4 border-b">
                                <a href="{{
                                    request()->fullUrlWithQuery([
                                        'sort' => 'dateFermeture',
                                        'direction' => $sort === 'dateFermeture' && $direction === 'asc' ? 'desc' : 'asc',
                                    ])
                                }}" class="flex items-center gap-1">Fermeture {!! sort_arrow('dateFermeture', $sort, $direction) !!}</a>
                            </th>
                            <th class="py-2 px-4 border-b">
                                <a href="{{
                                    request()->fullUrlWithQuery([
                                        'sort' => 'etat',
                                        'direction' => $sort === 'etat' && $direction === 'asc' ? 'desc' : 'asc',
                                    ])
                                }}" class="flex items-center gap-1">État {!! sort_arrow('etat', $sort, $direction) !!}</a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($stocks as $stock)
                            @php
                                // Détermine la couleur de fond selon l'état
                                $bgColor = match ($stock->etat) {
                                    0 => 'bg-green-200', // Fermé
                                    1 => 'bg-blue-200', // Ouvert
                                    2 => 'bg-red-500', // Périmé
                                    default => 'bg-gray-200', // Inconnu
                                };
                            @endphp

                            <tr class="{{ $bgColor }}">
                                <td class="py-2 px-4 border-b">{{ $stock->nom }}</td>
                                <td class="py-2 px-4 border-b">{{ $stock->categorieElement }}</td>
                                <td class="py-2 px-4 border-b">{{ $stock->numeroLot }}</td>
                                <td class="py-2 px-4 border-b">{{ $stock->datePeremption }}</td>
                                <td class="py-2 px-4 border-b">{{ $stock->nombrePortions }}</td>
                                <td class="py-2 px-4 border-b">{{ $stock->dateOuverture }}</td>
                                <td class="py-2 px-4 border-b">{{ $stock->dateFermeture }}</td>
                                <td class="py-2 px-4 border-b text-black font-semibold">
                                    @if ($stock->etat == 0)
                                        Fermé
                                    @elseif ($stock->etat == 1)
                                        Ouvert
                                    @elseif ($stock->etat == 2)
                                        Périmé
                                    @else
                                        Inconnu
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @include('footer')
    </body>
</html>
