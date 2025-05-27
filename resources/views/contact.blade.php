<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        @include("head")
        <title>Contact</title>
    </head>

    <body class="bg-white pt-28 md:pt-60 min-h-screen flex flex-col">>
        @include("header")
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 md:px-10 py-6 border-2 border-black rounded-lg bg-white shadow-lg mb-20">

                <div class="relative mb-6 pb-4 border-b border-black">
                    <h1 class="text-4xl font-bold text-center">Contact</h1>
                    </span>
                    @can("verifier-acces-administrateur")
                    <!-- <a href="/admin/gestion-contact" class="absolute right-0 top-1/2 transform -translate-y-1/2 hover:opacity-75">
                        <img src="{{ asset('images/icons/admin_parameter.png') }}" alt="Gestion carte" class="w-12 h-12 inline-block" />
                    </a> -->
                    @endcan
                </div>

                @php
                    $onglet = request()->get('onglet', 'equipe'); // valeur par défaut = 'equipe'
                @endphp

                <!-- BOUTONS -->
                <div class="flex justify-center gap-6 mb-10">
                    <a href="?onglet=contact"
                       class="px-6 py-2 rounded-full transition duration-300
                              {{ $onglet === 'contact' ? 'bg-secondaire text-white' : 'bg-primaire text-white hover:bg-secondaire' }}">
                        Nous contacter
                    </a>

                    <a href="?onglet=equipe"
                       class="px-6 py-2 rounded-full transition duration-300
                              {{ $onglet === 'equipe' ? 'bg-secondaire text-white' : 'bg-primaire text-white hover:bg-secondaire' }}">
                        Notre équipe
                    </a>

                    <a href="?onglet=rejoindre"
                       class="px-6 py-2 rounded-full transition duration-300
                              {{ $onglet === 'rejoindre' ? 'bg-secondaire text-white' : 'bg-primaire text-white hover:bg-secondaire' }}">
                        Nous rejoindre
                    </a>
                </div>

                <!-- CONTENUS -->
                <!-- Onglet contact (formulaire + adresse) -->
                @if ($onglet === 'contact')
                    <div class="space-y-6">
                        <div class="text-center">
                            <p class="text-lg font-medium">
                            Maison ISEN </br>
                            IC2, salle B108 (sous-sol) </br>
                            41 boulevard Vauban, 59800 Lille, FRANCE </br></br>
                            lamaisonisen@gmail.com </br>
                            <a href="https://www.instagram.com/maisonisen/" target="_blank" class="hover:opacity-75">
                                <img src="{{ asset("images/icons/logo_insta_b.svg") }}" alt="Instagram" class="w-8 h-8 inline-block" />
                             </a>
                            <a href="https://www.linkedin.com/company/maison-isen/" target="_blank" class="hover:opacity-75">
                                <img src="{{ asset("images/icons/logo_linkedin_b.svg") }}" alt="LinkedIn" class="w-8 h-8 inline-block" />
                            </a>
                            </br>
                            </p>
                        </div>
                        <form method="POST" action="/contact"class="grid grid-cols-1 md:grid-cols-2 gap-6 border border-black bg-gray-100 p-6 rounded-[13px] shadow text-base">
                           @csrf
                        
                           <div class="flex flex-col">
                               <label for="nom" class="mb-1 font-semibold">Nom</label>
                               <input id="nom" type="text" name="nom" class="p-3 rounded border rounded-[13px] border-black" />
                           </div>
                        
                           <div class="flex flex-col">
                               <label for="prenom" class="mb-1 font-semibold">Prénom</label>
                               <input id="prenom" type="text" name="prenom" class="p-3 rounded border rounded-[13px] border-black" />
                           </div>
                        
                           <div class="flex flex-col md:col-span-2">
                               <label for="email" class="mb-1 font-semibold">Adresse e-mail</label>
                               <input id="email" type="email" name="email" class="p-3 rounded border rounded-[13px] border-black" />
                           </div>
                        
                           <div class="flex flex-col md:col-span-2">
                               <label for="sujet" class="mb-1 font-semibold">Sujet</label>
                                    <select id="objet" name="objet" class="p-3 rounded border rounded-[13px] bg-primaire text-white hover:bg-secondaire">
                                    <option class="bg-white text-black" value="allergenes">Compte</option>
                                    <option class="bg-white text-black" value="questions">Allergènes</option>
                                    <option class="bg-white text-black" value="autre">Autre</option>
                               </select>

                           </div>
                        
                           <div class="flex flex-col md:col-span-2">
                               <label for="objet" class="mb-1 font-semibold">Objet</label>
                               <input id="sujet" type="text" name="sujet" class="p-3 rounded border rounded-[13px] border-black" />
                           </div>
                        
                           <div class="flex flex-col md:col-span-2">
                               <label for="message" class="mb-1 font-semibold">Votre message</label>
                               <textarea id="message" name="message" rows="5" class="p-3 rounded border rounded-[13px] border-black"></textarea>
                           </div>
                        
                           <button type="submit"
                                   class="bg-primaire hover:bg-secondaire text-white py-2 px-4 rounded-[13px]  md:col-span-2">
                               Envoyer
                           </button>
                        </form>

                    </div>
                <!-- Onglet équipe (nom membres + fonction) -->
                @elseif ($onglet === 'equipe')
                    <div class="flex justify-center flex-wrap gap-10">
                        <div class="text-center">
                            <p class="font-bold">Chef de projet</p>
                            <p class="font-bold">Jules Roy</p>
                            <p>Front-end</p>
                            <p>Back-end</p>
                        </div>
                        <div class="text-center">
                            <p class="font-bold">Développeuse</p>
                            <p class="font-bold">Adèle Lebrun</p>
                            <P>Direction artistique</p>
                            <p>Front-end</p>
                        </div>
                        <div class="text-center">
                            <p class="font-bold">Développeur</p>
                            <p class="font-bold">Simon Leroy</p>
                            <p>Front-end</p>
                        </div>
                        <div class="text-center">
                            <p class="font-bold">Développeur</p>
                            <p class="font-bold">Théo Lesage</p>
                            <p>Front-end</p>
                        </div>
                        <div class="text-center">
                            <p class="font-bold">Développeur</p>
                            <p class="font-bold">Cem Durand</p>
                            <p>Front-end</p>
                        </div>
                        <div class="text-center">
                            <p class="font-bold">Développeur</p>
                            <p class="font-bold">Léo Lewandoski</p>
                            <p>Back-end</p>
                        </div>
                        <div class="text-center">
                            <p class="font-bold">Développeur</p>
                            <p class="font-bold">Sasha Le Roux--Zielinski</p>
                            <p>Back-end</p>
                        </div>
                    </div>

                <!-- Onglet rejoindre (envoyer un mess insta/nous rencontrer au forum des assos) -->
                @elseif ($onglet === 'rejoindre')
                    <div class="text-center text-lg font-medium">
                        Envie de nous rejoindre ? N'hésite pas à envoyer un message à notre compte <a href="https://www.instagram.com/maisonisen/" target="_blank" class="hover:text-secondaire underline">Instagram<a>. </br></br>
                        Tu peux également nous rencontrer lors de ces occasions : </br></br>
                    </div>
                    <div class="text-center text-lg font-medium">
                        <p class="font-bold">Forum des associations JUNIA :<p>
                        <span>A venir (septembre/octobre 2025)</span>
                    </div>
                @endif


            </div>


        </main>
        @include("footer")
    </body>
</html>
