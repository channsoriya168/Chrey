<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Breadcrumb -->
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <nav class="flex items-center space-x-2 text-sm">
                <Link href="/" class="text-gray-500 hover:text-pink-600">ទំព័រដើម</Link>
                <span class="text-gray-400">/</span>
                <span class="font-medium text-gray-900">Shopping Cart</span>
            </nav>
        </div>

        <!-- Cart Content -->
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <h1 class="mb-8 text-3xl font-bold text-gray-900">Shopping Cart</h1>

            <div v-if="cartItems.length === 0" class="rounded-lg bg-white p-12 text-center shadow-sm">
                <svg
                    class="mx-auto h-24 w-24 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                </svg>
                <h2 class="mt-4 text-xl font-semibold text-gray-900">Your cart is empty</h2>
                <p class="mt-2 text-gray-600">Add some products to get started!</p>
                <Link
                    href="/"
                    class="mt-6 inline-block rounded-lg bg-pink-600 px-6 py-3 font-semibold text-white transition-colors hover:bg-pink-700"
                >
                    Continue Shopping
                </Link>
            </div>

            <div v-else class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="space-y-4">
                        <div
                            v-for="item in cartItems"
                            :key="item.id"
                            class="flex gap-4 rounded-lg bg-white p-4 shadow-sm"
                        >
                            <!-- Product Image -->
                            <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-lg border border-gray-200">
                                <img
                                    :src="getProductImage(item.product)"
                                    :alt="item.product.name"
                                    class="h-full w-full object-cover"
                                />
                            </div>

                            <!-- Product Details -->
                            <div class="flex flex-1 flex-col">
                                <div class="flex justify-between">
                                    <div>
                                        <Link
                                            :href="`/product/${item.product.slug}`"
                                            class="text-lg font-semibold text-gray-900 hover:text-pink-600"
                                        >
                                            {{ item.product.name }}
                                        </Link>
                                        <p class="mt-1 text-sm text-gray-600">
                                            ${{ item.price }} each
                                        </p>
                                    </div>
                                    <button
                                        @click="removeItem(item.id)"
                                        class="text-gray-400 transition-colors hover:text-red-600"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center rounded-lg border border-gray-300">
                                        <button
                                            @click="updateQuantity(item.id, item.quantity - 1)"
                                            :disabled="item.quantity <= 1"
                                            class="px-3 py-1 text-gray-600 transition-colors hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            −
                                        </button>
                                        <span class="w-12 text-center">{{ item.quantity }}</span>
                                        <button
                                            @click="updateQuantity(item.id, item.quantity + 1)"
                                            :disabled="item.quantity >= item.product.stock"
                                            class="px-3 py-1 text-gray-600 transition-colors hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            +
                                        </button>
                                    </div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        ${{ (item.price * item.quantity).toFixed(2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-4 rounded-lg bg-white p-6 shadow-sm">
                        <h2 class="mb-4 text-xl font-bold text-gray-900">Order Summary</h2>

                        <div class="space-y-3 border-b border-gray-200 pb-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>${{ subtotal.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span>Calculated at checkout</span>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-between text-lg font-bold text-gray-900">
                            <span>Total</span>
                            <span>${{ total.toFixed(2) }}</span>
                        </div>

                        <button
                            class="mt-6 w-full rounded-lg bg-pink-600 px-6 py-3 font-semibold text-white transition-colors hover:bg-pink-700"
                        >
                            Proceed to Checkout
                        </button>

                        <Link
                            href="/"
                            class="mt-4 block text-center text-sm text-pink-600 hover:text-pink-700"
                        >
                            Continue Shopping
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
    cart: Object,
    cartItems: {
        type: Array,
        default: () => []
    },
    subtotal: {
        type: Number,
        default: 0
    },
    total: {
        type: Number,
        default: 0
    }
})

// Get product image
const getProductImage = (product) => {
    if (product.image_url) {
        if (Array.isArray(product.image_url) && product.image_url.length > 0) {
            return `/storage/${product.image_url[0]}`
        }
        if (typeof product.image_url === 'string') {
            try {
                const parsed = JSON.parse(product.image_url)
                if (Array.isArray(parsed) && parsed.length > 0) {
                    return `/storage/${parsed[0]}`
                }
            } catch (e) {
                return `/storage/${product.image_url}`
            }
        }
    }
    return ''
}

// Update item quantity
const updateQuantity = (itemId, newQuantity) => {
    if (newQuantity < 1) return

    router.put(
        `/cart/${itemId}`,
        { quantity: newQuantity },
        {
            preserveScroll: true
        }
    )
}

// Remove item from cart
const removeItem = (itemId) => {
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        router.delete(`/cart/${itemId}`, {
            preserveScroll: true
        })
    }
}
</script>
