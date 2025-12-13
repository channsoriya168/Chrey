<template>
    <Head title="កន្ត្រកទំនិញ" />

    <div class="space-y-6">
        <!-- Breadcrumb -->
        <div class="flex items-center justify-between">
            <DashboardBreadcrumb
                :items="[
                    {
                        label: 'ផ្ទាំងគ្រប់គ្រង',
                        href: route('dashboard.index')
                    },
                    { label: 'កន្ត្រកទំនិញ' }
                ]"
            />
        </div>

        <!-- Table Card -->
        <div class="overflow-hidden">
            <!-- Search Section -->
            <div class="flex items-center justify-between border-b border-gray-200 py-4">
                <div class="flex items-center gap-4">
                    <!-- Status Filter -->
                    <select
                        v-model="filter.status"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 transition-colors focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 focus:outline-none"
                    >
                        <option :value="null">ស្ថានភាពទាំងអស់</option>
                        <option value="pending">កំពុងរង់ចាំ</option>
                        <option value="completed">បានបញ្ចប់</option>
                        <option value="cancelled">បានលុបចោល</option>
                    </select>
                </div>

                <div class="relative w-full sm:w-96">
                    <Search
                        class="pointer-events-none absolute top-1/2 left-3 z-10 h-5 w-5 -translate-y-1/2 text-gray-400"
                    />
                    <input
                        type="text"
                        id="search"
                        v-model="filter.search"
                        placeholder="ស្វែងរកអតិថិជន"
                        class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pr-4 pl-10 text-sm text-gray-900 placeholder-gray-400 transition-colors focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 focus:outline-none"
                    />
                </div>
            </div>
            div

            <!-- DataTable -->
            <DataTable
                :columns="columns"
                :data="carts.data"
                :loading="loading"
                :pagination="carts"
                :can-view="true"
                :can-edit="false"
                :can-delete="true"
                delete-item-name-key="id"
                @page-change="handlePageChange"
                @per-page-change="handlePerPageChange"
                @view="viewCallback"
                @delete="deleteCallback"
            >
                <!-- Custom Cell: User -->
                <template #cell-user="{ item }">
                    <div class="flex flex-col gap-0.5">
                        <span class="text-sm font-medium text-gray-900">{{ item.user?.name }}</span>
                        <span class="text-xs text-gray-500">{{ item.user?.email }}</span>
                    </div>
                </template>

                <!-- Custom Cell: Items Count -->
                <template #cell-items_count="{ item }">
                    <span class="text-sm text-gray-900">{{ item.items_count }} items</span>
                </template>

                <!-- Custom Cell: Total -->
                <template #cell-total="{ item }">
                    <span class="text-sm font-semibold text-gray-900">${{ item.total?.toFixed(2) }}</span>
                </template>

                <!-- Custom Cell: Status -->
                <template #cell-status="{ item }">
                    <span
                        :class="[
                            'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium',
                            item.status === 'pending'
                                ? 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-600/20 ring-inset'
                                : item.status === 'completed'
                                  ? 'bg-green-50 text-green-700 ring-1 ring-green-600/20 ring-inset'
                                  : 'bg-red-50 text-red-700 ring-1 ring-red-600/20 ring-inset'
                        ]"
                    >
                        {{ item.status }}
                    </span>
                </template>

                <!-- Custom Cell: Created At -->
                <template #cell-created_at="{ item }">
                    <span class="text-sm text-gray-600">{{ formatDate(item.created_at) }}</span>
                </template>

                <!-- Empty State Slot -->
                <template #empty>
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="mb-4 rounded-full bg-gray-100 p-6">
                            <ShoppingCart class="h-12 w-12 text-gray-400" />
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900">គ្មានកន្ត្រកទំនិញទេ</h3>
                        <p class="text-sm text-gray-500">រកមិនឃើញកន្ត្រកទំនិញណាមួយទេ។</p>
                    </div>
                </template>
            </DataTable>
        </div>
    </div>
</template>

<script setup>
import DashboardBreadcrumb from '@/Components/Dashboard/DashboardBreadcrumb.vue'
import DataTable from '@/Components/ui/DataTable.vue'
import { Head, router } from '@inertiajs/vue3'
import { Search, ShoppingCart } from 'lucide-vue-next'
import { ref, watch } from 'vue'

// Props from Inertia
const props = defineProps({
    carts: {
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
            per_page: 10,
            search: null,
            status: null
        })
    }
})

// State
const loading = ref(false)

const filter = ref({
    search: props.filters?.search || null,
    status: props.filters?.status || null
})

// Table columns configuration
const columns = [
    {
        key: 'user',
        label: 'អតិថិជន'
    },
    {
        key: 'items_count',
        label: 'ចំនួនទំនិញ'
    },
    {
        key: 'total',
        label: 'សរុប'
    },
    {
        key: 'status',
        label: 'ស្ថានភាព'
    },
    {
        key: 'created_at',
        label: 'កាលបរិច្ឆេទបង្កើត'
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
        only: ['carts'],
        data: {
            filter: filter.value,
            page: 1
        }
    })
}

// Navigate to view page
const viewCallback = (item) => {
    router.visit(`/dashboard/carts/${item.id}`)
}

// Delete cart
const deleteCallback = (item) => {
    router.delete(`/dashboard/carts/${item.id}`, {
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
        only: ['carts'],
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
        only: ['carts'],
        data: {
            filter: filter.value,
            page: 1,
            per_page: perPage
        }
    })
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
