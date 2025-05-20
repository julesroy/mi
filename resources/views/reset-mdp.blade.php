<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('head')
    <title>Le nom de votre page</title>
</head>

<body class="bg-white pt-28 md:pt-45 min-h-screen flex flex-col">
    @include('header')

    <main class="flex-1 flex flex-col items-center justify-center">
        <form id="resetForm" method="POST" action="./" class="rounded-2xl border border-black p-5 [&_input]:font-sans flex items-center flex-col">
            @csrf
            <input type="hidden" value="{{ $token }}" />

            <div>
                <label for="email" class="block text-lg font-medium">Email</label>
                <div>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email"
                        required
                        class="block w-full rounded-[100px] bg-white px-4 py-2.5 text-lg text-gray-900 border-2 border-black placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('nom') border-red-500 @enderror" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password" class="block text-lg font-medium">Nouveau mot de passe</label>
                <div>
                    <input type="text" name="password" id="password" value="{{ old('password') }}"
                        autocomplete="new-password" required
                        class="block w-full rounded-[100px] bg-white px-4 py-2.5 text-lg text-gray-900 border-2 border-black placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('nom') border-red-500 @enderror" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-lg font-medium">Confirmer mot de passe</label>
                <div>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        value="{{ old('password_confirmation') }}" autocomplete="new-password" required
                        class="block w-full rounded-[100px] bg-white px-4 py-2.5 text-lg text-gray-900 border-2 border-black placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('nom') border-red-500 @enderror" />
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <input type="submit" value="Confirmer" class="cursor-pointer bg-primaire text-white px-3 py-2 rounded-full border-1 border-black mt-5"/>
        </form>
    </main>

    @include('footer')
</body>

</html>
