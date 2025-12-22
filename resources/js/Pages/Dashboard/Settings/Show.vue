<template>
    <Head title="លម្អិតកន្ត្រកទំនិញ" />

    <div class="space-y-6">
        <!-- Breadcrumb -->
        <div class="flex items-center justify-between">
            <DashboardBreadcrumb
                :items="[
                    { label: 'ផ្ទាំងគ្រប់គ្រង', href: route('dashboard.index') },
                    { label: 'កន្ត្រកទំនិញ', href: route('dashboard.carts.index') },
                    { label: 'លម្អិត' }
                ]"
            />
            <Button
                @click="goBack"
                variant="outline"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-700 transition-colors hover:bg-gray-50"
            >
                <ArrowLeft class="h-4 w-4" />
                <span class="khmer-text">ត្រឡប់ក្រោយ</span>
            </Button>
        </div>

        <!-- Cart Details Card -->
        <div class="overflow-hidden rounded-lg bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">ព័ត៌មានកន្ត្រក</h2>
            </div>

            <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">
                <!-- User Info -->
                <div>
                    <h3 class="mb-3 text-sm font-medium text-gray-500">ព័ត៌មានអតិថិជន</h3>
                    <div class="space-y-2">
                        <div>
                            <span class="text-sm font-medium text-gray-900">{{ cart.user?.name }}</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">{{ cart.user?.email }}</span>
                        </div>
                    </div>
                </div>

                <!-- Cart Info -->
                <div>
                    <h3 class="mb-3 text-sm font-medium text-gray-500">ព័ត៌មានកន្ត្រក</h3>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">ស្ថានភាព:</span>
                            <span
                                :class="[
                                    'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium',
                                    cart.status === 'pending'
                                        ? 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-600/20 ring-inset'
                                        : cart.status === 'completed'
                                          ? 'bg-green-50 text-green-700 ring-1 ring-green-600/20 ring-inset'
                                          : 'bg-red-50 text-red-700 ring-1 ring-red-600/20 ring-inset'
                                ]"
                            >
                                {{ cart.status }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">កាលបរិច្ឆេទបង្កើត:</span>
                            <span class="text-sm text-gray-900">{{ formatDate(cart.created_at) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">កាលបរិច្ឆេទធ្វើបច្ចុប្បន្នភាព:</span>
                            <span class="text-sm text-gray-900">{{ formatDate(cart.updated_at) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Items -->
        <div class="overflow-hidden rounded-lg bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">ទំនិញក្នុងកន្ត្រក</h2>
            </div>

            <div class="p-6">
                <div v-if="cart.cart_items && cart.cart_items.length > 0" class="space-y-4">
                    <div
                        v-for="item in cart.cart_items"
                        :key="item.id"
                        class="flex gap-4 rounded-lg border border-gray-200 p-4"
                    >
                        <!-- Product Image -->
                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg border border-gray-200">
                            <img
                                v-if="item.product?.image_url && item.product.image_url.length > 0"
                                :src="`/storage/${item.product.image_url[0]}`"
                                :alt="item.product?.name"
                                class="h-full w-full object-cover"
                            />
                            <div v-else class="flex h-full w-full items-center justify-center bg-gray-50">
                                <ImageIcon class="h-5 w-5 text-gray-400" />
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="flex flex-1 flex-col justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">{{ item.product?.name }}</h3>
                                <p class="mt-1 text-sm text-gray-600">${{ item.price }} each</p>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Quantity: {{ item.quantity }}</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    ${{ (item.price * item.quantity).toFixed(2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="py-8 text-center text-sm text-gray-500">គ្មានទំនិញក្នុងកន្ត្រកទេ</div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="overflow-hidden rounded-lg bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">សង្ខេបការបញ្ជាទិញ</h2>
            </div>

            <div class="p-6">
                <div class="space-y-3 border-b border-gray-200 pb-4">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>សរុបរង:</span>
                        <span>${{ subtotal?.toFixed(2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>ការដឹកជញ្ជូន:</span>
                        <span>នឹងគណនានៅពេលបញ្ជាទិញ</span>
                    </div>
                </div>

                <div class="mt-4 flex justify-between text-lg font-bold text-gray-900">
                    <span>សរុប:</span>
                    <span>${{ total?.toFixed(2) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { router, Head } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import DashboardBreadcrumb from '@/Components/Dashboard/DashboardBreadcrumb.vue'
import { ArrowLeft, ImageIcon } from 'lucide-vue-next'

// Props from Inertia
const props = defineProps({
    cart: {
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

// Go back to carts list
const goBack = () => {
    router.visit('/dashboard/carts')
}

/**
 * Format date.
 *
 * @param {String} date
 * @return {String}
 */
const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}
</script>
