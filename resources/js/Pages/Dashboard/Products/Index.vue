<template>
    <Head title="ផលិតផល" />

    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Products</h1>
                <p class="mt-1 text-sm text-gray-500">Manage your product inventory</p>
            </div>
            <Button @click="isCreateDialogOpen = true" class="bg-gray-900 text-white hover:bg-gray-800">
                <Plus class="mr-2 h-4 w-4" />
                Add Product
            </Button>

            <!-- Create Dialog -->
            <ProductFormDialog
                v-model="isCreateDialogOpen"
                mode="create"
                title="បង្កើតផលិតផល"
                submit-text="បង្កើត"
                processing-text="កំពុងបង្កើត..."
                @submit="handleCreateSubmit"
            />

            <!-- Edit Dialog -->
            <ProductFormDialog
                v-model="isEditDialogOpen"
                mode="edit"
                title="កែប្រែផលិតផល"
                submit-text="កែប្រែ"
                processing-text="កំពុងកែប្រែ..."
                :initial-data="currentEditItem"
                @submit="handleEditSubmit"
            />
        </div>

        <!-- Table Card -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <!-- Search Section -->
            <div class="border-b border-gray-200 p-4">
                <div class="relative">
                    <Search class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 transform text-gray-400" />
                    <Input v-model="searchQuery" placeholder="Search products..." class="w-full pr-10 pl-10 sm:w-96" />
                    <div v-if="loading" class="absolute top-1/2 right-3 -translate-y-1/2">
                        <div class="h-4 w-4 animate-spin rounded-full border-2 border-gray-300 border-t-gray-900"></div>
                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <DataTable
                :columns="columns"
                :data="products.data"
                :loading="loading"
                :pagination="products"
                @page-change="handlePageChange"
                @per-page-change="handlePerPageChange"
            >
                <!-- Custom Cell: Image -->
                <template #cell-image_url="{ item }">
                    <div class="flex-shrink-0">
                        <div
                            v-if="item.image_url && item.image_url.length > 0"
                            class="h-16 w-16 overflow-hidden rounded-lg border border-gray-200"
                        >
                            <img
                                :src="`/storage/${item.image_url[0]}`"
                                :alt="item.name"
                                class="h-full w-full object-cover"
                            />
                        </div>
                        <div
                            v-else
                            class="flex h-16 w-16 items-center justify-center rounded-lg border border-gray-200 bg-gray-100"
                        >
                            <ImageIcon class="h-6 w-6 text-gray-400" />
                        </div>
                    </div>
                </template>

                <!-- Custom Cell: Product -->
                <template #cell-name="{ item }">
                    <div class="flex flex-col">
                        <span class="text-base font-medium text-gray-900">{{ item.name }}</span>
                        <span class="mt-1 text-sm text-gray-500">{{ item.code }}</span>
                        <p v-if="item.description" class="mt-1 line-clamp-1 text-xs text-gray-400">
                            {{ item.description }}
                        </p>
                    </div>
                </template>

                <!-- Custom Cell: Price -->
                <template #cell-price="{ item }">
                    <div class="flex flex-col">
                        <div v-if="item.discount_price" class="flex items-center gap-2">
                            <span class="text-base font-semibold text-green-600">${{ item.discount_price }}</span>
                            <span class="text-sm text-gray-400 line-through">${{ item.price }}</span>
                        </div>
                        <span v-else class="text-base font-semibold text-gray-900">${{ item.price }}</span>
                        <span
                            v-if="item.discount_price"
                            class="mt-1 inline-flex w-fit items-center rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800"
                        >
                            Save ${{ (item.price - item.discount_price).toFixed(2) }}
                        </span>
                    </div>
                </template>

                <!-- Custom Cell: Stock -->
                <template #cell-stock="{ item }">
                    <span
                        :class="[
                            'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                            item.stock > 50
                                ? 'bg-green-100 text-green-800'
                                : item.stock > 0
                                  ? 'bg-yellow-100 text-yellow-800'
                                  : 'bg-red-100 text-red-800'
                        ]"
                    >
                        {{ item.stock }} units
                    </span>
                </template>

                <!-- Actions Slot -->
                <template #actions="{ item }">
                    <div class="flex items-center justify-end gap-2">
                        <button
                            @click="handleEdit(item)"
                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900"
                        >
                            <Pencil class="h-4 w-4" />
                            Edit
                        </button>
                        <button
                            @click="handleDelete(item)"
                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition-colors hover:bg-red-50 hover:text-red-700"
                        >
                            <Trash2 class="h-4 w-4" />
                        </button>
                    </div>
                </template>

                <!-- Empty State Slot -->
                <template #empty>
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="mb-4 rounded-full bg-gray-100 p-6">
                            <Package class="h-12 w-12 text-gray-400" />
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900">No products found</h3>
                        <p class="mb-6 text-sm text-gray-600">Get started by adding your first product</p>
                        <Button @click="isCreateDialogOpen = true" size="sm">
                            <Plus class="mr-2 h-4 w-4" />
                            Add First Product
                        </Button>
                    </div>
                </template>
            </DataTable>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import Button from '@/Components/ui/Button.vue'
