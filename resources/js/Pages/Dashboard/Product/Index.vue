<script setup>
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    products: Array
});

const openCreateModal = () => {
    // For now, navigate to create page normally
    router.visit(route('dashboard.products.create'));
};
</script>

<template>
    <div>
        <Head title="Products" />
        
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Products</h1>
                <p class="text-gray-600">Manage your products inventory</p>
            </div>
            <v-btn 
                @click="openCreateModal"
                color="primary"
                prepend-icon="mdi-plus"
            >
                Create Product
            </v-btn>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div v-if="products && products.length > 0">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ product.name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500 max-w-xs truncate">
                                        {{ product.description || 'No description' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        ${{ Number(product.price).toFixed(2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                          :class="product.stock_quantity > 10 ? 'bg-green-100 text-green-800' : 
                                                  product.stock_quantity > 0 ? 'bg-yellow-100 text-yellow-800' : 
                                                  'bg-red-100 text-red-800'">
                                        {{ product.stock_quantity || 0 }} in stock
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <v-btn
                                            size="small"
                                            variant="outlined"
                                            color="primary"
                                            prepend-icon="mdi-pencil"
                                        >
                                            Edit
                                        </v-btn>
                                        <v-btn
                                            size="small"
                                            variant="outlined"
                                            color="error"
                                            prepend-icon="mdi-delete"
                                        >
                                            Delete
                                        </v-btn>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Empty state -->
            <div v-else class="text-center py-12">
                <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
                    <v-icon size="48">mdi-package-variant</v-icon>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-500 mb-6">Get started by creating your first product.</p>
                <v-btn 
                    @click="openCreateModal"
                    color="primary"
                    prepend-icon="mdi-plus"
                >
                    Create Your First Product
                </v-btn>
            </div>
        </div>
    </div>
</template>