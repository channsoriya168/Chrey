<template>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-900">{{ t('cart.title') }}</h1>
        </div>

        <!-- Cart Content -->
        <div v-if="cartItems.length > 0" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Cart Items Section -->
            <div class="lg:col-span-2">
                <!-- Cart Items Card -->
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <!-- Cart Items -->
                    <div v-for="item in cartItems" :key="item.id" class="border-b p-4 last:border-b-0">
                        <div class="flex gap-4">
                            <!-- Product Image -->
                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg">
                                <img :src="item.product.image_url[0] || '/placeholder.jpg'" :alt="item.product.name"
                                    class="h-full w-full object-cover" />
                            </div>

                            <!-- Product Details -->
                            <div class="flex flex-1 flex-col justify-between">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ item.product.name }}</h3>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">${{ item.price }}</p>
                                    </div>
                                </div>

                                <div class="mt-2 flex items-center justify-between">
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-600">{{ t('product.quantity') }}:</span>
                                        <div class="flex items-center rounded-lg border">
                                            <button @click="decreaseQuantity(item)" class="px-3 py-1 hover:bg-gray-100">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input type="number" :value="item.quantity"
                                                @change="updateQuantity(item, $event.target.value)"
                                                class="w-16 border-x py-1 text-center" min="1" />
                                            <button @click="increaseQuantity(item)" class="px-3 py-1 hover:bg-gray-100">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-sm text-gray-600">${{ (item.price * item.quantity).toFixed(2)
                                            }}</p>
                                    </div>

                                    <!-- Delete Button -->
                                    <button @click="removeItem(item)" class="text-red-600 hover:text-red-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Stock Info -->
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ t('product.available') }}: {{ item.product.stock }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-4 rounded-lg bg-white p-6 shadow">
                    <h2 class="mb-4 text-lg font-semibold text-gray-900">{{ t('cart.summary.title') }}</h2>

                    <div class="space-y-3 border-b pb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ t('cart.summary.subtotal') }}</span>
                            <span class="font-semibold">${{ subtotal.toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ t('cart.summary.total') }}</span>
                            <span class="font-semibold">${{ total.toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ t('cart.summary.total') }}</span>
                            <span class="font-semibold">${{ total.toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ t('cart.summary.grandTotal') }}</span>
                            <span class="font-semibold">{{ (total * 4050).toFixed(0) }} KHR</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ t('cart.summary.discount') }}</span>
                            <span class="font-semibold text-red-600">${{ discount.toFixed(2) }}</span>
                        </div>
                    </div>

                    <button @click="checkout" :disabled="isCheckingOut"
                        class="mt-4 flex w-full items-center justify-between rounded-full bg-pink-600 px-6 py-3 text-white hover:bg-pink-700 disabled:opacity-50">
                        <span class="font-semibold">{{ t('cart.checkout.button') }} ( {{ count }} )</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Empty Cart State -->
        <div v-else class="mx-auto max-w-md py-16 text-center">
            <div class="mb-4">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <h2 class="mb-2 text-xl font-semibold text-gray-900">{{ t('cart.empty.title') }}</h2>
            <p class="mb-6 text-gray-600">{{ t('cart.empty.description') }}</p>
            <a :href="route('home')"
                class="inline-block rounded-lg bg-pink-600 px-6 py-3 font-semibold text-white hover:bg-pink-700">
                {{ t('home.products.seeAll') }}
            </a>
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
        router.post(route('checkout'), {}, {
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
</script>
