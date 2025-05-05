<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Inscription</title>
    </head>

    <body class="bg-[#0a0a0a] text-white">
        @include('header')

        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight">Inscription</h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                @if ($errors->any())
                    <div class="mb-4 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700" role="alert">
                        <strong class="font-bold">Oups !</strong>
                        <ul class="mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="space-y-6" action="/inscription" method="POST">
                    @csrf
                    <div>
                        <label for="nom" class="block text-sm/6 font-medium">Nom</label>
                        <div class="mt-2">
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" autocomplete="family-name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 @error('nom') border-red-500 @enderror" />
                            @error('nom')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="prenom" class="block text-sm/6 font-medium">Prénom</label>
                        <div class="mt-2">
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" autocomplete="given-name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 @error('prenom') border-red-500 @enderror" />
                            @error('prenom')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm/6 font-medium">Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 @error('email') border-red-500 @enderror" />
                            @error('email')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="mdp" class="block text-sm/6 font-medium">Mot de passe</label>
                        <div class="mt-2">
                            <input type="password" name="mdp" id="mdp" autocomplete="new-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 @error('mdp') border-red-500 @enderror" />
                            @error('mdp')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="mdp_confirmation" class="block text-sm/6 font-medium">Confirmer le mot de passe</label>
                        <div class="mt-2">
                            <input type="password" name="mdp_confirmation" id="mdp_confirmation" autocomplete="new-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Inscription</button>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm/6 text-gray-500">
                    Déjà un compte ?
                    <a href="{{ route('connexion') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Connexion</a>
                </p>
            </div>
        </div>

        @include('footer')
    </body>
</html>
