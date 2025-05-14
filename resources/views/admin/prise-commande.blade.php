<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('head')
    <title>Prise de commande</title>
    <style>
        .disabled-item {
            background-color: #3f3f46 !important;
            opacity: 0.7;
            cursor: not-allowed;
        }
        .no-scrollbar::-webkit-scrollbar { width: 0 !important; height: 0 !important; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#0a0a0a] text-white pt-28 md:pt-48">
@include('header')

<div class="max-w-7xl mx-auto px-4">
    <div class="grid grid-cols-4 gap-4 h-[520px]">

        {{-- Colonne 1 (Menus en haut, Plats en bas, hauteurs égales) --}}
        <div class="flex flex-col h-full">
            <div class="bg-[#18181b] rounded-2xl shadow-lg p-4 flex flex-col flex-1 mb-2">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-base font-semibold text-left">Menus</h3>
                    <input
                        type="text"
                        placeholder="Rechercher..."
                        class="search-box px-2 py-1 rounded bg-[#232326] text-white placeholder-gray-400 focus:outline-none text-sm"
                        data-box="menus"
                        oninput="filterBox('menus', this.value)"
                        style="width: 110px;"
                    >
                </div>
                <ul id="list-menus" class="space-y-1 no-scrollbar overflow-y-auto flex-1">
                    @foreach(($carteItems[3] ?? collect())->concat($carteItems[4] ?? collect()) as $item)
                        @php
                            $stock = $inventaire[$item->nom]->quantite ?? 0;
                        @endphp
                        <li
                            class="bento-item p-1 rounded cursor-pointer hover:bg-gray-700 transition-colors text-sm {{ $stock <= 0 ? 'disabled-item' : '' }}"
                            data-nom="{{ $item->nom }}"
                            data-prix="{{ $item->prix }}"
                            data-stock="{{ $stock }}"
                            onclick="addToCart(this)"
                        >
                            {{ $item->nom }} - {{ $item->prix }}€
                            @if($stock <= 0)
                                <span class="ml-2 text-xs text-gray-400">(rupture)</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-[#18181b] rounded-2xl shadow-lg p-4 flex flex-col flex-1 mt-2">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-base font-semibold text-left">Plats</h3>
                    <input
                        type="text"
                        placeholder="Rechercher..."
                        class="search-box px-2 py-1 rounded bg-[#232326] text-white placeholder-gray-400 focus:outline-none text-sm"
                        data-box="plats"
                        oninput="filterBox('plats', this.value)"
                        style="width: 110px;"
                    >
                </div>
                <ul id="list-plats" class="space-y-1 no-scrollbar overflow-y-auto flex-1">
                    @foreach($carteItems[0] ?? [] as $item)
                        @php
                            $stock = $inventaire[$item->nom]->quantite ?? 0;
                        @endphp
                        <li
                            class="bento-item p-1 rounded cursor-pointer hover:bg-gray-700 transition-colors text-sm {{ $stock <= 0 ? 'disabled-item' : '' }}"
                            data-nom="{{ $item->nom }}"
                            data-prix="{{ $item->prix }}"
                            data-stock="{{ $stock }}"
                            onclick="addToCart(this)"
                        >
                            {{ $item->nom }} - {{ $item->prix }}€
                            @if($stock <= 0)
                                <span class="ml-2 text-xs text-gray-400">(rupture)</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Colonne 2 : Snacks --}}
        <div class="bg-[#18181b] rounded-2xl shadow-lg p-4 flex flex-col h-full">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-base font-semibold text-left">Snacks</h3>
                <input
                    type="text"
                    placeholder="Rechercher..."
                    class="search-box px-2 py-1 rounded bg-[#232326] text-white placeholder-gray-400 focus:outline-none text-sm"
                    data-box="snacks"
                    oninput="filterBox('snacks', this.value)"
                    style="width: 110px;"
                >
            </div>
            <ul id="list-snacks" class="space-y-1 no-scrollbar overflow-y-auto flex-1">
                @foreach($carteItems[1] ?? [] as $item)
                    @php
                        $stock = $inventaire[$item->nom]->quantite ?? 0;
                    @endphp
                    <li
                        class="bento-item p-1 rounded cursor-pointer hover:bg-gray-700 transition-colors text-sm {{ $stock <= 0 ? 'disabled-item' : '' }}"
                        data-nom="{{ $item->nom }}"
                        data-prix="{{ $item->prix }}"
                        data-stock="{{ $stock }}"
                        onclick="addToCart(this)"
                    >
                        {{ $item->nom }} - {{ $item->prix }}€
                        @if($stock <= 0)
                            <span class="ml-2 text-xs text-gray-400">(rupture)</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Colonne 3 : Boissons --}}
        <div class="bg-[#18181b] rounded-2xl shadow-lg p-4 flex flex-col h-full">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-base font-semibold text-left">Boissons</h3>
                <input
                    type="text"
                    placeholder="Rechercher..."
                    class="search-box px-2 py-1 rounded bg-[#232326] text-white placeholder-gray-400 focus:outline-none text-sm"
                    data-box="boissons"
                    oninput="filterBox('boissons', this.value)"
                    style="width: 110px;"
                >
            </div>
            <ul id="list-boissons" class="space-y-1 no-scrollbar overflow-y-auto flex-1">
                @foreach($carteItems[2] ?? [] as $item)
                    @php
                        $stock = $inventaire[$item->nom]->quantite ?? 0;
                    @endphp
                    <li
                        class="bento-item p-1 rounded cursor-pointer hover:bg-gray-700 transition-colors text-sm {{ $stock <= 0 ? 'disabled-item' : '' }}"
                        data-nom="{{ $item->nom }}"
                        data-prix="{{ $item->prix }}"
                        data-stock="{{ $stock }}"
                        onclick="addToCart(this)"
                    >
                        {{ $item->nom }} - {{ $item->prix }}€
                        @if($stock <= 0)
                            <span class="ml-2 text-xs text-gray-400">(rupture)</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Colonne 4 (Autre en haut, Récap en bas, hauteurs égales) --}}
        <div class="flex flex-col h-full">
            <div class="bg-[#18181b] rounded-2xl shadow-lg p-4 flex flex-col flex-1 mb-2">
                <h3 class="text-base font-semibold mb-2 text-left">Autre</h3>
                <div class="space-y-1">
                    <button class="w-full p-1 bg-blue-600 rounded hover:bg-blue-700 transition-colors text-sm" onclick="openDialog('special')">Options spéciales</button>
                    <button class="w-full p-1 bg-blue-600 rounded hover:bg-blue-700 transition-colors text-sm" onclick="openDialog('modificateur')">Modificateurs</button>
                    <button class="w-full p-1 bg-blue-600 rounded hover:bg-blue-700 transition-colors text-sm" onclick="openDialog('remarque')">Remarques</button>
                </div>
            </div>
            <div class="bg-[#18181b] rounded-2xl shadow-lg p-4 flex flex-col flex-1 mt-2">
                <input type="text" placeholder="Nom du client" class="w-full mb-2 px-2 py-1 rounded bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                <h3 class="text-base font-semibold mb-2 text-left">Récapitulatif</h3>
                <div id="cart-items" class="space-y-1 mb-2 no-scrollbar overflow-y-auto flex-1"></div>
                <div class="flex justify-between items-center">
                    <span class="font-semibold">Total :</span>
                    <span id="total-price" class="font-bold text-lg">0.00€</span>
                </div>
                <button class="w-full mt-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-2 rounded transition-colors text-sm">Valider la commande</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Filtrage par case
    function filterBox(box, search) {
        search = search.toLowerCase();
        const list = document.getElementById('list-' + box);
        if (!list) return;
        const items = list.querySelectorAll('.bento-item');
        items.forEach(item => {
            if(item.textContent.toLowerCase().includes(search)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Gestion du panier
    let cart = [];
    function addToCart(el) {
        if (el.classList.contains('disabled-item')) return;
        const nom = el.getAttribute('data-nom');
        const prix = parseFloat(el.getAttribute('data-prix'));
        cart.push({ nom, prix });
        updateCartDisplay();
    }
    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCartDisplay();
    }
    function updateCartDisplay() {
        const cartContainer = document.getElementById('cart-items');
        const totalElement = document.getElementById('total-price');
        let total = 0;
        cartContainer.innerHTML = '';
        cart.forEach((item, index) => {
            total += item.prix;
            const div = document.createElement('div');
            div.className = 'flex justify-between items-center bg-gray-800 p-1 rounded text-sm';
            div.innerHTML = `
                <span>${item.nom}</span>
                <div class="flex items-center gap-2">
                    <span>${item.prix.toFixed(2)}€</span>
                    <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-400" title="Retirer">✕</button>
                </div>
            `;
            cartContainer.appendChild(div);
        });
        totalElement.textContent = `${total.toFixed(2)}€`;
    }

    // Placeholder pour les dialogs
    function openDialog(type) {
        alert("Ouverture du dialog : " + type + " (à implémenter)");
    }
</script>

@include('footer')
</body>
</html>
