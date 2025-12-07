<template>
    <FrontendLayout>
        <Head title="My Orders" />

        <div class="min-h-screen bg-gray-50 py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <nav class="mb-8 flex items-center space-x-2 text-sm">
                    <Link href="/" class="text-gray-500 hover:text-pink-600">Home</Link>
                    <span class="text-gray-400">/</span>
                    <span class="font-medium text-gray-900">My Orders</span>
                </nav>

                <!-- Page Title -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
                    <p class="mt-2 text-gray-600">View and track your order history</p>
                </div>

                <!-- Orders List -->
                <div v-if="orders.data.length > 0" class="space-y-4">
                    <div
                        v-for="order in orders.data"
                        :key="order.id"
                        class="overflow-hidden rounded-lg bg-white shadow-sm transition-shadow hover:shadow-md"
                    >
                        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-6">
                                    <div>
                                        <p class="text-sm text-gray-600">Order Number</p>
                                        <p class="font-semibold text-gray-900">#{{ order.id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Order Date</p>
                                        <p class="font-medium text-gray-900">{{ formatDate(order.created_at) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Total</p>
                                        <p class="font-semibold text-pink-600">${{ order.total?.toFixed(2) }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span
                                        :class="[
                                            'inline-flex items-center rounded-full px-3 py-1 text-xs font-medium',
                                            getStatusClass(order.status)
                                        ]"
                                    >
                                        {{ order.status }}
                                    </span>
                                    <Link
                                        :href="route('orders.show', order.id)"
                                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50"
                                    >
                                        View Details
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4">
                            <div class="space-y-3">
                                <div
                                    v-for="item in order.order_items.slice(0, 3)"
                                    :key="item.id"
                                    class="flex items-center gap-4"
                                >
                                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                        <img
                                            v-if="item.product?.image_url && item.product.image_url.length > 0"
                                            :src="`/storage/${item.product.image_url[0]}`"
                                            :alt="item.product?.name"
                                            class="h-full w-full object-cover"
                                        />
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ item.product?.name }}</p>
                                        <p class="text-sm text-gray-600">
                                            Qty: {{ item.quantity }} × ${{ item.price }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">
                                            ${{ (item.price * item.quantity).toFixed(2) }}
                                        </p>
                                    </div>
                                </div>

                                <div v-if="order.order_items.length > 3" class="pt-2 text-sm text-gray-600">
                                    +{{ order.order_items.length - 3 }} more item(s)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="rounded-lg bg-white p-12 text-center shadow-sm">
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
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                        />
                    </svg>
                    <h2 class="mt-4 text-xl font-semibold text-gray-900">No orders yet</h2>
                    <p class="mt-2 text-gray-600">Start shopping to create your first order!</p>
                    <Link
                        href="/"
                        class="mt-6 inline-block rounded-lg bg-pink-600 px-6 py-3 font-semibold text-white transition-colors hover:bg-pink-700"
                    >
                        Start Shopping
                    </Link>
                </div>

                <!-- Pagination -->
                <div v-if="orders.data.length > 0 && orders.last_page > 1" class="mt-8 flex justify-center">
                    <nav class="inline-flex rounded-md shadow-sm">
                        <button
                            v-for="page in orders.last_page"
                            :key="page"
                            @click="changePage(page)"
                            :class="[
                                'relative inline-flex items-center px-4 py-2 text-sm font-medium',
                                page === orders.current_page
                                    ? 'z-10 bg-pink-600 text-white'
                                    : 'bg-white text-gray-700 hover:bg-gray-50'
                            ]"
                        >
                            {{ page }}
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>

<script setup>
import { Link, router, Head } from '@inertiajs/vue3'
import FrontendLayout from '@/Layouts/FrontendLayout.vue'

const props = defineProps({
    orders: {
        type: Object,
        required: true
    }
})

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
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

const changePage = (page) => {
    router.get(route('orders.index', { page }))
}
</script>