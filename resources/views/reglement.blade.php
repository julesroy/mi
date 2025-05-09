<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Réglement</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36 ml-8 mr-8">
        @include('header')

        <h1 class="my-8 text-center text-4xl font-bold">Charte d’Utilisation de la Maison ISEN</h1>
        <div class="mx-auto w-auto h-0.5 bg-white"></div>
        <div class="my-8">
            <p class="w-full max-w-full">Bienvenue dans la MI, un espace de détente, de partage et de convivialité mis à votre disposition. Pour que chacun puisse en profiter dans les meilleures conditions, merci de respecter les règles suivantes :</p>
        </div>
        <div class="mx-auto w-auto h-0.5 bg-white"></div>

        <div class="my-8">
            <h2 class="text-2xl underline mb-8">Respect de l’espace et du matériel</h2>
            <span class="w-full max-w-full">
                <ul class="list-disc pl-6">
                    <li>Le matériel (billard, baby-foot, air-hockey, etc.) doit être utilisé avec soin.</li>
                    <li>Toute dégradation pourra entraîner une sanction ou un remboursement.</li>
                    <li>Merci de ranger le matériel après usage (queues de billard, balles, etc.).</li>
                    <li>Les tables sont à disposition pour manger. Merci de nettoyer votre table après usage.</li>
                    <li>Ne pas laisser trainer ses affaires. Merci de récupérer vos affaires personnelles au plus vite en cas d'oubli.</li>
                </ul>
            </span>
        </div>

        <div class="my-8">
            <h2 class="text-2xl underline mb-8">Respect des autres et du personnel</h2>
            <span class="w-full max-w-full">
                <ul class="list-disc pl-6">
                    <li>Le niveau sonore (discussions, jeux etc…) doit toujours rester raisonnable.</li>
                    <li>Vous avez la possibilité d’acheter des boissons et des snacks à tout moment, ainsi que de commander un repas lors de la pause méridienne.</li>
                    <li>Seuls les membres de la Par’MI’Giano sont aptes à vous servir.</li>
                    <li>Il est strictement interdit de se servir dans les stocks ou de rentrer dans la cuisine.</li>
                    <li>Merci d’être respectueux envers les membres de la Par’MI’Giano, nous rappelons qu’ils restent avant tout des bénévoles !</li>
                </ul>
            </span>
        </div>

        <div class="my-8">
            <h2 class="text-2xl underline mb-8 max-w-full">Signalement et gestion des incidents</h2>
            <span class="w-full max-w-full">
                <ul class="list-disc pl-6">
                    <li>Tout incident ou problème technique doit être signalé à un membre de la Par’MI’Giano.</li>
                    <li>En cas de non-respect de cette charte, des sanctions peuvent être prises (avertissement, exclusion temporaire ou définitive du foyer).</li>
                </ul>
            </span>
        </div>

        <div class="my-8">
            <p class="w-full max-w-full">
                En accédant au foyer, vous vous engagez à respecter cette charte.
                <br />
                <br />
                Merci pour votre coopération !
                <br />
                <br />
            </p>
        </div>
        @include('footer')
    </body>
</html>
