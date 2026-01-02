<template>
    <div class="min-h-screen bg-gradient-to-br from-purple-900 via-slate-900 to-slate-950">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-4 sm:mb-6 flex items-center space-x-2 text-xs sm:text-sm">
                <a href="/"
                    class="rounded-lg px-2 sm:px-3 py-1.5 text-gray-300 transition-all hover:bg-fuchsia-500/20 hover:text-fuchsia-400">ទំព័រដើម</a>
                <span class="text-gray-500">/</span>
                <span class="rounded-lg bg-slate-800/60 px-2 sm:px-3 py-1.5 font-medium text-white backdrop-blur-sm">{{
                    t('cart.title') }}</span>
            </nav>

            <!-- Header -->
            <div class="mb-6 sm:mb-8 text-center">
                <h1
                    class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400 md:text-4xl">
                    {{ t('cart.title') }}
                </h1>
            </div>

            <!-- Cart Content -->
            <div v-if="cartItems.length > 0" class="grid grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-3">
                <!-- Cart Items Section -->
                <div class="lg:col-span-2 space-y-3 sm:space-y-4">
                    <!-- Cart Items Card -->
                    <div v-for="item in cartItems" :key="item.id"
                        class="overflow-hidden rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 shadow-lg shadow-fuchsia-500/10 transition-all duration-300 hover:border-fuchsia-500/40 hover:shadow-xl hover:shadow-fuchsia-500/20">
                        <div class="p-4 md:p-6">
                            <div class="flex gap-4 md:gap-6">
                                <!-- Product Image -->
                                <div
                                    class="h-24 w-24 md:h-28 md:w-28 flex-shrink-0 overflow-hidden rounded-xl bg-gradient-to-br from-slate-700 to-slate-800 ring-2 ring-fuchsia-500/30">
                                    <img :src="getCartImageUrl(item.product) || '/placeholder.jpg'"
                                        :alt="item.product.name"
                                        class="h-full w-full object-cover transition-transform duration-500 hover:scale-110" />
                                </div>

                                <!-- Product Details -->
                                <div class="flex flex-1 flex-col justify-between">
                                    <div class="flex justify-between gap-4">
                                        <div class="flex-1">
                                            <h3 class="font-bold text-white text-lg md:text-xl mb-1">{{
                                                item.product.name }}</h3>
                                            <p class="text-sm text-gray-400">
                                                {{ t('product.available') }}: <span
                                                    class="text-green-400 font-semibold">{{ item.product.stock }}</span>
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p
                                                class="text-xl md:text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400">
                                                ${{ item.price }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex items-center justify-between flex-wrap gap-2 sm:gap-4">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <span class="hidden sm:inline text-sm font-semibold text-gray-300">{{
                                                t('product.quantity')
                                                }}:</span>
                                            <div
                                                class="flex items-center overflow-hidden rounded-xl bg-slate-900/80 border border-slate-700/50 shadow-lg">
                                                <button @click="decreaseQuantity(item)"
                                                    class="px-3 py-2 sm:px-4 sm:py-2.5 text-gray-300 transition-all hover:bg-fuchsia-500/20 hover:text-fuchsia-400 disabled:cursor-not-allowed disabled:opacity-50 active:scale-95">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                <input type="number" :value="item.quantity"
                                                    @change="updateQuantity(item, $event.target.value)"
                                                    class="w-12 sm:w-16 border-x border-slate-700/50 bg-transparent py-2 sm:py-2.5 text-center text-sm sm:text-base font-semibold text-white focus:outline-none"
                                                    min="1" />
                                                <button @click="increaseQuantity(item)"
                                                    :disabled="item.quantity >= item.product.stock"
                                                    class="px-3 py-2 sm:px-4 sm:py-2.5 text-gray-300 transition-all hover:bg-fuchsia-500/20 hover:text-fuchsia-400 disabled:cursor-not-allowed disabled:opacity-50 active:scale-95">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <p class="text-sm font-bold text-fuchsia-400 whitespace-nowrap">
                                                ${{ (item.price * item.quantity).toFixed(2) }}
                                            </p>
                                        </div>

                                        <!-- Delete Button -->
                                        <button @click="removeItem(item)"
                                            class="flex items-center justify-center gap-2 rounded-xl bg-red-500/10 border border-red-500/30 px-3 sm:px-4 py-2.5 min-h-[44px] text-red-400 transition-all duration-200 hover:bg-red-500/20 hover:border-red-500/50 hover:scale-105 active:scale-95">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="hidden sm:inline font-semibold">Remove</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div
                        class="lg:sticky lg:top-4 rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 p-6 md:p-8 shadow-2xl shadow-fuchsia-500/20">
                        <h2
                            class="mb-6 text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400">
                            {{ t('cart.summary.title') }}
                        </h2>

                        <div class="space-y-4 border-b border-slate-700/50 pb-6 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-300">{{ t('cart.summary.subtotal') }}</span>
                                <span class="font-bold text-white">${{ subtotal.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-300">{{ t('cart.summary.total') }}</span>
                                <span class="font-bold text-white">${{ total.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-300 font-semibold">{{ t('cart.summary.grandTotal') }}</span>
                                <span
                                    class="font-bold text-lg bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400">
                                    {{ (total * 4050).toFixed(0) }} ៛
                                </span>
                            </div>
                            <div v-if="discount > 0" class="flex justify-between text-sm">
                                <span class="text-gray-300">{{ t('cart.summary.discount') }}</span>
                                <span class="font-bold text-green-400">-${{ discount.toFixed(2) }}</span>
                            </div>
                        </div>

                        <button @click="checkout" :disabled="isCheckingOut"
                            class="group flex w-full items-center justify-center gap-2 sm:gap-3 rounded-2xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-4 sm:px-6 py-3.5 sm:py-4 min-h-[52px] font-bold text-white shadow-2xl shadow-fuchsia-500/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-fuchsia-500/50 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:scale-100">
                            <svg v-if="!isCheckingOut" class="h-6 w-6 transition-transform group-hover:scale-110"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <svg v-else class="h-6 w-6 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span class="text-base sm:text-lg">{{ isCheckingOut ? 'Processing...' :
                                t('cart.checkout.button') + ' ('
                                + count + ')' }}</span>
                            <svg v-if="!isCheckingOut" class="h-5 w-5 transition-transform group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Continue Shopping Link -->
                        <a href="/"
                            class="mt-4 block text-center text-sm text-gray-400 hover:text-fuchsia-400 transition-colors duration-200">
                            ← Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Empty Cart State -->
            <div v-else class="mx-auto max-w-md py-16">
                <div
                    class="rounded-3xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 p-8 md:p-12 text-center shadow-2xl shadow-fuchsia-500/20">
                    <div class="mb-6 flex justify-center">
                        <div class="rounded-full bg-gradient-to-br from-fuchsia-500/20 to-pink-500/20 p-6">
                            <svg class="h-24 w-24 text-fuchsia-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="mb-3 text-2xl font-bold text-white">{{ t('cart.empty.title') }}</h2>
                    <p class="mb-8 text-gray-300">{{ t('cart.empty.description') }}</p>
                    <a :href="route('home')"
                        class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-8 py-4 font-bold text-white shadow-2xl shadow-fuchsia-500/30 transition-all duration-300 hover:scale-105 hover:shadow-fuchsia-500/50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ t('home.products.seeAll') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { router } from '@inertiajs/vue3'
    import { ref } from 'vue'
    import { useI18n } from 'vue-i18n'
    import { toast } from 'vue-sonner'

    const { t } = useI18n()

    const props = defineProps({
        cartItems: Array,
        subtotal: Number,
        total: Number,
        discount: Number,
        count: Number
    })

    const isCheckingOut = ref(false)

    const decreaseQuantity = (item) => {
        if (item.quantity > 1) {
            updateItemQuantity(item, item.quantity - 1)
        }
    }

    const increaseQuantity = (item) => {
        if (item.quantity < item.product.stock) {
            updateItemQuantity(item, item.quantity + 1)
        } else {
            toast.error(t('cart.item.maxStock'))
        }
    }

    const updateQuantity = (item, value) => {
        const quantity = parseInt(value)
        if (quantity > 0 && quantity <= item.product.stock) {
            updateItemQuantity(item, quantity)
        }
    }

    const updateItemQuantity = (item, quantity) => {
        router.put(route('cart.update', item.id), {
            quantity
        }, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                toast.success(t('cart.notifications.quantityUpdated'))
            },
            onError: () => {
                toast.error(t('cart.notifications.updateFailed'))
            }
        })
    }

    const removeItem = (item) => {
        if (confirm(t('cart.item.removeConfirm'))) {
            router.delete(route('cart.destroy', item.id), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    toast.success(t('cart.notifications.itemRemoved'))
                },
                onError: () => {
                    toast.error(t('cart.notifications.removeFailed'))
                }
            })
        }
    }

    const checkout = () => {
        isCheckingOut.value = true
        router.post(route('checkout'), {
            payment_method: 'khqr'
        }, {
            onSuccess: () => {
                toast.success(t('cart.notifications.orderPlaced'))
            },
            onError: () => {
                toast.error(t('cart.notifications.checkoutFailed'))
                isCheckingOut.value = false
            },
            onFinish: () => {
                isCheckingOut.value = false
            }
        })
    }

    const getCartImageUrl = (product) => {
        if (product.image_url && Array.isArray(product.image_url) && product.image_url.length > 0) {
            const imageUrl = product.image_url[0]
            if (!imageUrl.startsWith('http') && !imageUrl.startsWith('/')) {
                return `/storage/${imageUrl}`
            }
            return imageUrl
        }
        return '/placeholder.jpg'
    }
</script>

<style scoped>

    /* Remove number input spinner arrows */
    input[type='number']::-webkit-inner-spin-button,
    input[type='number']::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type='number'] {
        -moz-appearance: textfield;
        appearance: textfield;
    }
</style>
