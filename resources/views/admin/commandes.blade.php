<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        @include("head")
        <title>Affichage Cuisine - Commandes</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>

    <body class="bg-[#0a0a0a] text-white pt-28 md:pt-60">
        @include("header")

        <main class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-8 text-center">Commandes en Cuisine</h1>

            <!-- Barre de filtrage -->
            <div class="flex flex-wrap gap-2 mb-6 justify-center">
                <button onclick="filterCommandes('all')" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors">Toutes</button>
                <button onclick="filterCommandes(0)" class="px-4 py-2 bg-red-700 hover:bg-red-600 rounded-lg transition-colors">Non payées</button>
                <button onclick="filterCommandes(1)" class="px-4 py-2 bg-yellow-700 hover:bg-yellow-600 rounded-lg transition-colors">Payées</button>
                <button onclick="filterCommandes(2)" class="px-4 py-2 bg-blue-700 hover:bg-blue-600 rounded-lg transition-colors">Prêtes</button>
                <button onclick="filterCommandes(3)" class="px-4 py-2 bg-green-700 hover:bg-green-600 rounded-lg transition-colors">Servies</button>
                <button onclick="filterCommandes(4)" class="px-4 py-2 bg-gray-500 hover:bg-gray-400 rounded-lg transition-colors">Annulées</button>
            </div>

            <div id="commandesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="text-center py-10">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500 mx-auto"></div>
                    <p class="mt-4">Chargement des commandes...</p>
                </div>
            </div>
        </main>

        @include("footer")

        <style>
            .etat-0 {
                background-color: rgba(192, 57, 43, 0.2);
                color: #e74c3c;
            }
            .etat-1 {
                background-color: rgba(243, 156, 18, 0.2);
                color: #f39c12;
            }
            .etat-2 {
                background-color: rgba(41, 128, 185, 0.2);
                color: #3498db;
            }
            .etat-3 {
                background-color: rgba(39, 174, 96, 0.2);
                color: #2ecc71;
            }
            .etat-4 {
                background-color: rgba(127, 140, 141, 0.2);
                color: #95a5a6;
            }
            .commande-card {
                transition: all 0.3s ease;
            }
            .commande-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }
            .commande-test {
                border: 2px dashed #f39c12;
            }
            .disabled-btn {
                opacity: 0.5;
                cursor: not-allowed;
            }
            .filter-btn.active {
                transform: scale(1.05);
                box-shadow: 0 0 0 2px white;
            }
        </style>

        <script>
            let allCommandes = []; // Stocke toutes les commandes pour le filtrage

            document.addEventListener('DOMContentLoaded', function () {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                function getTypeText(type) {
                    const types = {
                        0: 'Froid',
                        1: 'Hot-dog',
                        2: 'Chaud',
                    };
                    return types[type] || 'Non spécifié';
                }

                function getEtatText(etat) {
                    const etats = {
                        0: 'Non payée',
                        1: 'Payée',
                        2: 'Prête',
                        3: 'Servie',
                        4: 'Annulée',
                    };
                    return etats[etat] || 'Inconnu';
                }

                function formatDate(dateString) {
                    const date = new Date(dateString);
                    return date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                }

                function loadCommandes() {
                    document.getElementById('commandesContainer').innerHTML = `
                        <div class="text-center py-10">
                            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500 mx-auto"></div>
                            <p class="mt-4">Chargement des commandes...</p>
                        </div>
                    `;

                    fetch('/admin/commandes/data', {
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                        .then((response) => response.json())
                        .then((commandes) => {
                            allCommandes = commandes; // Stocke toutes les commandes
                            displayCommandes(commandes);
                        })
                        .catch((error) => {
                            console.error('Erreur:', error);
                            displayCommandes([
                                {
                                    idCommande: 999999,
                                    numeroCommande: 'FETCH-ERROR',
                                    nomClient: 'Erreur de chargement',
                                    prenomClient: 'Erreur de chargement',
                                    categorieCommande: 0,
                                    prix: 0.0,
                                    date: new Date().toISOString(),
                                    commentaire: 'ERREUR: Impossible de charger les commandes',
                                    etat: 4,
                                },
                            ]);
                        });
                }

                function displayCommandes(commandes) {
                    if (commandes.length === 0) {
                        document.getElementById('commandesContainer').innerHTML = `
                            <div class="col-span-full text-center py-10 text-gray-400">
                                <p>Aucune commande correspondante</p>
                            </div>
                        `;
                        return;
                    }

                    let html = '';
                    commandes.forEach((commande) => {
                        const isTest = commande.idCommande === 999 || commande.numeroCommande === 'CMD-TEST';

                        html += `
                            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg border border-gray-700 commande-card ${isTest ? 'commande-test' : ''}">
                                <div class="p-5 border-b border-gray-700 flex justify-between items-center">
                                    <span class="font-bold text-xl">${commande.numeroCommande}</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold etat-${commande.etat}">${getEtatText(commande.etat)}</span>
                                </div>

                                <div class="p-5">
                                    <div class="mb-3">
                                        <span class="text-gray-400 font-medium">Client:</span>
                                        <span class="ml-2">${commande.prenomClient || ''} ${commande.nomClient || 'Non spécifié'}</span>
                                    </div>

                                    <div class="mb-3">
                                        <span class="text-gray-400 font-medium">Type:</span>
                                        <span class="ml-2">${getTypeText(commande.categorieCommande)}</span>
                                    </div>

                                    <div class="mb-3">
                                        <span class="text-gray-400 font-medium">Prix:</span>
                                        <span class="ml-2">${parseFloat(commande.prix).toFixed(2)} €</span>
                                    </div>

                                    <div class="mb-3">
                                        <span class="text-gray-400 font-medium">Heure:</span>
                                        <span class="ml-2">${formatDate(commande.date)}</span>
                                    </div>

                                    <div class="bg-gray-700 p-3 rounded-lg mb-4 ${isTest ? 'text-yellow-400' : 'text-gray-400'}">
                                        <p class="italic">${commande.commentaire || 'Pas de commentaire'}</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2">
                                        <button onclick="marquerPrete(${commande.idCommande})"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-colors text-sm ${isTest ? 'disabled-btn' : ''}"
                                            ${isTest ? 'disabled' : ''}>
                                            Prête
                                        </button>
                                        <button onclick="marquerServie(${commande.idCommande})"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-colors text-sm ${isTest ? 'disabled-btn' : ''}"
                                            ${isTest ? 'disabled' : ''}>
                                            Servie
                                        </button>
                                        <button onclick="modifierCommande(${commande.idCommande})"
                                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-lg transition-colors text-sm ${isTest ? 'disabled-btn' : ''}"
                                            ${isTest ? 'disabled' : ''}>
                                            Modifier
                                        </button>
                                        <button onclick="annulerCommande(${commande.idCommande})"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition-colors text-sm ${isTest ? 'disabled-btn' : ''}"
                                            ${isTest ? 'disabled' : ''}>
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    document.getElementById('commandesContainer').innerHTML = html;
                }

                // Fonction de filtrage
                window.filterCommandes = function (etat) {
                    // Mise à jour de l'UI des boutons
                    document.querySelectorAll('.flex button').forEach((btn) => {
                        btn.classList.remove('active');
                    });
                    event.target.classList.add('active');

                    if (etat === 'all') {
                        displayCommandes(allCommandes);
                    } else {
                        const filtered = allCommandes.filter((c) => c.etat === etat);
                        displayCommandes(filtered);
                    }
                };

                window.marquerPrete = function (id) {
                    if (id === 999999) {
                        alert('Cette commande est un exemple test - Action impossible');
                        return;
                    }

                    fetch(`/admin/commandes/commande-prete/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            Accept: 'application/json',
                        },
                    })
                        .then((response) => {
                            if (response.ok) {
                                loadCommandes();
                            } else {
                                throw new Error('Échec de la mise à jour');
                            }
                        })
                        .catch((error) => {
                            console.error('Erreur:', error);
                            alert('Erreur lors de la mise à jour: ' + error.message);
                        });
                };

                window.marquerServie = function (id) {
                    if (id === 999999) {
                        alert('Cette commande est un exemple test - Action impossible');
                        return;
                    }

                    fetch(`/admin/commandes/commande-donnee/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            Accept: 'application/json',
                        },
                    })
                        .then((response) => {
                            if (response.ok) {
                                loadCommandes();
                            } else {
                                throw new Error('Échec de la mise à jour');
                            }
                        })
                        .catch((error) => {
                            console.error('Erreur:', error);
                            alert('Erreur lors de la mise à jour: ' + error.message);
                        });
                };

                window.modifierCommande = function (id) {
                    if (id === 999999) {
                        alert('Cette commande est un exemple test - Action impossible');
                        return;
                    }

                    // Implémentez ici la logique de modification
                    alert('Fonctionnalité de modification à implémenter pour la commande ' + id);
                };

                window.annulerCommande = function (id) {
                    if (id === 999999) {
                        alert('Cette commande est un exemple test - Action impossible');
                        return;
                    }

                    if (confirm('Êtes-vous sûr de vouloir annuler cette commande ?')) {
                        fetch(`/admin/commandes/annuler-commande/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                Accept: 'application/json',
                            },
                        })
                            .then((response) => {
                                if (response.ok) {
                                    loadCommandes();
                                } else {
                                    throw new Error("Échec de l'annulation");
                                }
                            })
                            .catch((error) => {
                                console.error('Erreur:', error);
                                alert("Erreur lors de l'annulation: " + error.message);
                            });
                    }
                };

                // Initialisation
                loadCommandes();
                // Rafraîchir toutes les 30 secondes
                setInterval(loadCommandes, 30000);
            });
        </script>
    </body>
</html>
