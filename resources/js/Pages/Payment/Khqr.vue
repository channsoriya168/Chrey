<template>
    <div class="min-h-screen bg-gradient-to-br from-purple-900 via-slate-900 to-slate-950 py-6 sm:py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 sm:mb-8 text-center">
                <h1
                    class="text-3xl sm:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400">
                    Bakong Payment</h1>
                <p class="mt-2 text-sm sm:text-base text-gray-300">Scan the QR code below to complete your payment</p>

                <!-- Test Mode Indicator -->
                <div v-if="order.bakong_transaction_id && order.bakong_transaction_id.startsWith('TEST-')"
                    class="mt-4 inline-flex items-center rounded-xl bg-yellow-500/10 border border-yellow-500/30 backdrop-blur-sm px-4 py-2 text-xs sm:text-sm font-semibold text-yellow-400">
                    <svg class="mr-2 h-4 w-4 sm:h-5 sm:w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Test Mode - Demo QR Code
                </div>
            </div>

            <!-- Payment Card -->
            <div
                class="overflow-hidden rounded-3xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 shadow-2xl shadow-fuchsia-500/20">
                <!-- Order Summary -->
                <div class="border-b border-slate-700/50 bg-slate-900/60 px-4 sm:px-6 py-4">
                    <h2 class="text-lg sm:text-xl font-bold text-white">Order Summary</h2>
                    <div class="mt-3 space-y-2">
                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-300">Order Number:</span>
                            <span class="font-semibold text-white">{{ order.order_number }}</span>
                        </div>
                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-300">Total Amount:</span>
                            <span
                                class="text-xl sm:text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400">${{
                                order.total_amount }}</span>
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="px-4 sm:px-6 py-6 sm:py-8">
                    <div class="flex flex-col items-center justify-center">
                        <!-- Payment Status -->
                        <div v-if="paymentStatus === 'paid'" class="mb-6 text-center">
                            <div
                                class="mx-auto mb-4 flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-green-500/20 border-2 border-green-500">
                                <svg class="h-10 w-10 sm:h-12 sm:w-12 text-green-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-green-400">Payment Successful!</h3>
                            <p class="mt-2 text-sm sm:text-base text-gray-300">Your payment has been received.</p>
                        </div>

                        <!-- QR Code Display -->
                        <div v-else class="text-center w-full">
                            <div class="mb-6 flex justify-center">
                                <div
                                    class="flex h-56 w-56 sm:h-64 sm:w-64 items-center justify-center rounded-2xl bg-white p-3 sm:p-4 shadow-xl shadow-fuchsia-500/20 ring-2 ring-fuchsia-500/30">
                                    <div v-if="qrData" class="flex items-center justify-center w-full h-full"
                                        v-html="qrData"></div>
                                    <div v-else class="text-gray-400">
                                        <div
                                            class="animate-spin rounded-full h-12 w-12 sm:h-16 sm:w-16 border-4 border-t-fuchsia-500 border-r-pink-500 border-b-purple-500 border-l-slate-300">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Instructions -->
                            <div class="space-y-3 text-xs sm:text-sm text-gray-300 max-w-md mx-auto">
                                <p class="font-semibold text-white text-sm sm:text-base">How to pay:</p>
                                <ol class="space-y-2 text-left">
                                    <li class="flex items-start">
                                        <span
                                            class="mr-2 sm:mr-3 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-fuchsia-500 to-pink-500 text-xs font-bold text-white shadow-lg">1</span>
                                        <span>Open your Bakong app or any banking app</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span
                                            class="mr-2 sm:mr-3 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-fuchsia-500 to-pink-500 text-xs font-bold text-white shadow-lg">2</span>
                                        <span>Scan the QR code above</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span
                                            class="mr-2 sm:mr-3 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-fuchsia-500 to-pink-500 text-xs font-bold text-white shadow-lg">3</span>
                                        <span>Confirm the payment amount</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span
                                            class="mr-2 sm:mr-3 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-fuchsia-500 to-pink-500 text-xs font-bold text-white shadow-lg">4</span>
                                        <span>Complete the transaction</span>
                                    </li>
                                </ol>
                            </div>

                            <!-- Payment Status Indicator -->
                            <div class="mt-6 flex items-center justify-center gap-2">
                                <div class="h-2 w-2 animate-pulse rounded-full bg-fuchsia-400"></div>
                                <span class="text-xs sm:text-sm text-gray-300 font-medium">Waiting for payment...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="border-t border-slate-700/50 px-4 sm:px-6 py-4">
                    <h3 class="mb-3 text-sm sm:text-base font-bold text-white">Order Items</h3>
                    <div class="space-y-2">
                        <div v-for="item in order.order_items" :key="item.id"
                            class="flex justify-between items-center text-xs sm:text-sm">
                            <div class="flex items-center gap-2 sm:gap-3 flex-1">
                                <span class="text-gray-300">{{ item.product.name }}</span>
                                <span class="text-gray-500">×{{ item.quantity }}</span>
                            </div>
                            <span class="font-semibold text-fuchsia-400">${{ (item.price * item.quantity).toFixed(2)
                                }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="border-t border-slate-700/50 bg-slate-900/60 px-4 sm:px-6 py-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-between">
                        <Link :href="`/orders/${order.id}`"
                            class="inline-flex items-center justify-center rounded-xl border border-fuchsia-500/30 bg-slate-800/60 backdrop-blur-sm px-4 py-2.5 text-sm font-semibold text-gray-300 hover:border-fuchsia-500/50 hover:text-white transition-all duration-200">
                            View Order
                        </Link>
                        <button @click="checkStatus" :disabled="isChecking"
                            class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/30 hover:scale-105 hover:shadow-fuchsia-500/50 transition-all duration-200 disabled:opacity-50 disabled:hover:scale-100">
                            <span v-if="!isChecking">Check Payment Status</span>
                            <span v-else class="flex items-center">
                                <svg class="mr-2 h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Checking...
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 rounded-2xl bg-fuchsia-500/10 backdrop-blur-sm border border-fuchsia-500/20 p-4">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-fuchsia-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm text-gray-300">
                            Your order will be processed once the payment is confirmed. This usually takes a few
                            seconds.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import FrontendLayout from '@/Layouts/FrontendLayout.vue'
    import { Link, router } from '@inertiajs/vue3'
    import { onMounted, onUnmounted, ref } from 'vue'

    defineOptions({
        layout: FrontendLayout
    })

    const props = defineProps({
        order: {
            type: Object,
            required: true
        },
        qrData: {
            type: String,
            required: false
        }
    })

    const paymentStatus = ref(props.order.payment_status)
    const isChecking = ref(false)
    let statusCheckInterval = null

    // Check payment status
    const checkStatus = async () => {
        if (isChecking.value) return

        isChecking.value = true

        try {
            const response = await fetch(`/payment/status/${props.order.id}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })

            const data = await response.json()

            if (data.status === 'paid') {
                paymentStatus.value = 'paid'
                clearInterval(statusCheckInterval)

                // Redirect to order page after a delay
                setTimeout(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect
                    } else {
                        router.visit(`/orders/${props.order.id}`)
                    }
                }, 2000)
            }
        } catch (error) {
            console.error('Error checking payment status:', error)
        } finally {
            isChecking.value = false
        }
    }

    // Auto-check payment status every 5 seconds
    onMounted(() => {
        if (paymentStatus.value !== 'paid') {
            statusCheckInterval = setInterval(checkStatus, 5000)
        }
    })

    onUnmounted(() => {
        if (statusCheckInterval) {
            clearInterval(statusCheckInterval)
        }
    })
</script>

<style scoped>
    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>