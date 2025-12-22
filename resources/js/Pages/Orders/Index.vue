<template>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
                <p class="mt-2 text-gray-600">View and track your orders</p>
            </div>

            <!-- Orders List -->
            <div v-if="orders.data.length > 0" class="space-y-4">
                <Link v-for="order in orders.data" :key="order.id" :href="`/orders/${order.id}`"
                    class="block overflow-hidden rounded-lg bg-white shadow transition-shadow hover:shadow-lg">
                    <div class="p-6">
                        <!-- Order Header -->
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ order.order_number }}</h3>
                                    <span :class="[
                                        'inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                        getStatusClass(order.status)
                                    ]">
                                        {{ formatStatus(order.status) }}
                                    </span>
                                    <span :class="[
                                        'inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                        getPaymentStatusClass(order.payment_status)
                                    ]">
                                        {{ formatPaymentStatus(order.payment_status) }}
                                    </span>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ formatDate(order.created_at) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">${{ order.total_amount }}</p>
                                <p class="text-sm text-gray-500">{{ order.order_items.length }} items</p>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="mt-4 flex items-center space-x-4 overflow-x-auto">
                            <div v-for="item in order.order_items.slice(0, 3)" :key="item.id"
                                class="flex-shrink-0">
                                <div class="flex items-center space-x-3 rounded-lg border border-gray-200 bg-gray-50 p-3">
                                    <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-md bg-white">
                                        <img :src="getProductImage(item.product)" :alt="item.product_name"
                                            class="h-full w-full object-cover" />
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-gray-900">{{ item.product_name }}</p>
                                        <p class="text-xs text-gray-500">Qty: {{ item.quantity }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="order.order_items.length > 3"
                                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-md bg-gray-100 text-sm font-medium text-gray-600">
                                +{{ order.order_items.length - 3 }}
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-4">
                            <div class="flex items-center space-x-2">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Bakong KHQR Payment</span>
                            </div>
                            <div class="flex items-center text-sm text-blue-600 hover:text-blue-700">
                                View Details
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>

            <!-- Empty State -->
            <div v-else class="rounded-lg bg-white px-6 py-12 text-center shadow">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No orders yet</h3>
                <p class="mt-2 text-sm text-gray-500">Start shopping to create your first order!</p>
                <div class="mt-6">
                    <Link href="/" class="inline-flex items-center rounded-lg bg-pink-600 px-6 py-3 text-sm font-semibold text-white hover:bg-pink-700">
                        Start Shopping
                    </Link>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="orders.data.length > 0 && orders.last_page > 1" class="mt-6 flex items-center justify-center space-x-2">
                <Link v-for="page in orders.last_page" :key="page" :href="`/orders?page=${page}`"
                    :class="[
                        'rounded-lg px-4 py-2 text-sm font-medium transition-colors',
                        page === orders.current_page
                            ? 'bg-pink-600 text-white'
                            : 'bg-white text-gray-700 hover:bg-gray-50'
                    ]">
                    {{ page }}
                </Link>
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
    orders: {
        type: Object,
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
        return 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=100&h=100&fit=crop'
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

    return 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=100&h=100&fit=crop'
}
</script>
