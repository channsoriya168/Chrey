<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Breadcrumb -->
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <nav class="flex items-center space-x-2 text-sm">
                <Link href="/" class="text-gray-500 hover:text-pink-600">ទំព័រដើម</Link>
                <span class="text-gray-400">/</span>
                <span class="font-medium text-gray-900">{{ product.data.name }}</span>
            </nav>
        </div>

        <!-- Product Detail Section -->
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="relative aspect-square overflow-hidden rounded-lg border border-gray-200 bg-white">
                        <img
                            :src="selectedImage"
                            :alt="product.data.name"
                            class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
                        />
                        <div
                            v-if="product.data.discount_price_percent>0"
                            class="absolute top-4 left-4 rounded-lg bg-red-500 px-3 py-1 text-sm font-bold text-white"
                        >
                            {{ product.data.discount_price_percent }}% OFF
                        </div>
                    </div>

                    <!-- Thumbnail Images -->
                    <div v-if="productImages.length > 1" class="grid grid-cols-4 gap-3">
                        <button
                            v-for="(image, index) in productImages"
                            :key="index"
                            @click="selectedImage = image"
                            :class="[
                                'aspect-square overflow-hidden rounded-lg border-2 transition-all duration-200',
                                selectedImage === image ? 'border-pink-600' : 'border-gray-200 hover:border-gray-300'
                            ]"
                        >
                            <img
                                :src="image"
                                :alt="`${product.data.name} - Image ${index + 1}`"
                                class="h-full w-full object-cover"
                            />
                        </button>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="space-y-6">          
                    <!-- Product Title & Rating -->
                    <div>
                        <h1 class="mb-3 text-3xl font-bold text-gray-900 md:text-4xl">{{ product.data.name }}</h1>
                         <!-- Description -->
                            <p class="leading-relaxed text-gray-600">
                                    {{ product.data.description}}
                                </p>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <div class="flex text-lg text-yellow-400">
                                    <span v-for="star in 5" :key="star">★</span>
                                </div>
                                <span class="ml-2 text-sm text-gray-600">(0 reviews)</span>
                            </div>

                        </div>
                    </div>
                    
                    <!-- Price -->
                    <div class="flex items-baseline space-x-3">
                        <span class="text-4xl font-bold text-pink-600">${{ product.data.discount_price || product.data.price }}</span>
                        <span
                            v-if="product.data.discount_price && product.data.discount_price < product.data.price"
                            class="text-2xl text-gray-400 line-through"
                            >${{ product.data.price }}</span
                        >
                    </div>

                    <!-- Stock Status -->
                    <div class="flex items-center space-x-2">
                        <span v-if="product.data.stock > 0" class="flex items-center font-medium text-green-600">
                            <svg class="mr-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                          In Stock  {{product.data.stock}}
                        </span>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="flex items-center space-x-4">
                        <span class="font-medium text-gray-700">Quantity:</span>
                        <div class="flex items-center rounded-lg border border-gray-300">
                            <button
                                @click="decrementQuantity"
                                class="px-4 py-2 text-gray-600 transition-colors hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                −
                            </button>
                            <input
                                v-model.number="quantity"
                                type="number"
                                min="1"
                                :max="product.data.stock"
                                class="w-16 border-x border-gray-300 py-2 text-center focus:outline-none"
                            />
                            <button
                                @click="incrementQuantity"
                                :disa
                                class="px-4 py-2 text-gray-600 transition-colors hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-4 pt-4 sm:flex-row">
                        <button
                            @click="addToCart"
                            :disabled="product.data.stock === 0 || isAddingToCart"
                            class="flex flex-1 items-center justify-center space-x-2 rounded-lg bg-pink-600 px-8 py-4 font-semibold text-white transition-colors duration-200 hover:bg-pink-700 disabled:cursor-not-allowed disabled:bg-gray-400"
                        >
                            <svg v-if="!isAddingToCart" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                            <svg v-else class="h-6 w-6 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>{{ isAddingToCart ? 'Adding...' : 'Add to Cart' }}</span>
                        </button>
                        <button
                            class="flex items-center justify-center space-x-2 rounded-lg border-2 border-pink-600 px-8 py-4 font-semibold text-pink-600 transition-colors duration-200 hover:bg-pink-50"
                        >
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                />
                            </svg>
                            <span class="hidden sm:inline">Wishlist</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            <div v-if="relatedProducts && relatedProducts.length > 0" class="mt-16">
                <h2 class="mb-8 text-2xl font-bold text-gray-900 md:text-3xl">You May Also Like</h2>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-3 md:gap-6 lg:grid-cols-4 xl:grid-cols-5">
                    <Link
                        v-for="relatedProduct in relatedProducts"
                        :key="relatedProduct.id"
                        :href="`/product/${relatedProduct.slug}`"
                        class="group cursor-pointer overflow-hidden rounded-lg bg-white shadow-sm transition-shadow duration-200 hover:shadow-lg"
                    >
                        <div class="relative aspect-square bg-gray-100">
                            <img
                                :src="getImageUrl(relatedProduct)"
                                :alt="relatedProduct.name"
                                class="h-full w-full object-cover transition-transform duration-200 group-hover:scale-105"
                            />
                        </div>
                        <div class="p-4">
                            <h3 class="mb-2 truncate text-sm font-semibold text-gray-800">{{ relatedProduct.name }}</h3>
                            <div class="mb-2 flex items-center">
                                <div class="flex text-xs text-yellow-400">
                                    <span v-for="star in 5" :key="star">★</span>
                                </div>
                                <span class="ml-1 text-xs text-gray-500">(0)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span
                                        v-if="
                                            relatedProduct.discount_price &&
                                            relatedProduct.discount_price < relatedProduct.price
                                        "
                                        class="ml-2 text-sm text-gray-400 line-through"
                                        >${{ relatedProduct.price }}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'


