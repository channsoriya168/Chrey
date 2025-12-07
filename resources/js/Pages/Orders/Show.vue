<template>
    <FrontendLayout>
        <Head title="Order Details" />

        <div class="min-h-screen bg-gray-50 py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <nav class="mb-8 flex items-center space-x-2 text-sm">
                    <Link href="/" class="text-gray-500 hover:text-pink-600">Home</Link>
                    <span class="text-gray-400">/</span>
                    <Link href="/orders" class="text-gray-500 hover:text-pink-600">Orders</Link>
                    <span class="text-gray-400">/</span>
                    <span class="font-medium text-gray-900">Order #{{ order.id }}</span>
                </nav>

                <!-- Page Header -->
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Order #{{ order.id }}</h1>
                        <p class="mt-2 text-gray-600">Placed on {{ formatDate(order.created_at) }}</p>
                    </div>
                    <Link
                        href="/orders"
                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50"
                    >
                        ← Back to Orders
                    </Link>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Order Items -->
                    <div class="lg:col-span-2">
                        <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                            <div class="border-b border-gray-200 px-6 py-4">
                                <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
                            </div>

                            <div class="divide-y divide-gray-200">
                                <div
                                    v-for="item in order.order_items"
                                    :key="item.id"
                                    class="flex gap-4 px-6 py-4"
                                >
                                    <!-- Product Image -->
                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-lg border border-gray-200">
                                        <img
                                            v-if="item.product?.image_url && item.product.image_url.length > 0"
                                            :src="`/storage/${item.product.image_url[0]}`"
                                            :alt="item.product?.name"
                                            class="h-full w-full object-cover"
                                        />
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex flex-1 flex-col justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                {{ item.product?.name }}
                                            </h3>
                                            <p class="mt-1 text-sm text-gray-600">${{ item.price }} each</p>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Quantity: {{ item.quantity }}</span>
                                            <span class="text-lg font-semibold text-gray-900">
                                                ${{ (item.price * item.quantity).toFixed(2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="space-y-6">
                            <!-- Order Status -->
                            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                                <div class="border-b border-gray-200 px-6 py-4">
                                    <h2 class="text-lg font-semibold text-gray-900">Order Status</h2>
                                </div>
                                <div class="px-6 py-4">
                                    <div class="space-y-3">
                                        <div>
                                            <p class="text-sm text-gray-600">Status</p>
                                            <span
                                                :class="[
                                                    'mt-1 inline-flex items-center rounded-full px-3 py-1 text-sm font-medium',
                                                    getStatusClass(order.status)
                                                ]"
                                            >
                                                {{ order.status }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Payment Status</p>
                                            <span
                                                :class="[
                                                    'mt-1 inline-flex items-center rounded-full px-3 py-1 text-sm font-medium',
                                                    getPaymentStatusClass(order.payment_status)
                                                ]"
                                            >
                                                {{ order.payment_status }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Payment Method</p>
                                            <p class="mt-1 font-medium text-gray-900">{{ order.payment_method }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Total -->
                            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                                <div class="border-b border-gray-200 px-6 py-4">
                                    <h2 class="text-lg font-semibold text-gray-900">Order Summary</h2>
                                </div>
                                <div class="px-6 py-4">
                                    <div class="space-y-3">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span class="font-medium text-gray-900">${{ subtotal?.toFixed(2) }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Shipping</span>
                                            <span class="font-medium text-green-600">Free</span>
                                        </div>
                                        <div class="border-t border-gray-200 pt-3">
                                            <div class="flex justify-between">
                                                <span class="text-lg font-semibold text-gray-900">Total</span>
                                                <span class="text-lg font-bold text-pink-600">
                                                    ${{ total?.toFixed(2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Info -->
                            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                                <div class="border-b border-gray-200 px-6 py-4">
                                    <h2 class="text-lg font-semibold text-gray-900">Customer Information</h2>
                                </div>
                                <div class="px-6 py-4">
                                    <div class="space-y-2">
                                        <p class="font-medium text-gray-900">{{ order.user?.name }}</p>
                                        <p class="text-sm text-gray-600">{{ order.user?.email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>

<script setup>
import { Link, Head } from '@inertiajs/vue3'
import FrontendLayout from '@/Layouts/FrontendLayout.vue'

const props = defineProps({
    order: {
        type: Object,
        required: true
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

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const getStatusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-50 text-yellow-700 ring-1 ring-inset ring-yellow-600/20',
        processing: 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20',
        shipped: 'bg-purple-50 text-purple-700 ring-1 ring-inset ring-purple-600/20',
        delivered: 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20',
        cancelled: 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20'
    }
    return classes[status] || classes.pending
}

const getPaymentStatusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-50 text-yellow-700 ring-1 ring-inset ring-yellow-600/20',
        paid: 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20',
        failed: 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20'
    }
    return classes[status] || classes.pending
}
</script>