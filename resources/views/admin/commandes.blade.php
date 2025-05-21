<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include("head")
        <title>Affichage Cuisine - Commandes</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>

    <body class="bg-white text-black pt-28 md:pt-60">
        @include("header")

        <main class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-8 text-center">Commandes en Cuisine</h1>

            <!-- Barre de filtrage -->
            <div class="flex flex-wrap gap-2 mb-6 justify-center">
                <button onclick="filterCommandes('all')" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 rounded-lg transition-colors">Toutes</button>
                <button onclick="filterCommandes(0)" class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded-lg transition-colors">Non payées</button>
                <button onclick="filterCommandes(1)" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Payées</button>
                <button onclick="filterCommandes(2)" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 rounded-lg transition-colors">Prêtes</button>
                <button onclick="filterCommandes(3)" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg transition-colors">Servies</button>
                <button onclick="filterCommandes(4)" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition-colors">Annulées</button>
            </div>

            <div id="commandesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="text-center py-10">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 mx-auto"></div>
                    <p class="mt-4">Chargement des commandes...</p>
                </div>
            </div>
        </main>

        <!-- Dialog de modification de commande -->
        <div id="modifierCommandeDialog" class="bg-black bg-opacity-50 p-4 z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-bold text-xl">${commande.numeroCommande}</span>
                        <button onclick="document.getElementById('modifierCommandeDialog').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div id="categoriesContainer" class="space-y-6">
                        <div class="text-center py-4">
                            <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500 mx-auto"></div>
                            <p class="mt-2">Chargement des ingrédients...</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="commandeCommentaire" class="block text-sm font-medium text-gray-700">Commentaire</label>
                        <textarea id="commandeCommentaire" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                    </div>
                    
                    <div class="mt-6 flex justify-end space-x-3">
                        <button onclick="document.getElementById('modifierCommandeDialog').classList.add('hidden')" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Annuler</button>
                        <button onclick="sauvegarderModifications()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .etat-0 {
                background-color: rgba(251, 44, 54, 1);
                color: black;
            }
            .etat-1 {
                background-color: rgba(152, 16, 250, 1);
                color: black;
            }
            .etat-2 {
                background-color: rgba(255, 105, 0, 1);
                color: black;
            }
            .etat-3 {
                background-color: rgba(0, 166, 62, 1);
                color: black;
            }
            .etat-4 {
                background-color: rgba(231, 0, 11, 0.7);
                color: black;
                text-decoration: underline;
                font-weight: bold;
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
            let currentCommandeId = null;
            let currentCommandeItems = [];
            let allInventaireItems = [];

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
                            <div class="bg-neutral-200 rounded-[13px] overflow-hidden shadow-lg border border-black commande-card ${isTest ? 'commande-test' : ''}">
                                <div class="p-5 bg-neutral-400 border-b border-black flex justify-between items-center">
                                    <span class="font-bold text-xl">${commande.numeroCommande}</span>
                                    <span class="px-3 py-1 rounded-full text-md font-medium etat-${commande.etat}">${getEtatText(commande.etat)}</span>
                                </div>

                                <div class="p-5">
                                    <div class="mb-3">
                                        <span class="font-medium">Client:</span>
                                        <span class="ml-2">${commande.prenomClient || ''} ${commande.nomClient || 'Non spécifié'}</span>
                                    </div>

                                    <div class="mb-3">
                                        <span class="font-medium">Type:</span>
                                        <span class="ml-2">${getTypeText(commande.categorieCommande)}</span>
                                    </div>

                                    <div class="mb-3">
                                        <span class="font-medium">Prix:</span>
                                        <span class="ml-2">${parseFloat(commande.prix).toFixed(2)} €</span>
                                    </div>

                                    <div class="mb-3">
                                        <span class="font-medium">Heure:</span>
                                        <span class="ml-2">${formatDate(commande.date)}</span>
                                    </div>

                                    <div class="bg-neutral-400 p-3 rounded-lg mb-4 ${isTest ? 'text-red-300' : 'text-black'}">
                                        <p class="italic">${commande.commentaire || 'Pas de commentaire'}</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2">
                                        <button onclick="marquerPrete(${commande.idCommande})"
                                            class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 rounded-lg transition-colors text-sm ${isTest ? 'disabled-btn' : ''}"
                                            ${isTest ? 'disabled' : ''}>
                                            Prête
                                        </button>
                                        <button onclick="marquerServie(${commande.idCommande})"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-colors text-sm ${isTest ? 'disabled-btn' : ''}"
                                            ${isTest ? 'disabled' : ''}>
                                            Servie
                                        </button>
                                        <button onclick="marquerPayee(${commande.idCommande})"
                                            class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-lg transition-colors text-sm ${isTest ? 'disabled-btn' : ''}"
                                            ${isTest ? 'disabled' : ''}>
                                            Payée
                                        </button>
                                        <button onclick="annulerCommande(${commande.idCommande})"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition-colors text-sm ${isTest ? 'disabled-btn' : ''}"
                                            ${isTest ? 'disabled' : ''}>
                                            Annuler
                                        </button>
                                        <button onclick="modifierCommande(${commande.idCommande})"
                                            class="col-span-2 bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-lg transition-colors text-sm ${isTest ? 'disabled-btn' : ''}"
                                            ${isTest ? 'disabled' : ''}>
                                            Modifier
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

                window.marquerPayee = function (id) {
                    if (id === 999999) {
                        alert('Cette commande est un exemple test - Action impossible');
                        return;
                    }

                    fetch(`/admin/commandes/commande-payee/${id}`, {
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

            // Fonction pour ouvrir le dialog de modification
            window.modifierCommande = async function(id) {
    if (id === 999999) {
        alert('Cette commande est un exemple test - Action impossible');
        return;
    }

    currentCommandeId = id;
    document.getElementById('modifierCommandeDialog').classList.remove('hidden');
    
    // Afficher le loader
    document.getElementById('categoriesContainer').innerHTML = `
        <div class="text-center py-4">
            <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500 mx-auto"></div>
            <p class="mt-2">Chargement des données...</p>
        </div>
    `;

    try {
        const [commandeResponse, inventaireResponse] = await Promise.all([
            fetch(`/admin/commandes/details/${id}`).then(r => {
                if (!r.ok) throw new Error(`Erreur commande: ${r.status}`);
                return r.json();
            }),
            fetch('/admin/inventaire/items').then(r => {
                if (!r.ok) throw new Error(`Erreur inventaire: ${r.status}`);
                return r.json();
            })
        ]);
        
        // Debug: afficher les données reçues
        console.log('Données commande:', commandeResponse);
        console.log('Données inventaire:', inventaireResponse);
        
        if (!commandeResponse || !inventaireResponse) {
            throw new Error('Données manquantes dans la réponse');
        }
        
        document.getElementById('commandeCommentaire').value = commandeResponse.commentaire || '';
        
        // Traitement du stock
        const stockItems = [];
        if (commandeResponse.stock) {
            const items = commandeResponse.stock.split(';');
            for (const item of items) {
                if (item) {
                    const [idIngredient, quantite, obligatoire] = item.split(',');
                    stockItems.push({
                        idIngredient,
                        quantite,
                        obligatoire
                    });
                }
            }
        }
        
        currentCommandeItems = stockItems;
        allInventaireItems = inventaireResponse;
        
        afficherCategoriesInventaire();
    } catch (error) {
        console.error('Erreur détaillée:', error);
        document.getElementById('categoriesContainer').innerHTML = `
            <div class="text-center py-4 text-red-500">
                <p>Erreur lors du chargement des données</p>
                <p class="text-sm mt-2">${error.message}</p>
            </div>
        `;
    }
};

// Fonction pour afficher les catégories d'items
function afficherCategoriesInventaire() {
    const categoriesContainer = document.getElementById('categoriesContainer');
    
    // Grouper par catégorie
    const itemsParCategorie = {};
    allInventaireItems.forEach(item => {
        if (!itemsParCategorie[item.categorieIngredient]) {
            itemsParCategorie[item.categorieIngredient] = [];
        }
        itemsParCategorie[item.categorieIngredient].push(item);
    });
    
    let html = '';
    
    // Catégories prédéfinies (ajustez selon vos besoins)
    const categories = [
        { id: 1, nom: 'Viandes' },
        { id: 2, nom: 'Extras' },
        { id: 3, nom: 'Snacks/Boissons' },
        { id: 0, nom: 'Ingrédients divers' }
    ];
    
    categories.forEach(categorie => {
        const items = itemsParCategorie[categorie.id] || [];
        if (items.length === 0) return;
        
        html += `
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="text-lg font-semibold mb-3">${categorie.nom}</h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
                    ${items.map(item => {
                        // Vérifier si l'item est dans la commande
                        const inCommande = currentCommandeItems.some(ci => ci.idIngredient == item.idIngredient);
                        
                        return `
                            <button 
                                onclick="toggleItemInCommande('${item.idIngredient}')"
                                class="px-3 py-2 rounded-lg text-sm font-medium text-white 
                                ${inCommande ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-700'}"
                            >
                                ${item.nom}
                                ${inCommande ? '<span class="ml-1">✓</span>' : ''}
                            </button>
                        `;
                    }).join('')}
                </div>
            </div>
        `;
    });
    
    categoriesContainer.innerHTML = html || `
        <div class="text-center py-4 text-gray-500">
            <p>Aucun ingrédient disponible</p>
        </div>
    `;
}

// Fonction pour ajouter/enlever un item de la commande
window.toggleItemInCommande = function(idIngredient) {
    const index = currentCommandeItems.findIndex(item => item.idIngredient == idIngredient);
    
    if (index === -1) {
        // Ajouter l'item
        currentCommandeItems.push({
            idIngredient: idIngredient,
            quantite: 1, // Quantité par défaut
            obligatoire: 0 // Non obligatoire par défaut
        });
    } else {
        // Retirer l'item
        currentCommandeItems.splice(index, 1);
    }
    
    afficherCategoriesInventaire();
};

// Fonction pour sauvegarder les modifications
async function sauvegarderModifications() {
    if (!currentCommandeId) return;
    
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const commentaire = document.getElementById('commandeCommentaire').value;
        
        // Préparer le stock au format "id,qte,obligatoire;id2,qte2,obligatoire2"
        const stockValue = currentCommandeItems
            .map(item => `${item.idIngredient},${item.quantite},${item.obligatoire}`)
            .join(';');
        
        const response = await fetch(`/admin/commandes/modifier/${currentCommandeId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                commentaire: commentaire,
                stock: stockValue
            })
        });
        
        if (response.ok) {
            alert('Modifications enregistrées avec succès');
            document.getElementById('modifierCommandeDialog').classList.add('hidden');
            loadCommandes();
        } else {
            throw new Error('Erreur lors de la sauvegarde');
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue: ' + error.message);
    }
}
        </script>
    </body>
</html>