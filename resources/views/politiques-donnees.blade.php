<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
        <title>Politiques données personnelles</title>
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-36 mr-8 ml-8">
        @include('header')
        <h1 class="my-8 text-center text-4xl font-bold">Politiques de données personnelles</h1>
        <div class="mx-auto w-auto h-0.5 bg-white"></div>
        <div class="my-8">
            <p class="w-full max-w-full">
                Est considérée comme donnée personnelle toute information se rapportant à une personne physique identifiée ou identifiable, directement ou indirectement.
                <br />
                Le responsable de traitement est l’Association Maison ISEN, Association dont le siège social est situé 41 boulevard Vauban Lille (SIRET 783 707 003 00027).
                <br />
                <br />
                Dans le cadre de l’utilisation du site Internet www.maisonisen.fr l’association Maison ISEN peut être amenée à récolter vos données personnelles aux fins suivantes :
                <br />
            </p>
            <ul class="list-disc pl-6">
                <li>
                    Dans le cadre de la navigation du site : analyses statistiques ;
                    <br />
                </li>
                <li>
                    Dans le cadre du remplissage du formulaire de commande ;
                    <br />
                </li>
                <li>
                    Dans le cadre de la création d'un compte sur le site ;
                    <br />
                    <br />
                </li>
            </ul>
            Ni Maison ISEN, ni l’un quelconque de ses sous-traitants, ne procèdent à la commercialisation de vos données personnelles.
            <br />
        </div>
        <div class="mx-auto w-auto h-0.5 bg-white"></div>

        <div class="my-8">
            <h2 class="text-2xl underline mb-8">Nature des données recoltées</h2>
            <p class="w-full max-w-full">
                La nature des données personnelles récoltées dépend de la finalité du traitement.
                <br />
                <br />
                A l’occasion de l’utilisation du site www.maisonisen.fr, peuvent être recueillies les données personnelles suivantes : nom, prénom, adresse e-mail, numéro de compte MI.
                <br />
                <br />
                L'association Maison ISEN s’engage à ne récolter que les données personnelles et suffisantes à cet égard. Seules les données signalées par un astérisque sur les formulaires de collecte sont obligatoires.
                <br />
                <br />
                Seule l'association Maison ISEN est destinataire de vos données personnelles.
                <br />
                <br />
                Celles-ci, que ce soit sous forme individuelle ou agrégée, ne sont jamais transmises à un tiers, nonobstant les sous-traitants auxquels l'association Maison ISEN fait appel.
                <br />
                <br />
            </p>
        </div>

        <div class="my-8">
            <h2 class="text-2xl underline mb-8">Temps de conservation des données collectées</h2>
            <p class="w-full max-w-full">
                Vos données personnelles sont conservées par l'association Maison ISEN uniquement pour le temps correspondant à la finalité de la collecte.
                <br />
                <br />
                Conformément à la réglementation en vigueur, vous disposez des droits suivants :
                <br />
            </p>
            <ul class="list-disc pl-6">
                <li>
                    Droit d’accès : Vous disposez de la faculté d’accéder aux données personnelles vous concernant ;
                    <br />
                </li>
                <li>
                    Droit de rectification ou d’effacement : vous pouvez demander la rectification, la mise à jour, le verrouillage, ou encore l’effacement des données personnelles vous concernant qui peuvent s’avérer le cas échéant inexactes, erronées, incomplètes ou obsolètes ;
                    <br />
                </li>
                <li>
                    Droit d’effacement : vous pouvez demander l’effacement des données personnelles vous concernant ;
                    <br />
                </li>
                <li>
                    Droit de limitation : vous pouvez demander la limitation des données personnelles vous concernant ;
                    <br />
                </li>
                <li>
                    Droit de retirer votre consentement à un traitement de vos données personnelles ;
                    <br />
                </li>
                <li>
                    Droit à la portabilité : vous pouvez demander à recevoir les données personnelles vous concernant dans un format structuré, couramment utilisé et lisible par machine ;
                    <br />
                </li>
                <li>
                    Droit d’opposition : dans certaines conditions, vous pouvez dans certains cas vous opposer au traitement des Données personnelles vous concernant ;
                    <br />
                </li>
                <li>
                    Droit d’introduire une réclamation auprès d’une autorité de contrôle (la CNIL pour la France).
                    <br />
                    <br />
                </li>
            </ul>
            Vous pouvez également définir des directives générales et particulières relatives au sort des données à caractère personnel après votre décès. Le cas échéant, les héritiers d’une personne décédée peuvent exiger de prendre en considération le décès de leur proche et/ou de procéder aux mises à jour nécessaires.
            <br />
            <br />
        </div>

        <div class="my-8">
            <h2 class="text-2xl underline mb-8 max-w-full">Exercer vos droits</h2>
            <p class="w-full max-w-full">
                Vous pouvez exercer ces droits de la manière suivante :
                <br />
                <br />
                Ce droit peut être exercé par voie postale auprès de Maison ISEN, 41 boulevard Vauban, 59800 Lille, ou par voie électronique à l’adresse email suivante: lamaisonisen
                @gmail.com.
                <br />
                <br />
                Votre demande sera traitée sous réserve que vous apportiez la preuve de votre identité, notamment par la production d’un scan de votre titre d’identité valide ou d’une photocopie signée de votre titre d’identité valide (en cas de demande adressée par écrit).
                <br />
                Maison ISEN vous informe qu’il sera en droit, le cas échéant, de s’opposer aux demandes manifestement abusives (nombre, caractère répétitif ou systématique).
                <br />
                Maison ISEN s’engage à vous répondre dans un délai raisonnable qui ne saurait dépasser 1 mois à compter de la réception de votre demande.
                <br />
                <br />
            </p>
        </div>

        @include('footer')
    </body>
</html>
