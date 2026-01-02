<template>
    <Head title="ព័ត៌មានលម្អិតផលិតផល" />

    <div class="space-y-6 pb-32">
        <!-- Breadcrumb & Action Buttons -->
        <div class="flex items-center justify-between">
            <DashboardBreadcrumb
                :items="[
                    { label: 'ទំព័រដើម', href: route('dashboard.index') },
                    { label: 'ផលិតផល', href: route('dashboard.products.index') },
                    { label: 'មើលព័ត៌មាន' }
                ]"
            />
            <div class="flex items-center gap-3">
                <Button variant="outline" @click="handleBack" class="khmer-text">
                    <ChevronLeft class="mr-2 h-4 w-4" />
                    ត្រឡប់ក្រោយ
                </Button>
                <Button @click="handleEdit" class="khmer-text">
                    <Pencil class="mr-2 h-4 w-4" />
                    កែប្រែ
                </Button>
            </div>
        </div>

        <!-- Product Details Card -->
        <div class="overflow-hidden rounded-xl border border-slate-700/50 bg-slate-800/80 backdrop-blur-sm shadow-lg shadow-slate-900/50">
            <!-- Product Images -->
            <div
                v-if="product.image_url && product.image_url.length > 0"
                class="border-b border-slate-700/50 bg-slate-900/50 p-8"
            >
                <div class="mx-auto max-w-4xl">
                    <!-- Main Image -->
                    <div class="mb-4 overflow-hidden rounded-lg border border-slate-600 bg-slate-700 shadow-sm">
                        <img
                            :src="`/storage/${product.image_url[selectedImageIndex]}`"
                            :alt="product.name"
                            class="h-96 w-full object-contain"
                        />
                    </div>

                    <!-- Image Thumbnails -->
                    <div v-if="product.image_url.length > 1" class="flex gap-3 overflow-x-auto">
                        <button
                            v-for="(image, index) in product.image_url"
                            :key="index"
                            @click="selectedImageIndex = index"
                            :class="[
                                'h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg border-2 transition-all',
                                selectedImageIndex === index
                                    ? 'border-purple-500 ring-2 ring-purple-500 ring-offset-2 ring-offset-slate-900'
                                    : 'border-slate-600 hover:border-purple-400'
                            ]"
                        >
                            <img
                                :src="`/storage/${image}`"
                                :alt="`${product.name} - Image ${index + 1}`"
                                class="h-full w-full object-cover"
                            />
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="border-b border-slate-700/50 bg-slate-900/50 p-8">
                <div
                    class="mx-auto flex h-96 max-w-4xl items-center justify-center rounded-lg border border-slate-600 bg-slate-700"
                >
                    <div class="text-center">
                        <ImageIcon class="mx-auto mb-3 h-16 w-16 text-gray-400" />
                        <p class="text-sm text-gray-400">No image available</p>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="p-8">
                <div class="mx-auto max-w-4xl space-y-8">
                    <!-- Basic Information -->
                    <div>
                        <h2 class="mb-6 text-2xl font-bold text-white">{{ product.name }}</h2>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <!-- Product Code -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-400">លេខកូដផលិតផល</label>
                                <p class="text-base font-medium text-gray-200">{{ product.code }}</p>
                            </div>

                            <!-- Size -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-400">ទំហំ</label>
                                <p class="text-base font-medium text-gray-200">{{ product.size }}</p>
                            </div>

                            <!-- Price -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-400">តម្លៃ</label>
                                <div class="flex items-center gap-2">
                                    <p v-if="product.discount_price" class="text-xl font-bold text-green-400">
                                        ${{ product.discount_price }}
                                    </p>
                                    <p
                                        :class="[
                                            'text-xl font-bold',
                                            product.discount_price ? 'text-gray-500 line-through' : 'text-gray-200'
                                        ]"
                                    >
                                        ${{ product.price }}
                                    </p>
                                </div>
                                <p v-if="product.discount_price_percent" class="mt-1 text-sm text-green-400">
                                    Save {{ product.discount_price_percent }}% (${{
                                        (product.price - product.discount_price).toFixed(2)
                                    }})
                                </p>
                            </div>

                            <!-- Stock -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-400">ចំនួនស្តុក</label>
                                <div class="flex items-center gap-2">
                                    <span
                                        :class="[
                                            'inline-flex items-center rounded-full px-3 py-1.5 text-sm font-medium',
                                            product.stock > 50
                                                ? 'bg-green-50 text-green-700 ring-1 ring-green-600/20 ring-inset'
                                                : product.stock > 0
                                                  ? 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-600/20 ring-inset'
                                                  : 'bg-red-50 text-red-700 ring-1 ring-red-600/20 ring-inset'
                                        ]"
                                    >
                                        {{ product.stock }} units
                                    </span>
                                    <span v-if="product.stock === 0" class="text-sm font-medium text-red-400">
                                        Out of stock
                                    </span>
                                    <span v-else-if="product.stock <= 50" class="text-sm font-medium text-yellow-400">
                                        Low stock
                                    </span>
                                    <span v-else class="text-sm font-medium text-green-400"> In stock </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div v-if="product.description" class="border-t border-slate-700/50 pt-6">
                        <label class="mb-2 block text-sm font-medium text-gray-400">ការពិពណ៌នា</label>
                        <p class="text-base whitespace-pre-line text-gray-300">{{ product.description }}</p>
                    </div>

                    <!-- Metadata -->
                    <div class="border-t border-slate-700/50 pt-6">
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-400">Created At</label>
                                <p class="text-sm text-gray-200">{{ formatDate(product.created_at) }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-400">Last Updated</label>
                                <p class="text-sm text-gray-200">{{ formatDate(product.updated_at) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import DashboardBreadcrumb from '@/Components/Dashboard/DashboardBreadcrumb.vue'
import { Button } from '@/Components/ui/button'
import { ChevronLeft, Pencil, ImageIcon } from 'lucide-vue-next'

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
})

const selectedImageIndex = ref(0)

const handleBack = () => {
    router.visit(route('dashboard.products.index'))
}

const handleEdit = () => {
    router.visit(route('dashboard.products.edit', props.product.id))
}

const formatDate = (date) => {
    if (!date) return 'N/A'
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}
</script>
