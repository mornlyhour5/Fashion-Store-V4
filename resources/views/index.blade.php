<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans min-h-screen transition-colors duration-300"
    :class="darkMode ? 'bg-gray-900 text-gray-100' : 'bg-gray-50 text-gray-900'" x-data="{
        darkMode: false,
        isCartOpen: false,
        isDetailOpen: false,
        cart: JSON.parse(localStorage.getItem('cart')) || [],
        paymentMethod: 'cod',
    
        shipping: 5,
    
        get subtotal() {
            return this.cart.reduce((sum, item) => {
                return sum + (item.price * item.quantity);
            }, 0);
        },
    
        get total() {
            return this.subtotal + this.shipping;
        }
    }">

    <nav class="sticky top-0 z-40 shadow-md transition-colors duration-300"
        :class="darkMode ? 'bg-gray-800 border-b border-gray-700' : 'bg-white'">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-wide" :class="darkMode ? 'text-white' : 'text-gray-800'">
                <i class="fa-solid fa-shop text-indigo-500 mr-2"></i>My Shop
            </h1>

            <div class="flex items-center gap-4">
                <button @click="darkMode = !darkMode"
                    class="p-2.5 rounded-full transition cursor-pointer text-lg flex items-center justify-center border"
                    :class="darkMode ? 'bg-gray-700 text-yellow-400 border-gray-600 hover:bg-gray-600' :
                        'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200'"
                    :title="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
                    <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                </button>

                <button @click="isCartOpen = true"
                    class="relative bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full font-medium transition flex items-center gap-2 cursor-pointer shadow-sm">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="hidden sm:inline">View Cart</span>
                    <span x-text="cart.reduce((sum, item) => sum + item.quantity, 0)"
                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">
                        0
                    </span>
                </button>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        <h2 class="text-3xl font-extrabold mb-8 text-center" :class="darkMode ? 'text-white' : 'text-gray-900'">Our
            Products</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($product as $p)
                @php
                    // 1. Fetch the first image relation from your database
                    $productImage = $p->images->first();

                    // 2. Point directly to your public frontend directory path
                    $imageUrl = $productImage
                        ? asset('images/' . $productImage->image_path) // If database stores filename like "portugal.jpg"
                        : asset('images/portugal.jpg'); // Your default fallback image

                    // 3. Handle variants and fallback price safely
                    $productVariants = $p->variants;
                    $basePrice = $productVariants->first()->price ?? ($p->price ?? 0.0);
                @endphp

                <div x-data="{
                    id: {{ $p->id }},
                    name: '{{ addslashes($p->name) }}',
                    imageUrl: '{{ $imageUrl }}',
                    description: '{{ addslashes($p->description ?? 'No description available.') }}',
                    selectedPrice: {{ $basePrice }},
                    selectedVariant: ''
                }" x-init="// Initialize the default variant text if variants exist
                let el = document.getElementById('variant-select-' + id);
                selectedVariant = el ? el.options[el.selectedIndex].text.split(' ($')[0] : 'Standard';"
                    class="rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 border flex flex-col"
                    :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-100'">

                    <img :src="imageUrl" :alt="name" class="h-48 w-full object-cover">

                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold mb-1" :class="darkMode ? 'text-white' : 'text-gray-900'"
                                x-text="name"></h3>
                            <p class="text-indigo-500 font-semibold text-xl mb-3">
                                $<span x-text="Number(selectedPrice).toFixed(2)"></span>
                            </p>

                            @if ($productVariants->count() > 0)
                                <div class="mb-4">
                                    <label class="block text-xs font-semibold uppercase tracking-wider mb-1"
                                        :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Select Variant:</label>
                                    <select id="variant-select-{{ $p->id }}"
                                        @change="
                                        selectedPrice = Number($event.target.options[$event.target.selectedIndex].getAttribute('data-price'));
                                        selectedVariant = $event.target.options[$event.target.selectedIndex].text.split(' ($')[0];
                                    "
                                        class="w-full border rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' :
                                            'bg-gray-50 border-gray-200 text-gray-700'">
                                        @foreach ($productVariants as $v)
                                            <option value="{{ $v->id }}" data-price="{{ $v->price }}">
                                                {{ $v->name }} (${{ number_format($v->price, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-3 mt-2">
                            <button
                                @click="
                                activeProduct = { name: name, price: selectedPrice, image: imageUrl, desc: description };
                                isDetailOpen = true;
                            "
                                class="border font-medium py-2 px-3 rounded-xl text-sm transition flex items-center justify-center gap-1 cursor-pointer"
                                :class="darkMode ? 'border-gray-600 hover:bg-gray-700 text-gray-300' :
                                    'border-gray-300 hover:bg-gray-50 text-gray-700'">
                                <i class="fa-regular fa-eye"></i> Details
                            </button>

                            <button
                                @click="
                                let itemKey = id + '-' + selectedVariant;
                                let existing = cart.find(i => i.key === itemKey);

                                if (existing) {
                                    existing.quantity++;
                                } else {
                                    cart.push({
    key: itemKey,
    product_id: id,
    product_variant_id: document.getElementById('variant-select-' + id).value,
    name: name,
    variant: selectedVariant,
    price: selectedPrice,
    image: imageUrl,
    quantity: 1
});
                                }
                            "
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-3 rounded-xl text-sm transition flex items-center justify-center gap-1 cursor-pointer shadow-sm">
                                <i class="fa-solid fa-plus"></i> Add To Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <div x-show="isDetailOpen"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" x-cloak>
        <div @click.away="isDetailOpen = false"
            class="rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl relative p-6 border"
            :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-100'">
            <button @click="isDetailOpen = false"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 text-2xl cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <img :src="activeProduct.image" class="w-full h-56 object-cover rounded-xl mb-4 shadow-inner">
            <h3 class="text-2xl font-bold mb-2" :class="darkMode ? 'text-white' : 'text-gray-900'"
                x-text="activeProduct.name"></h3>
            <p class="text-2xl font-extrabold text-indigo-500 mb-4">$<span
                    x-text="Number(activeProduct.price).toFixed(2)"></span></p>
            <h4 class="font-semibold mb-1" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Product Description
            </h4>
            <p class="leading-relaxed mb-6" :class="darkMode ? 'text-gray-400' : 'text-gray-600'"
                x-text="activeProduct.desc"></p>
        </div>
    </div>

    <div x-show="isCartOpen" class="fixed inset-0 z-50 overflow-hidden" x-cloak>
        <div class="absolute inset-0 bg-black/60 backdrop-blur-xs transition-opacity" @click="isCartOpen = false"></div>
        <div class="absolute inset-y-0 right-0 max-w-full flex pl-10">
            <div class="w-screen max-w-md shadow-2xl flex flex-col"
                :class="darkMode ? 'bg-gray-800 text-white' : 'bg-white'">
                <div class="p-6 border-b flex items-center justify-between"
                    :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                    <h2 class="text-xl font-bold flex items-center gap-2"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <i class="fa-solid fa-cart-shopping text-indigo-500"></i> Your Shopping Cart
                    </h2>
                    <button @click="isCartOpen = false" class="text-gray-400 hover:text-gray-500 cursor-pointer">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    <template x-if="cart.length === 0">
                        <p class="text-gray-500 text-center py-8">Your cart is empty.</p>
                    </template>
                    <template x-for="item in cart" :key="item.key">
                        <div class="flex items-center gap-4 p-3 rounded-xl border"
                            :class="darkMode ? 'bg-gray-700/50 border-gray-700' : 'bg-gray-50 border-gray-100'">
                            <img :src="item.image" class="w-16 h-16 object-cover rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-semibold text-sm" :class="darkMode ? 'text-white' : 'text-gray-800'"
                                    x-text="item.name"></h4>
                                <p class="text-xs text-gray-400 mb-1" x-text="'Variant: ' + item.variant"></p>
                                <p class="text-indigo-500 text-sm font-medium">$<span
                                        x-text="item.price.toFixed(2)"></span></p>
                                <div class="flex items-center gap-2 mt-2">
                                    <button
                                        @click="if(item.quantity > 1) { item.quantity-- } else { cart = cart.filter(i => i.key !== item.key) }"
                                        class="w-6 h-6 rounded flex items-center justify-center text-xs font-bold cursor-pointer"
                                        :class="darkMode ? 'bg-gray-600 hover:bg-gray-500' : 'bg-gray-200 hover:bg-gray-300'">-</button>
                                    <span class="text-sm font-semibold" x-text="item.quantity"></span>
                                    <button @click="item.quantity++"
                                        class="w-6 h-6 rounded flex items-center justify-center text-xs font-bold cursor-pointer"
                                        :class="darkMode ? 'bg-gray-600 hover:bg-gray-500' : 'bg-gray-200 hover:bg-gray-300'">+</button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="p-6 border-t"
                    :class="darkMode ? 'border-gray-700 bg-gray-900/50' : 'border-gray-200 bg-gray-50'">
                    <div class="flex justify-between text-base font-medium mb-4"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <p>Subtotal</p>
                        <p>$<span
                                x-text="cart.reduce((sum, item) => sum + (item.price * item.quantity), 0).toFixed(2)"></span>
                        </p>
                    </div>
                    <button
                        @click="
                            localStorage.setItem('cart', JSON.stringify(cart));
                            window.location.href = '/checkout'; "
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold shadow transition cursor-pointer text-center">
                        Proceed to Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