import { Input } from '@/components/ui/input'
import DataTable from '@/Components/ui/DataTable.vue'
import ProductFormDialog from '@/Components/Dashboard/ProductFormDialog.vue'
import { Plus, Search, ImageIcon, Pencil, Trash2, Package } from 'lucide-vue-next'
import { useDebounceFn } from '@vueuse/core'

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
            search: '',
            per_page: 10
        })
    }
})

// State
const loading = ref(false)
const searchQuery = ref(props.filters.search || '')
const isCreateDialogOpen = ref(false)
const isEditDialogOpen = ref(false)
const currentEditItem = ref(null)

// Table columns configuration
const columns = [
    {
        key: 'image_url',
        label: 'Image',
        cellClass: 'w-20'
    },
    {
        key: 'name',
        label: 'Product',
        cellClass: ''
    },
    {
        key: 'price',
        label: 'Price',
        cellClass: ''
    },
    {
        key: 'stock',
        label: 'Stock',
        cellClass: ''
    }
]

// Handle create form submission
const handleCreateSubmit = ({ form, resetForm }) => {
    form.post('/dashboard/products', {
        preserveScroll: true,
        onSuccess: () => {
            isCreateDialogOpen.value = false
            resetForm()
        }
    })
}

// Handle edit form submission
const handleEditSubmit = ({ form, resetForm }) => {
    form.transform((data) => ({
        ...data,
        _method: 'PUT'
    })).post(`/dashboard/products/${currentEditItem.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            isEditDialogOpen.value = false
            resetForm()
            currentEditItem.value = null
        }
    })
}

const handleEdit = (item) => {
    currentEditItem.value = item
    isEditDialogOpen.value = true
}

const handleDelete = (item) => {
    if (confirm(`Are you sure you want to delete "${item.name}"?`)) {
        router.delete(`/dashboard/products/${item.id}`, {
            preserveScroll: true,
            onStart: () => (loading.value = true),
            onFinish: () => (loading.value = false)
        })
    }
}

// Debounced search function
const debouncedSearch = useDebounceFn((value) => {
    router.reload({
        data: {
            'filter[search]': value || undefined,
            per_page: props.filters.per_page
        },
        only: ['products'],
        preserveState: true,
        preserveScroll: true,
        onStart: () => (loading.value = true),
        onFinish: () => (loading.value = false)
    })
}, 300)

// Watch search query for auto-search with debounce
watch(searchQuery, (value) => {
    debouncedSearch(value)
})

const handlePageChange = (page) => {
    router.reload({
        data: {
            page,
            'filter[search]': searchQuery.value || undefined,
            per_page: props.filters.per_page
        },
        only: ['products'],
        preserveState: true,
        preserveScroll: true,
        onStart: () => (loading.value = true),
        onFinish: () => (loading.value = false)
    })
}

const handlePerPageChange = (perPage) => {
    router.reload({
        data: {
            per_page: perPage,
            'filter[search]': searchQuery.value || undefined
        },
        only: ['products'],
        preserveState: true,
        preserveScroll: true,
        onStart: () => (loading.value = true),
        onFinish: () => (loading.value = false)
    })
}
</script>