const props = defineProps({
    product: {
        type: Object,
        required: true
    },
    relatedProducts: {
        type: Array,
        default: () => []
    }
})

// Initialize quantity and selected image
const quantity = ref(1)
const productImages = ref(getProductImages())
const selectedImage = ref(productImages.value[0])
const isAddingToCart = ref(false)

// Add to cart function
const addToCart = () => {
    if (props.product.data.stock < 1 || isAddingToCart.value) {
        return
    }

    isAddingToCart.value = true

    router.post(
        '/cart',
        {
            product_id: props.product.data.id,
            quantity: quantity.value
        },
        {
            onSuccess: () => {
                isAddingToCart.value = false
                // Reset quantity after successful add
                quantity.value = 1
            },
            onError: () => {
                isAddingToCart.value = false
            }
        }
    )
}

// Get all product images
function getProductImages() {
    if (props.product.data.image_url) {
        if (Array.isArray(props.product.data.image_url) && props.product.data.image_url.length > 0) {
            return props.product.data.image_url.map(path => `/storage/${path}`)
        }
        if (typeof props.product.data.image_url === 'string') {
            try {
                const parsed = JSON.parse(props.product.data.image_url)
                if (Array.isArray(parsed) && parsed.length > 0) {
                    return parsed.map(path => `/storage/${path}`)
                }
            } catch (e) {
                return [`/storage/${props.product.image_url}`]
            }
        }
    }
    return ['']
}

// Quantity controls
const incrementQuantity = () => {
    if (quantity.value < props.product.data.stock) {
        quantity.value++
    }
}

const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--
    }
}

// Get image URL for related products
const getImageUrl = (product) => {
    if (product.image_url) {
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
    }
    return null
}
</script>

<style scoped>
/* Remove number input spinner arrows */
input[type='number']::-webkit-inner-spin-button,
input[type='number']::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type='number'] {
    -moz-appearance: textfield;
    appearance: textfield;
}
</style>
