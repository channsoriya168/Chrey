<template>

    <Head title="Checkout - Delivery Address" />
    <div class="min-h-screen bg-gradient-to-br from-purple-900 via-slate-900 to-slate-950">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-4 flex items-center space-x-2 text-sm">
                <a href="/"
                    class="group flex items-center gap-1 rounded-lg px-2 py-1.5 text-gray-400 transition-all hover:bg-slate-800/60 hover:text-fuchsia-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>{{ $t('checkout.breadcrumb.home') }}</span>
                </a>
                <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a :href="route('cart.index')"
                    class="group flex items-center gap-1 rounded-lg px-2 py-1.5 text-gray-400 transition-all hover:bg-slate-800/60 hover:text-fuchsia-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>{{ $t('checkout.breadcrumb.cart') }}</span>
                </a>
                <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span
                    class="flex items-center gap-1 rounded-lg bg-gradient-to-r from-fuchsia-500/20 to-pink-500/20 border border-fuchsia-500/30 px-2 py-1.5 font-medium text-white backdrop-blur-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ $t('checkout.breadcrumb.checkout') }}</span>
                </span>
            </nav>

            <!-- Checkout Content -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                <!-- Address Form Section -->
                <div class="lg:col-span-2">
                    <div
                        class="rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 p-5 shadow-2xl shadow-fuchsia-500/20">
                        <div class="mb-5 flex items-center gap-2.5">
                            <div class="rounded-lg bg-gradient-to-br from-fuchsia-500/20 to-pink-500/20 p-2">
                                <svg class="h-5 w-5 text-fuchsia-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">{{ $t('checkout.delivery.title') }}</h2>
                                <p class="text-xs text-gray-400">{{ $t('checkout.delivery.subtitle') }}</p>
                            </div>
                        </div>

                        <form @submit.prevent="submitOrder" class="space-y-4">
                            <!-- Phone -->
                            <div class="group">
                                <label class="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-300">
                                    <svg class="h-4 w-4 text-fuchsia-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $t('checkout.delivery.phone') }} <span class="text-red-400">*</span>
                                </label>
                                <div class="relative">
                                    <input v-model="form.phone" type="tel" required
                                        class="w-full rounded-lg bg-slate-900/80 border-2 px-3 py-2.5 text-white placeholder-gray-500 transition-all focus:outline-none"
                                        :class="errors.phone ? 'border-red-500/50 focus:border-red-500 focus:ring-2 focus:ring-red-500/20' : 'border-slate-700/50 focus:border-fuchsia-500/50 focus:ring-2 focus:ring-fuchsia-500/20'"
                                        placeholder="012 345 678" />
                                    <div v-if="errors.phone" class="mt-2 flex items-center gap-2 text-sm text-red-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ errors.phone }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Province -->
                            <div class="group">
                                <label class="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-300">
                                    <svg class="h-4 w-4 text-fuchsia-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $t('checkout.delivery.province') }} <span class="text-red-400">*</span>
                                </label>
                                <input v-model="form.province" type="text" required
                                    class="w-full rounded-lg bg-slate-900/80 border-2 px-3 py-2.5 text-white placeholder-gray-500 transition-all focus:outline-none"
                                    :class="errors.province ? 'border-red-500/50 focus:border-red-500 focus:ring-2 focus:ring-red-500/20' : 'border-slate-700/50 focus:border-fuchsia-500/50 focus:ring-2 focus:ring-fuchsia-500/20'"
                                    :placeholder="$t('checkout.delivery.provincePlaceholder')" />
                                <p v-if="errors.province" class="mt-2 flex items-center gap-2 text-sm text-red-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ errors.province }}</span>
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- District -->
                                <div class="group">
                                    <label class="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-300">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        {{ $t('checkout.delivery.district') }}
                                    </label>
                                    <input v-model="form.district" type="text"
                                        class="w-full rounded-lg bg-slate-900/80 border-2 border-slate-700/50 px-3 py-2.5 text-white placeholder-gray-500 transition-all focus:border-fuchsia-500/50 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/20"
                                        :placeholder="$t('checkout.delivery.districtPlaceholder')" />
                                </div>

                                <!-- Commune -->
                                <div class="group">
                                    <label class="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-300">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                        </svg>
                                        {{ $t('checkout.delivery.commune') }}
                                    </label>
                                    <input v-model="form.commune" type="text"
                                        class="w-full rounded-lg bg-slate-900/80 border-2 border-slate-700/50 px-3 py-2.5 text-white placeholder-gray-500 transition-all focus:border-fuchsia-500/50 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/20"
                                        :placeholder="$t('checkout.delivery.communePlaceholder')" />
                                </div>
                            </div>

                            <!-- Village -->
                            <div class="group">
                                <label class="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-300">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    {{ $t('checkout.delivery.village') }}
                                </label>
                                <input v-model="form.village" type="text"
                                    class="w-full rounded-lg bg-slate-900/80 border-2 border-slate-700/50 px-3 py-2.5 text-white placeholder-gray-500 transition-all focus:border-fuchsia-500/50 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/20"
                                    :placeholder="$t('checkout.delivery.villagePlaceholder')" />
                            </div>

                            <!-- Note -->
                            <div class="group">
                                <label class="mb-2 flex items-center gap-2 text-sm font-semibold text-gray-300">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    {{ $t('checkout.delivery.note') }}
                                </label>
                                <textarea v-model="form.note" rows="3"
                                    class="w-full rounded-lg bg-slate-900/80 border-2 border-slate-700/50 px-3 py-2.5 text-white placeholder-gray-500 transition-all focus:border-fuchsia-500/50 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/20 resize-none"
                                    :placeholder="$t('checkout.delivery.notePlaceholder')"></textarea>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div
                        class="lg:sticky lg:top-4 rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 p-5 shadow-2xl shadow-fuchsia-500/20">
                        <h2 class="text-lg font-bold text-white mb-4 pb-3 border-b border-slate-700/50">{{
                            $t('checkout.summary.title') }}
                        </h2>

                        <!-- Order Items -->
                        <div
                            class="space-y-2 border-b border-slate-700/50 pb-3 mb-3 max-h-48 overflow-y-auto scrollbar-hide">
                            <div v-for="item in cartItems" :key="item.id"
                                class="flex gap-3 p-2 rounded-lg bg-slate-900/40 hover:bg-slate-900/60 transition-colors">
                                <div class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-md bg-slate-700">
                                    <img :src="item.product.first_image || '/placeholder.jpg'" :alt="item.product.name"
                                        class="h-full w-full object-cover" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-white mb-1 line-clamp-2">{{ item.product.name
                                    }}</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs text-gray-400">{{ $t('checkout.summary.quantity') }}: {{
                                            item.quantity }}</p>
                                        <p class="text-sm font-bold text-fuchsia-400">${{ (item.price *
                                            item.quantity).toFixed(2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <div class="space-y-2 border-b border-slate-700/50 pb-3 mb-3">

                            <div class="flex justify-between pt-3 border-t border-slate-700/50 font-semibold">
                                <span class="text-gray-300">{{ $t('checkout.summary.total') }} ($)</span>
                                <span class="text-white text-lg">${{ total.dollar.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-1">
                                <span class="text-gray-400 text-sm">{{ $t('checkout.summary.total') }} (៛)</span>
                                <span
                                    class="font-bold text-lg bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400">
                                    {{ (total.riel).toFixed(0) }} ៛
                                </span>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button @click="submitOrder" :disabled="isSubmitting || !isFormValid"
                            class="group flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-5 py-3 font-bold text-white shadow-xl shadow-fuchsia-500/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-fuchsia-500/50 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:scale-100">
                            <svg v-if="!isSubmitting" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <svg v-else class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>{{ isSubmitting ? $t('checkout.button.processing') : $t('checkout.button.placeOrder')
                                }}</span>
                        </button>

                        <!-- Back to Cart Link -->
                        <a :href="route('cart.index')"
                            class="mt-3 flex items-center justify-center gap-1.5 text-sm text-gray-400 hover:text-fuchsia-400 transition-colors duration-200 group">
                            <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>{{ $t('checkout.button.backToCart') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- KHQR Payment Modal -->
        <KhqrPaymentModal :show="showPaymentModal" :order="currentOrder" :qrData="qrData" @close="closePaymentModal" />
    </div>
</template>

<script setup>
    import KhqrPaymentModal from '@/Components/KhqrPaymentModal.vue'
    import { Head } from '@inertiajs/vue3'
    import axios from 'axios'
    import { computed, ref } from 'vue'
    import { useI18n } from 'vue-i18n'
    import { toast } from 'vue-sonner'

    const { t } = useI18n()

    const props = defineProps({
        cartItems: Array,
        total: Object,
        errors: {
            type: Object,
            default: () => ({})
        }
    })

    const form = ref({
        phone: '',
        province: '',
        district: '',
        commune: '',
        village: '',
        note: ''
    })

    const isSubmitting = ref(false)

    const showPaymentModal = ref(false)
    const currentOrder = ref({})
    const qrData = ref('')
    const md5 = ref('')

    const isFormValid = computed(() => {
        return form.value.phone.trim() !== '' && form.value.province.trim() !== ''
    })

    const submitOrder = async () => {
        if (!isFormValid.value) {
            toast.error(t('checkout.validation.phoneRequired') + ' ' + t('checkout.validation.provinceRequired'))
            return
        }

        isSubmitting.value = true

        try {

            const response = await axios.post(route('checkout'), form.value, {
                headers: {
                    'Accept': 'application/json'
                }
            })

            if (response.data.success) {
                // Set current order with QR code
                currentOrder.value = response.data.cart

                // Store md5 for payment status checking
                md5.value = response.data.md5

                // Ensure qrData is a string
                if (typeof response.data.qrData === 'string') {
                    qrData.value = response.data.qrData
                } else if (response.data.qrData) {
                    console.error('QR Data is not a string:', typeof response.data.qrData, response.data.qrData)
                    qrData.value = String(response.data.qrData)
                }

                // Show payment modal
                showPaymentModal.value = true

                toast.success(t('cart.notifications.orderPlaced'))
            } else {
                console.error('Checkout failed:', response.data)
                toast.error(response.data.message || t('cart.notifications.checkoutFailed'))
            }
        } catch (error) {
            console.error('Checkout error:', error)
            if (error.response) {
                console.error('Error response:', error.response.data)
                toast.error(error.response.data.message || t('cart.notifications.checkoutFailed'))
            } else {
                toast.error(t('cart.notifications.checkoutFailed'))
            }
        } finally {
            isSubmitting.value = false
        }
    }

    const closePaymentModal = () => {
        showPaymentModal.value = false
    }

    setInterval(async () => {
        if (showPaymentModal.value && currentOrder.value.id && md5.value) {
            try {
                const response = await axios.get(route('payment.status', {
                    cart: currentOrder.value.id,
                    md5: md5.value
                }), {
                    headers: {
                        'Accept': 'application/json'
                    }
                })

                console.log('Payment status:', response.data.status)

                if (response.data.status === 'paid') {
                    toast.success(t('cart.notifications.paymentSuccess'))
                    showPaymentModal.value = false
                    window.location.href = '/'
                }
            } catch (error) {
                console.error('Payment status check error:', error)
                if (error.response) {
                    console.error('Error response:', error.response.data)
                }
            }
        }
    }, 5000)
</script>

<style scoped>

    /* Hide scrollbar */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
