<template>

    <Head title="ផលិតផល" />

    <div class="space-y-6">
        <!-- Breadcrumb -->

        <div class="flex items-center justify-between">
            <DashboardBreadcrumb
                :items="[{ label: 'ផ្ទាំងគ្រប់គ្រង', href: route('dashboard.index') }, { label: 'ផលិតផល' }]" />
            <Button @click="createCallback"
                class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-white transition-colors hover:bg-gray-800">
                <Plus class="h-4 w-4" />
                <span class="khmer-text">បង្កើត</span>
            </Button>
        </div>

        <!-- Table Card -->
        <div class="overflow-hidden">
            <!-- Search Section -->
            <div class="flex items-center justify-end border-b border-gray-200 py-4">
                <div class="relative w-full sm:w-96">
                    <Search
                        class="pointer-events-none absolute top-1/2 left-3 z-10 h-5 w-5 -translate-y-1/2 text-gray-400" />
                    <input type="text" id="search" v-model="filter.search" placeholder="ស្វែងរកផលិតផល"
                        class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pr-4 pl-10 text-sm text-gray-900 placeholder-gray-400 transition-colors focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 focus:outline-none" />
                </div>
            </div>

            <!-- DataTable -->
            <DataTable :columns="columns" :data="products.data" :loading="loading" :pagination="products"
                :can-view="true" :can-edit="true" :can-delete="true" delete-item-name-key="name"
                @page-change="handlePageChange" @per-page-change="handlePerPageChange" @view="viewCallback"
                @edit="editCallback" @delete="deleteCallback">
                <!-- Custom Cell: Image -->
                <template #cell-image_url="{ item }">
                    <div class="flex-shrink-0">
                        <div v-if="item.image_url && item.image_url.length > 0"
                            class="h-20 w-20 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                            <img :src="`${item.image_url[0]}`" :alt="item.name" class="h-full w-full object-cover" />
                        </div>
                        <div v-else
                            class="flex h-20 w-20 items-center justify-center rounded-lg border border-gray-200 bg-gray-50">
                            <ImageIcon class="h-5 w-5 text-gray-400" />
                        </div>
                    </div>
                </template>

                <!-- Custom Cell: Product -->
                <template #cell-name="{ item }">
                    <div class="flex flex-col gap-0.5">
                        <span class="text-sm font-medium text-gray-900">{{ item.name }}</span>
                    </div>
                </template>

                <!-- Custom Cell: Price -->
                <template #cell-price="{ item }">
                    <div class="flex flex-col gap-1">
                        <div v-if="item.discount_price_percent && item.discount_price_percent > 0"
                            class="flex items-center gap-1.5">
                            <span class="text-sm font-semibold text-green-600">${{ item.discount_price }}</span>
                            <span class="text-xs text-gray-400 line-through">${{ item.price }}</span>
                        </div>
                        <span v-else class="text-sm font-semibold text-gray-900">${{ item.price }}</span>
                    </div>
                </template>
                <!-- Custom Cell: Discount Percentage -->
                <template #cell-discount_percentage="{ item }">
                    <div class="flex flex-col gap-1">
                        <span v-if="item.discount_price_percent && item.discount_price_percent > 0"
                            class="pa-5 text-sm font-semibold text-red-600">{{ parseFloat(item.discount_price_percent)
                            }}%</span>
                        <span v-else class="text-sm font-semibold text-red-600">0%</span>
                    </div>
                </template>

                <!-- Custom Cell: Stock -->
                <template #cell-stock="{ item }">
                    <span :class="[
                        'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium',
                        item.stock > 50
                            ? 'bg-green-50 text-green-700 ring-1 ring-green-600/20 ring-inset'
                            : item.stock > 0
                                ? 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-600/20 ring-inset'
                                : 'bg-red-50 text-red-700 ring-1 ring-red-600/20 ring-inset'
                    ]">
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
    import DashboardBreadcrumb from '@/Components/Dashboard/DashboardBreadcrumb.vue'
    import DataTable from '@/Components/ui/DataTable.vue'
    import { Button } from '@/Components/ui/button'
    import { Head, router } from '@inertiajs/vue3'
    import { ImageIcon, Package, Plus, Search } from 'lucide-vue-next'
    import { ref, watch } from 'vue'

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
            label: 'រូបភាព'
            // cellClass: 'w-16'
        },
        {
            key: 'name',
            label: 'ផលិតផល'
            // cellClass: 'min-w-[200px]'
        },
        {
            key: 'price',
            label: 'តម្លៃ'
            // cellClass: 'w-32'
        },
        {
            key: 'discount_percentage',
            label: 'បញ្ចុះតម្លៃ'
            // cellClass: 'w-32'
        },
        {
            key: 'stock',
            label: 'ស្តុក'
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

    // Navigate to view page
    const viewCallback = (item) => {
        router.visit(`/dashboard/products/${item.id}`)
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
