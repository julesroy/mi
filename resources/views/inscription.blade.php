<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Inscription</title>
    </head>

    <body class="bg-white text-black pt-28 md:pt-50">
        @include('header')

        <div class="flex min-h-full flex-col justify-center px-6 py-6 lg:px-8 items-center">
            <div class="border-4 border-black rounded-[13px] p-8 w-full max-w-md md:max-w-lg lg:max-w-xl">
                <div class="mx-auto w-full">
                    <h2 class="text-center text-3xl font-bold tracking-tight mb-3">Inscription</h2>
                </div>

                <div class="mx-auto w-full">
                    @if ($errors->any())
                        <div class="mb-6 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700" role="alert">
                            <strong class="font-bold">Oups !</strong>
                            <ul class="mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="space-y-2" action="/inscription" method="POST">
                        @csrf
                        <div>
                            <label for="nom" class="block text-lg font-medium">Nom</label>
                            <div>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" autocomplete="family-name" required class="block w-full rounded-[100px] bg-white px-4 py-2.5 text-lg text-gray-900 border-2 border-black placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('nom') border-red-500 @enderror" />
                                @error('nom')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="prenom" class="block text-lg font-medium">Prénom</label>
                            <div>
                                <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" autocomplete="given-name" required class="block w-full rounded-[100px] bg-white px-4 py-2.5 text-lg text-gray-900 border-2 border-black placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('prenom') border-red-500 @enderror" />
                                @error('prenom')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center ">
                                <label for="email" class="block text-lg font-medium">Email</label>
                                <span class="text-sm text-gray-500">email Junia uniquement</span>
                            </div>
                            <div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email" required class="block w-full rounded-[100px] bg-white px-4 py-2.5 text-lg text-gray-900 border-2 border-black placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('email') border-red-500 @enderror" />
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="mdp" class="block text-lg font-medium">Mot de passe</label>
                            <div>
                                <input type="password" name="mdp" id="mdp" autocomplete="new-password" required class="block w-full rounded-[100px] bg-white px-4 py-2.5 text-lg text-gray-900 border-2 border-black placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('mdp') border-red-500 @enderror" />
                                @error('mdp')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="mdp_confirmation" class="block text-lg font-medium">Confirmer le mot de passe</label>
                            <div>
                                <input type="password" name="mdp_confirmation" id="mdp_confirmation" autocomplete="new-password" required class="block w-full rounded-[100px] bg-white px-4 py-2.5 text-lg text-gray-900 border-2 border-black placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="reglement" id="reglement" required class="h-5 w-5 rounded border-2 border-black text-indigo-600 focus:ring-indigo-600">
                            </div>
                            <div class="ml-3 text-lg">
                                <label for="reglement" class="text-gray-900">J'ai lu et accepté le <a href="/reglement" class="font-semibold text-black underline hover:text-indigo-600">règlement</a></label>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="flex w-full justify-center rounded-[100px] bg-secondaire px-4 py-3 text-lg font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 transition-colors">
                                Inscription
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <p class="mt-6 text-center text-lg text-black">
                    Déjà un compte ?
                    <a href="{{ route('connexion') }}" class="font-semibold text-black underline hover:text-indigo-600">Connexion</a>
                </p>
        </div>

        @include('footer')
    </body>
</html>