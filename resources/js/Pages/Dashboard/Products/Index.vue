<template>
    <Head title="ផលិតផល" />

    <div class="space-y-6">
        <!-- Breadcrumb -->
        

        <div class="flex items-center justify-between">
            <DashboardBreadcrumb :items="[{ label: 'ផ្ទាំងគ្រប់គ្រង', href: route('dashboard.index') }, { label: 'ផលិតផល' }]" />
            <Link
                @click="createCallback"
                class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-white transition-colors hover:bg-gray-800"
            >
                <Plus class="h-4 w-4" />
                <span class="khmer-text">បង្កើត</span>
            </Link>
           
        </div>

        <!-- Table Card -->
        <div class="overflow-hidden">
            <!-- Search Section -->
            <div class="border-b border-gray-200 py-4 flex items-center justify-end">
                <div class="relative w-full sm:w-96">
                    <Search
                        class="pointer-events-none absolute left-3 top-1/2 z-10 h-5 w-5 -translate-y-1/2 text-gray-400"
                    />
                    <input
                        type="text"
                        id="search"
                        v-model="filter.search"
                        placeholder="ស្វែងរកផលិតផល"
                        class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-900 placeholder-gray-400 transition-colors focus:border-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10"
                    />
                </div>
            </div>

            <!-- DataTable -->
            <DataTable
                :columns="columns"
                :data="products.data"
                :loading="loading"
                :pagination="products"
                :can-edit="true"
                :can-delete="true"
                delete-item-name-key="name"
                @page-change="handlePageChange"
                @per-page-change="handlePerPageChange"
                @edit="editCallback"
                @delete="deleteCallback"
            >
                <!-- Custom Cell: Image -->
                <template #cell-image_url="{ item }">
                    <div class="flex-shrink-0">
                        <div
                            v-if="item.image_url && item.image_url.length > 0"
                            class="h-20 w-20 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm"
                        >
                            <img
                                :src="`/storage/${item.image_url[0]}`"
                                :alt="item.name"
                                class="h-full w-full object-cover"
                            />
                        </div>
                        <div
                            v-else
                            class="flex h-20 w-20 items-center justify-center rounded-lg border border-gray-200 bg-gray-50"
                        >
                            <ImageIcon class="h-5 w-5 text-gray-400" />
                        </div>
                    </div>
                </template>

                <!-- Custom Cell: Product -->
                <template #cell-name="{ item }">
                    <div class="flex flex-col gap-0.5">
                        <span class="text-sm font-medium text-gray-900">{{ item.name }}</span>
                        <span class="text-xs text-gray-500">{{ item.code }}</span>
                        <p v-if="item.description" class="line-clamp-1 text-xs text-gray-400">
                            {{ item.description }}
                        </p>
                    </div>
                </template>

                <!-- Custom Cell: Price -->
                <template #cell-price="{ item }">
                    <div class="flex flex-col gap-1">
                        <div v-if="item.discount_price" class="flex items-center gap-1.5">
                            <span class="text-sm font-semibold text-green-600">${{ item.discount_price }}</span>
                            <span class="text-xs text-gray-400 line-through">${{ item.price }}</span>
                        </div>
                        <span v-else class="text-sm font-semibold text-gray-900">${{ item.price }}</span>
                        <span
                            v-if="item.discount_price"
                            class="inline-flex w-fit items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700"
                        >
                            Save ${{ (item.price - item.discount_price).toFixed(2) }}
                        </span>
                    </div>
                </template>

                <!-- Custom Cell: Stock -->
                <template #cell-stock="{ item }">
                    <span
                        :class="[
                            'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium',
                            item.stock > 50
                                ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20'
                                : item.stock > 0
                                  ? 'bg-yellow-50 text-yellow-700 ring-1 ring-inset ring-yellow-600/20'
                                  : 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20'
                        ]"
                    >
                        {{ item.stock }} units
                    </span>
                </template>

                <!-- Empty State Slot -->
                <template #empty>
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="mb-4 rounded-full bg-gray-100 p-6">
                            <Package class="h-12 w-12 text-gray-400" />
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900">No products found</h3>
                    </div>
                </template>
            </DataTable>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import FormField from '@/Components/ui/FormField.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import DataTable from '@/Components/ui/DataTable.vue'
import DashboardBreadcrumb from '@/Components/Dashboard/DashboardBreadcrumb.vue'
import { Plus, Search, ImageIcon, Package } from 'lucide-vue-next'

// Props from Inertia
const props = defineProps({
    products: {
        type: Object,
        default: () => ({
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
            from: 0,
            to: 0
        })
    },
    filters: {
        type: Object,
        default: () => ({
            per_page: 10
        })
    }
})

// State
const loading = ref(false)

const filter = ref({
    search: props.filters?.search || null
})

// Table columns configuration
const columns = [
    {
        key: 'image_url',
        label: 'Image',
        // cellClass: 'w-16'
    },
    {
        key: 'name',
        label: 'Product',
        // cellClass: 'min-w-[200px]'
    },
    {
        key: 'price',
        label: 'Price',
        // cellClass: 'w-32'
    },
    {
        key: 'stock',
        label: 'Stock',
        // cellClass: 'w-28'
    }
]

watch(
    filter,
    () => {
        filterCallback()
    },
    { deep: true }
)

/**
 * Filter callback.
 *
 * @return {void}
 */
const filterCallback = () => {
    router.reload({
        only: ['products'],
        data: {
            filter: filter.value,
            page: 1
        }
    })
}

// Navigate to create page
const createCallback = () => {
    router.visit('/dashboard/products/create')
}

// Navigate to edit page
const editCallback = (item) => {
    router.visit(`/dashboard/products/${item.id}/edit`)
}

// Delete product
const deleteCallback = (item) => {
    router.delete(`/dashboard/products/${item.id}`, {
        preserveScroll: true
    })
}

/**
 * Handle page change.
 *
 * @param {Number} page
 * @return {void}
 */
const handlePageChange = (page) => {
    router.reload({
        only: ['products'],
        data: {
            filter: filter.value,
            page: page,
            per_page: props.filters.per_page
        }
    })
}

/**
 * Handle per page change.
 *
 * @param {Number} perPage
 * @return {void}
 */
const handlePerPageChange = (perPage) => {
    router.reload({
        only: ['products'],
        data: {
            filter: filter.value,
            page: 1,
            per_page: perPage
        }
    })
}
</script>
