<template>
    <div class="max-w-2xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-xl">
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Create Product</h2>
                    <p class="text-gray-600 mt-1">Add a new product to your inventory</p>
                </div>
                
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name *
                        </label>
                        <input 
                            id="name"
                            v-model="form.name" 
                            type="text" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        />
                        <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">
                            {{ form.errors.name }}
                        </div>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea 
                            id="description"
                            v-model="form.description" 
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter product description..."
                        ></textarea>
                        <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">
                            {{ form.errors.description }}
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Price *
                            </label>
                            <input 
                                id="price"
                                v-model="form.price" 
                                type="number" 
                                step="0.01"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="0.00"
                                required
                            />
                            <div v-if="form.errors.price" class="text-red-500 text-sm mt-1">
                                {{ form.errors.price }}
                            </div>
                        </div>
                        
                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Stock Quantity
                            </label>
                            <input 
                                id="stock_quantity"
                                v-model="form.stock_quantity" 
                                type="number"
                                min="0"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="0"
                            />
                            <div v-if="form.errors.stock_quantity" class="text-red-500 text-sm mt-1">
                                {{ form.errors.stock_quantity }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-4 pt-6 border-t">
                        <button 
                            type="button" 
                            @click="goBack"
                            class="px-6 py-2 text-gray-600 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
                        >
                            <span v-if="form.processing">Creating...</span>
                            <span v-else>Create Product</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    description: '',
    price: '',
    stock_quantity: ''
});

const goBack = () => {
    router.visit(route('dashboard.products.index'));
};

const submit = () => {
    form.post(route('dashboard.products.store'), {
        onSuccess: () => {
            // Will redirect to index automatically
        }
    });
};
</script>
