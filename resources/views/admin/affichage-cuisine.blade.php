<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        @include("head")
        <title>Affichage de la cuisine</title>
    </head>

    <body class="bg-[#0a0a0a] text-white h-screen flex flex-col">
        <!-- Conteneur principal -->
        <div class="flex flex-col flex-grow bg-gray-100">
            <!-- Barre supérieure avec l'heure -->
            <div class="flex items-center justify-center bg-gray-800 text-white px-6 py-3">
                <!-- Timer -->
                <span id="heureActuelle" class="font-mono text-xl"></span>
            </div>

            <!-- Barre de statut -->
            <div class="flex h-12 bg-gray-200">
                <div class="flex-[1] bg-blue-500 text-white flex items-center justify-center font-bold">Plats froids</div>
                <div class="flex-[1] bg-yellow-500 text-white flex items-center justify-center font-bold">Hot-dogs</div>
                <div class="flex-[2] bg-red-500 text-white flex items-center justify-center font-bold">Plats chauds</div>
            </div>

            <!-- Zone principale d'affichage -->
            <div class="flex flex-1 bg-white text-black text-center border-t border-gray-300">
                <!-- Section des plats froids -->
                <div class="w-1/4 p-4 border-r border-gray-300">
                    <ul id="affichageFroids" class="space-y-2"></ul>
                </div>

                <!-- Section des hot-dogs -->
                <div class="w-1/4 p-4 border-r border-gray-300">
                    <ul id="affichageHotdogs" class="space-y-2"></ul>
                </div>

                <!-- Section des plats chauds -->
                <div class="w-2/4 p-4">
                    <ul id="affichageChauds" class="space-y-2"></ul>
                </div>
            </div>
        </div>

        <!-- Script pour l'affichage de l'heure -->
        <script>
            const MENUS = {
                0: 'Pas de menu',
                ...@json($menus),
            };

            function mettreAJourHeure() {
                const maintenant = new Date();
                document.getElementById('heureActuelle').textContent = maintenant.toLocaleTimeString('fr-FR', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                });
            }

            function updateCommandes() {
                fetch('/admin/affichage-cuisine/data')
                    .then((r) => r.json())
                    .then((commandes) => {
                        console.log(commandes);

                        let froids = '',
                            chauds = '',
                            hotdogs = '';

                        commandes.forEach((commande) => {
                            let html = `<li class="bg-gray-100 p-2 rounded shadow">
                            <p><strong>Commande #${commande.numeroCommande}</strong></p>
                            <p>${MENUS[commande.menu]}</p>
                            <ul>`;

                            for (let item of commande.items) {
                                html += `<li>
                            ${item.quantite} &times; ${item.nom} ${item.optionnel ? '' : ''}
                        </li>`;
                            }

                            html += `</ul>
                            <p><small>${commande.commentaire}</small></p>
                        </li>`;

                            if (commande.categorieCommande == 0) froids += html;
                            else if (commande.categorieCommande == 1) hotdogs += html;
                            else if (commande.categorieCommande == 2) chauds += html;
                        });

                        document.getElementById('affichageFroids').innerHTML = froids;
                        document.getElementById('affichageHotdogs').innerHTML = hotdogs;
                        document.getElementById('affichageChauds').innerHTML = chauds;
                    });
            }

            // Met à jour l'affichage des commandes toutes les 2 secondes
            setInterval(updateCommandes, 2000);
            updateCommandes();

            // Met à jour l'heure toutes les secondes
            setInterval(mettreAJourHeure, 1000);
            mettreAJourHeure();
        </script>
    </body>
</html>
