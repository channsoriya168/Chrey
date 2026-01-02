<template>
    <div class="min-h-screen bg-gradient-to-br from-purple-900 via-slate-900 to-slate-950">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:py-8 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 sm:mb-8">
                <h1
                    class="text-3xl sm:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400">
                    My Orders</h1>
                <p class="mt-2 text-sm sm:text-base text-gray-300">View and track your orders</p>
            </div>

            <!-- Orders List -->
            <div v-if="orders.data.length > 0" class="space-y-3 sm:space-y-4">
                <Link v-for="order in orders.data" :key="order.id" :href="`/orders/${order.id}`"
                    class="block overflow-hidden rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 shadow-lg shadow-fuchsia-500/10 transition-all duration-300 hover:border-fuchsia-500/40 hover:shadow-xl hover:shadow-fuchsia-500/20 hover:scale-[1.01]">
                    <div class="p-4 sm:p-6">
                        <!-- Order Header -->
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-4">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                    <h3 class="text-base sm:text-lg font-semibold text-white">{{ order.order_number }}
                                    </h3>
                                    <span :class="[
                                        'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                                        getStatusClass(order.status)
                                    ]">
                                        {{ formatStatus(order.status) }}
                                    </span>
                                    <span :class="[
                                        'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                                        getPaymentStatusClass(order.payment_status)
                                    ]">
                                        {{ formatPaymentStatus(order.payment_status) }}
                                    </span>
                                </div>
                                <p class="mt-1.5 text-xs sm:text-sm text-gray-400">
                                    {{ formatDate(order.created_at) }}
                                </p>
                            </div>
                            <div class="text-left sm:text-right">
                                <p
                                    class="text-xl sm:text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400">
                                    ${{ order.total_amount }}</p>
                                <p class="text-xs sm:text-sm text-gray-400">{{ order.order_items.length }} items</p>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="mt-4 flex items-center gap-3 sm:gap-4 overflow-x-auto pb-2">
                            <div v-for="item in order.order_items.slice(0, 3)" :key="item.id" class="flex-shrink-0">
                                <div
                                    class="flex items-center gap-2 sm:gap-3 rounded-xl border border-slate-700/50 bg-slate-900/60 p-2 sm:p-3">
                                    <div
                                        class="h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 overflow-hidden rounded-lg bg-slate-700 ring-2 ring-fuchsia-500/30">
                                        <img :src="getProductImage(item.product)" :alt="item.product_name"
                                            class="h-full w-full object-cover" />
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-xs sm:text-sm font-medium text-white">{{
                                            item.product_name }}</p>
                                        <p class="text-xs text-gray-400">Qty: {{ item.quantity }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="order.order_items.length > 3"
                                class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-lg bg-slate-700/50 text-xs sm:text-sm font-medium text-fuchsia-400 border border-fuchsia-500/30">
                                +{{ order.order_items.length - 3 }}
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div
                            class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 border-t border-slate-700/50 pt-4">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-fuchsia-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <span class="text-xs sm:text-sm text-gray-300">Bakong KHQR Payment</span>
                            </div>
                            <div
                                class="flex items-center text-xs sm:text-sm text-fuchsia-400 hover:text-fuchsia-300 font-medium transition-colors">
                                View Details
                                <svg class="ml-1 h-3 w-3 sm:h-4 sm:w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>

            <!-- Empty State -->
            <div v-else
                class="rounded-3xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 px-6 py-12 sm:py-16 text-center shadow-2xl shadow-fuchsia-500/20">
                <div
                    class="mx-auto mb-6 rounded-full bg-gradient-to-br from-fuchsia-500/20 to-pink-500/20 p-4 sm:p-6 w-fit">
                    <svg class="h-16 w-16 sm:h-20 sm:w-20 text-fuchsia-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-white">No orders yet</h3>
                <p class="mt-2 text-sm sm:text-base text-gray-300">Start shopping to create your first order!</p>
                <div class="mt-6 sm:mt-8">
                    <Link href="/"
                        class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-bold text-white shadow-2xl shadow-fuchsia-500/30 transition-all duration-300 hover:scale-105 hover:shadow-fuchsia-500/50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Start Shopping
                    </Link>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="orders.data.length > 0 && orders.last_page > 1"
                class="mt-6 flex flex-wrap items-center justify-center gap-2">
                <Link v-for="page in orders.last_page" :key="page" :href="`/orders?page=${page}`" :class="[
                    'rounded-xl px-4 py-2 text-sm font-semibold transition-all duration-200',
                    page === orders.current_page
                        ? 'bg-gradient-to-r from-fuchsia-500 to-pink-500 text-white shadow-lg shadow-fuchsia-500/30'
                        : 'bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 text-gray-300 hover:border-fuchsia-500/40 hover:text-white'
                ]">
                    {{ page }}
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
    import FrontendLayout from '@/Layouts/FrontendLayout.vue'
    import { Link } from '@inertiajs/vue3'

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
