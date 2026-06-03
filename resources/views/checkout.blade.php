<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans min-h-screen transition-colors duration-300"
    :class="darkMode ? 'bg-gray-900 text-gray-100' : 'bg-gray-50 text-gray-900'" x-data="{
        darkMode: true,

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
            <a href="/products" class="text-2xl font-bold tracking-wide flex items-center"
                :class="darkMode ? 'text-white' : 'text-gray-800'">
                <i class="fa-solid fa-arrow-left text-sm mr-3 text-indigo-500 hover:translate-x-1 transition"></i>
                <i class="fa-solid fa-shop text-indigo-500 mr-2"></i>My Shop
            </a>

            <button @click="darkMode = !darkMode"
                class="p-2.5 rounded-full transition cursor-pointer text-lg flex items-center justify-center border"
                :class="darkMode ? 'bg-gray-700 text-yellow-400 border-gray-600 hover:bg-gray-600' :
                    'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200'">
                <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
            </button>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-10">
        <h2 class="text-3xl font-extrabold mb-8" :class="darkMode ? 'text-white' : 'text-gray-900'">Secure Checkout</h2>

        <form action="/products" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            @csrf {{-- Security token required by Laravel --}}

            <div class="lg:col-span-7 space-y-6">

                <div class="p-6 rounded-2xl border transition shadow-sm"
                    :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-100'">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-2"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <i class="fa-solid fa-truck text-indigo-500"></i> Shipping Information
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">First Name</label>
                            <input type="text" name="first_name" required
                                class="w-full border rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' :
                                    'bg-gray-50 border-gray-200 text-gray-700'">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Last Name</label>
                            <input type="text" name="last_name" required
                                class="w-full border rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' :
                                    'bg-gray-50 border-gray-200 text-gray-700'">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold uppercase mb-1"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Street Address</label>
                            <input type="text" name="address_id" required placeholder="Apartment, suite, unit, etc."
                                class="w-full border rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' :
                                    'bg-gray-50 border-gray-200 text-gray-700'">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">City</label>
                            <input type="text" name="city" required
                                class="w-full border rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' :
                                    'bg-gray-50 border-gray-200 text-gray-700'">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Postal / ZIP Code</label>
                            <input type="text" name="postal_code" required
                                class="w-full border rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' :
                                    'bg-gray-50 border-gray-200 text-gray-700'">
                        </div>
                    </div>
                </div>

                <div class="p-6 rounded-2xl border transition shadow-sm"
                    :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-100'">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-2"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <i class="fa-solid fa-credit-card text-indigo-500"></i> Payment Details
                    </h3>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <label
                            class="border p-4 rounded-xl flex items-center gap-3 cursor-pointer transition select-none"
                            :class="paymentMethod === 'credit_card' ? 'border-indigo-500 bg-indigo-500/10' : (darkMode ?
                                'border-gray-700 hover:bg-gray-700/50' : 'border-gray-200 hover:bg-gray-50')">
                            <input type="radio" name="payment_method" value="credit_card" x-model="paymentMethod"
                                class="accent-indigo-600 h-4 w-4">
                            <div class="text-sm font-semibold">Credit Card</div>
                        </label>
                        <label
                            class="border p-4 rounded-xl flex items-center gap-3 cursor-pointer transition select-none"
                            :class="paymentMethod === 'cod' ? 'border-indigo-500 bg-indigo-500/10' : (darkMode ?
                                'border-gray-700 hover:bg-gray-700/50' : 'border-gray-200 hover:bg-gray-50')">
                            <input type="radio" name="payment_method" value="cod" x-model="paymentMethod"
                                class="accent-indigo-600 h-4 w-4">
                            <div class="text-sm font-semibold">Cash on Delivery</div>
                        </label>
                    </div>

                    <div x-show="paymentMethod === 'credit_card'" class="space-y-4" x-collapse>
                        <div>
                            <label class="block text-xs font-semibold uppercase mb-1"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Card Number</label>
                            <div class="relative">
                                <input type="text" placeholder="0000 0000 0000 0000"
                                    class="w-full border rounded-xl p-3 pl-10 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' :
                                        'bg-gray-50 border-gray-200 text-gray-700'">
                                <i class="fa-solid fa-credit-card absolute left-3 top-3.5 text-gray-400"></i>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase mb-1"
                                    :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Expiration Date</label>
                                <input type="text" placeholder="MM / YY"
                                    class="w-full border rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' :
                                        'bg-gray-50 border-gray-200 text-gray-700'">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase mb-1"
                                    :class="darkMode ? 'text-gray-400' : 'text-gray-500'">CVC / CVV</label>
                                <input type="text" placeholder="123"
                                    class="w-full border rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' :
                                        'bg-gray-50 border-gray-200 text-gray-700'">
                            </div>
                        </div>
                    </div>

                    <div x-show="paymentMethod === 'cod'" class="p-4 rounded-xl border text-sm flex items-center gap-3"
                        :class="darkMode ? 'bg-gray-900/40 border-gray-700 text-gray-300' :
                            'bg-yellow-50 border-yellow-200 text-yellow-800'"
                        x-cloak>
                        <i class="fa-solid fa-circle-info text-lg text-indigo-500"></i>
                        <p>No upfront payment needed. You will pay our delivery agent in cash upon receiving your items.
                        </p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 sticky top-24">
                <div class="p-6 rounded-2xl border shadow-sm flex flex-col"
                    :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-100'">
                    <h3 class="text-xl font-bold mb-4" :class="darkMode ? 'text-white' : 'text-gray-900'">Order Summary
                    </h3>

                    <div class="divide-y max-h-64 overflow-y-auto pr-2 space-y-3 mb-4"
                        :class="darkMode ? 'divide-gray-700' : 'divide-gray-100'">
                        <template x-for="item in cart" :key="item.key">
                            <div class="flex items-center gap-4 pt-3 first:pt-0">
                                <img :src="item.image" class="w-14 h-14 object-cover rounded-lg border"
                                    :class="darkMode ? 'border-gray-700' : 'border-gray-100'">
                                <input type="hidden" name="product_id[]" :value="item.product_id">
                                <input type="hidden" name="product_variant_id[]" :value="item.product_variant_id">
                                <input type="hidden" name="quantity[]" :value="item.quantity">
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm truncate"
                                        :class="darkMode ? 'text-white' : 'text-gray-800'" x-text="item.name"></h4>
                                    <p class="text-xs text-gray-400" x-text="'Variant: ' + item.variant"></p>
                                    <p class="text-xs font-medium mt-0.5"
                                        :class="darkMode ? 'text-gray-400' : 'text-gray-500'"
                                        x-text="item.quantity + ' x $' + item.price.toFixed(2)"></p>
                                </div>
                                <p class="text-sm font-bold text-indigo-500"
                                    x-text="'$' + (item.price * item.quantity).toFixed(2)"></p>
                            </div>
                        </template>
                    </div>

                    <div class="border-t pt-4 space-y-2 text-sm"
                        :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                        <div class="flex justify-between" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            <span>Subtotal</span>
                            <span font-medium x-text="'$' + subtotal.toFixed(2)"></span>
                        </div>
                        <div class="flex justify-between" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            <span>Shipping</span>
                            <span font-medium x-text="shipping === 0 ? 'FREE' : '$' + shipping.toFixed(2)"></span>
                        </div>
                        <div class="flex justify-between text-base font-bold border-t pt-2 mt-2"
                            :class="darkMode ? 'text-white' : 'text-gray-900'">
                            <span>Total</span>
                            <span class="text-indigo-500 text-xl" x-text="'$' + total.toFixed(2)"></span>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3.5 rounded-xl font-bold tracking-wide mt-6 shadow transition cursor-pointer flex items-center justify-center gap-2">
                        <i class="fa-solid fa-lock text-sm"></i> Place Secure Order
                    </button>

                    <p class="text-center text-xs text-gray-400 mt-3 flex items-center justify-center gap-1">
                        <i class="fa-solid fa-shield-halved text-green-500"></i> Your details are encrypted safely.
                    </p>
                </div>
            </div>
        </form>
    </main>

</body>

</html>
