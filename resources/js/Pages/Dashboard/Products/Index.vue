<template>

    <Head title="ផលិតផល" />

    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Products</h1>
                <p class="text-sm text-gray-500 mt-1">Manage your product inventory</p>
            </div>
            <Button @click="handleCreate" class="bg-gray-900 hover:bg-gray-800 text-white">
                <Plus class="mr-2 h-4 w-4" />
                Add Product
            </Button>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <!-- Search Section -->
            <div class="p-4 border-b border-gray-200">
                <div class="relative">
                    <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                    <Input v-model="searchQuery" placeholder="Search products..." class="pl-10 w-full sm:w-96"
                        @input="handleSearch" />
                </div>
            </div>

            <!-- DataTable -->
            <DataTable :columns="columns" :data="products" :loading="loading">
                <!-- Custom Cell: Image -->
                <template #cell-image_url="{ item }">
                    <div class="flex-shrink-0">
                        <div v-if="item.image_url && item.image_url.length > 0"
                            class="h-16 w-16 rounded-lg overflow-hidden border border-gray-200">
                            <img :src="item.image_url[0]" :alt="item.name" class="h-full w-full object-cover" />
                        </div>
                        <div v-else
                            class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200">
                            <ImageIcon class="h-6 w-6 text-gray-400" />
                        </div>
                    </div>
                </template>

                <!-- Custom Cell: Product -->
                <template #cell-name="{ item }">
                    <div class="flex flex-col">
                        <span class="text-base font-medium text-gray-900">{{ item.name }}</span>
                        <span class="text-sm text-gray-500 mt-1">{{ item.code }}</span>
                        <p v-if="item.description" class="text-xs text-gray-400 mt-1 line-clamp-1">
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
                        <span v-if="item.discount_price"
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mt-1 w-fit">
                            Save ${{ (item.price - item.discount_price).toFixed(2) }}
                        </span>
                    </div>
                </template>

                <!-- Custom Cell: Stock -->
                <template #cell-quantity="{ item }">
                    <span :class="[
                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                        item.quantity > 50 ? 'bg-green-100 text-green-800' :
                            item.quantity > 0 ? 'bg-yellow-100 text-yellow-800' :
                                'bg-red-100 text-red-800'
                    ]">
                        {{ item.quantity }} units
                    </span>
                </template>

                <!-- Actions Slot -->
                <template #actions="{ item }">
                    <div class="flex items-center justify-end gap-2">
                        <button @click="handleEdit(item)"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                            <Pencil class="h-4 w-4" />
                            Edit
                        </button>
                        <button @click="handleDelete(item)"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                            <Trash2 class="h-4 w-4" />
                        </button>
                    </div>
                </template>

                <!-- Empty State Slot -->
                <template #empty>
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="bg-gray-100 rounded-full p-6 mb-4">
                            <Package class="h-12 w-12 text-gray-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                        <p class="text-sm text-gray-600 mb-6">
                            Get started by adding your first product
                        </p>
                        <Button @click="handleCreate" size="sm">
                            <Plus class="mr-2 h-4 w-4" />
                            Add First Product
                        </Button>
                    </div>
                </template>
            </DataTable>
        </div>

        <!-- Loading Overlay -->
        <div v-if="loading" class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 shadow-xl">
                <div class="flex items-center gap-3">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-gray-900"></div>
                    <span class="text-gray-700 font-medium">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import { router, Head } from '@inertiajs/vue3'
    import Button from '@/Components/ui/Button.vue'
    import Input from '@/Components/ui/Input.vue'
    import DataTable from '@/Components/ui/DataTable.vue'
    import { Plus, Search, ImageIcon, Pencil, Trash2, Package } from 'lucide-vue-next'

    // Props from Inertia
    const props = defineProps({
        products: {
            type: Array,
            default: () => []
        }
    })

    // State
    const loading = ref(false)
    const searchQuery = ref('')

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
            key: 'quantity',
            label: 'Stock',
            cellClass: ''
        }
    ]

    // Handlers
    const handleCreate = () => {
        router.visit('/dashboard/products/create')
    }

    const handleEdit = (item) => {
        router.visit(`/dashboard/products/${item.id}/edit`)
    }

    const handleDelete = (item) => {
        if (confirm(`Are you sure you want to delete "${item.name}"?`)) {
            router.delete(`/dashboard/products/${item.id}`, {
                preserveScroll: true,
                onStart: () => loading.value = true,
                onFinish: () => loading.value = false
            })
        }
    }

    const handleSearch = () => {
        // Add search functionality
        console.log('Searching for:', searchQuery.value)
    }
</script>
