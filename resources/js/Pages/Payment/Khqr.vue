<template>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900">Bakong Payment</h1>
                <p class="mt-2 text-gray-600">Scan the QR code below to complete your payment</p>

                <!-- Test Mode Indicator -->
                <div v-if="order.bakong_transaction_id && order.bakong_transaction_id.startsWith('TEST-')"
                     class="mt-4 inline-flex items-center rounded-lg bg-yellow-50 px-4 py-2 text-sm font-medium text-yellow-800 border border-yellow-200">
                    <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Test Mode - Demo QR Code
                </div>
            </div>

            <!-- Payment Card -->
            <div class="overflow-hidden rounded-2xl bg-white shadow-lg">
                <!-- Order Summary -->
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-900">Order Summary</h2>
                    <div class="mt-3 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Order Number:</span>
                            <span class="font-medium text-gray-900">{{ order.order_number }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Amount:</span>
                            <span class="text-xl font-bold text-gray-900">${{ order.total_amount }}</span>
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="px-6 py-8">
                    <div class="flex flex-col items-center justify-center">
                        <!-- Payment Status -->
                        <div v-if="paymentStatus === 'paid'" class="mb-6 text-center">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                                <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-green-600">Payment Successful!</h3>
                            <p class="mt-2 text-gray-600">Your payment has been received.</p>
                        </div>

                        <!-- QR Code Display -->
                        <div v-else class="text-center">
                            <div class="mb-6">
                                <div class="mx-auto flex h-64 w-64 items-center justify-center rounded-xl bg-white p-4 shadow-md">
                                    <div v-if="qrData" class="flex items-center justify-center w-full h-full" v-html="qrData"></div>
                                    <div v-else class="text-gray-400">
                                        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-gray-900"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Instructions -->
                            <div class="space-y-3 text-sm text-gray-600">
                                <p class="font-medium text-gray-900">How to pay:</p>
                                <ol class="space-y-2 text-left">
                                    <li class="flex items-start">
                                        <span class="mr-2 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-semibold text-blue-600">1</span>
                                        <span>Open your Bakong app or any banking app</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-semibold text-blue-600">2</span>
                                        <span>Scan the QR code above</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-semibold text-blue-600">3</span>
                                        <span>Confirm the payment amount</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-semibold text-blue-600">4</span>
                                        <span>Complete the transaction</span>
                                    </li>
                                </ol>
                            </div>

                            <!-- Payment Status Indicator -->
                            <div class="mt-6 flex items-center justify-center space-x-2">
                                <div class="h-2 w-2 animate-pulse rounded-full bg-blue-600"></div>
                                <span class="text-sm text-gray-600">Waiting for payment...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="border-t border-gray-200 px-6 py-4">
                    <h3 class="mb-3 text-sm font-semibold text-gray-900">Order Items</h3>
                    <div class="space-y-2">
                        <div v-for="item in order.order_items" :key="item.id" class="flex justify-between text-sm">
                            <div class="flex items-center space-x-3">
                                <span class="text-gray-600">{{ item.product.name }}</span>
                                <span class="text-gray-400">×{{ item.quantity }}</span>
                            </div>
                            <span class="font-medium text-gray-900">${{ (item.price * item.quantity).toFixed(2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-between">
                        <Link :href="`/orders/${order.id}`"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                            View Order
                        </Link>
                        <button @click="checkStatus" :disabled="isChecking"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50">
                            <span v-if="!isChecking">Check Payment Status</span>
                            <span v-else class="flex items-center">
                                <svg class="mr-2 h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Checking...
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 rounded-lg bg-blue-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Your order will be processed once the payment is confirmed. This usually takes a few seconds.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import FrontendLayout from '@/Layouts/FrontendLayout.vue'

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
    0%, 100% {
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