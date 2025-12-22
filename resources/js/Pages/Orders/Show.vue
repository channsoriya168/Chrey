<template>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <Link href="/orders" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Orders
                </Link>
            </div>

            <!-- Order Header -->
            <div class="mb-6 overflow-hidden rounded-lg bg-white shadow">
                <div class="bg-gradient-to-r from-pink-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white">{{ order.order_number }}</h1>
                            <p class="mt-1 text-sm text-pink-100">
                                Placed on {{ formatDate(order.created_at) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span :class="[
                                'inline-flex rounded-full px-4 py-2 text-sm font-semibold',
                                getStatusClass(order.status)
                            ]">
                                {{ formatStatus(order.status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Order Info Grid -->
                <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-3">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Payment Status</h3>
                        <span :class="[
                            'mt-1 inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                            getPaymentStatusClass(order.payment_status)
                        ]">
                            {{ formatPaymentStatus(order.payment_status) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Payment Method</h3>
                        <div class="mt-1 flex items-center space-x-2">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Bakong KHQR</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Transaction ID</h3>
                        <p class="mt-1 truncate text-sm font-medium text-gray-900">
                            {{ order.bakong_transaction_id || 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Payment Actions -->
            <div v-if="order.payment_status === 'pending'" class="mb-6 rounded-lg border-2 border-orange-200 bg-orange-50 p-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-orange-900">Payment Pending</h3>
                            <p class="mt-1 text-sm text-orange-700">
                                Complete your payment to process this order
                            </p>
                        </div>
                    </div>
                    <Link :href="`/payment/khqr/${order.id}`"
                        class="inline-flex items-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700">
                        Pay Now
                    </Link>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6 overflow-hidden rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <div v-for="item in order.order_items" :key="item.id" class="px-6 py-4">
                        <div class="flex items-center space-x-4">
                            <!-- Product Image -->
                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
                                <img :src="getProductImage(item.product)" :alt="item.product_name"
                                    class="h-full w-full object-cover" />
                            </div>

                            <!-- Product Details -->
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-900">{{ item.product_name }}</h3>
                                <p class="mt-1 text-xs text-gray-500">Code: {{ item.product_code }}</p>
                                <div class="mt-2 flex items-center space-x-4 text-sm">
                                    <span class="text-gray-600">Unit Price: ${{ item.unit_price }}</span>
                                    <span class="text-gray-400">×</span>
                                    <span class="text-gray-600">Qty: {{ item.quantity }}</span>
                                </div>
                            </div>

                            <!-- Item Total -->
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Subtotal</p>
                                <p class="text-lg font-bold text-gray-900">${{ item.subtotal }}</p>
                                <p v-if="item.discount > 0" class="text-xs text-green-600">
                                    Discount: -${{ item.discount }}
                                </p>
                                <p class="text-sm font-semibold text-gray-900">Total: ${{ item.total }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-900">Order Summary</h2>
                </div>
                <div class="space-y-3 px-6 py-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-900">${{ order.subtotal }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-medium text-gray-900">${{ order.tax }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium text-gray-900">${{ order.shipping_cost }}</span>
                    </div>
                    <div v-if="order.discount > 0" class="flex justify-between text-sm">
                        <span class="text-gray-600">Discount</span>
                        <span class="font-medium text-green-600">-${{ order.discount }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between">
                            <span class="text-base font-semibold text-gray-900">Total Amount</span>
                            <span class="text-2xl font-bold text-gray-900">${{ order.total_amount }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div v-if="order.notes" class="mt-6 rounded-lg bg-blue-50 p-4">
                <h3 class="text-sm font-semibold text-blue-900">Order Notes</h3>
                <p class="mt-1 text-sm text-blue-700">{{ order.notes }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import FrontendLayout from '@/Layouts/FrontendLayout.vue'

defineOptions({
    layout: FrontendLayout
})

const props = defineProps({
    order: {
        type: Object,
        required: true
    },
    itemsSubtotal: {
        type: Number,
        required: true
    },
    itemsTotal: {
        type: Number,
        required: true
    }
})

const getStatusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        processing: 'bg-blue-100 text-blue-800',
        completed: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800',
        refunded: 'bg-gray-100 text-gray-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const getPaymentStatusClass = (status) => {
    const classes = {
        pending: 'bg-orange-100 text-orange-800',
        paid: 'bg-green-100 text-green-800',
        failed: 'bg-red-100 text-red-800',
        refunded: 'bg-purple-100 text-purple-800'
    }
    return classes[status] || 'bg-gray-100 text-gray-800'
}

const formatStatus = (status) => {
    return status.charAt(0).toUpperCase() + status.slice(1)
}

const formatPaymentStatus = (status) => {
    if (status === 'paid') return 'Paid'
    if (status === 'pending') return 'Payment Pending'
    if (status === 'failed') return 'Payment Failed'
    if (status === 'refunded') return 'Refunded'
    return status
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const getProductImage = (product) => {
    if (!product || !product.image_url) {
        return 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=200&h=200&fit=crop'
    }

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

    return 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=200&h=200&fit=crop'
}
</script>
