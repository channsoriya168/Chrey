<template>
    <div class="min-h-screen bg-gradient-to-br from-purple-900 via-slate-900 to-slate-950">
        <!-- Breadcrumb -->
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <nav class="flex items-center space-x-2 text-sm">
                <Link href="/"
                    class="rounded-lg px-3 py-1.5 text-gray-300 transition-all hover:bg-fuchsia-500/20 hover:text-fuchsia-400">
                    ទំព័រដើម</Link>
                <span class="text-gray-500">/</span>
                <span class="rounded-lg bg-slate-800/60 px-3 py-1.5 font-medium text-white backdrop-blur-sm">{{
                    product.data.name }}</span>
            </nav>
        </div>

        <!-- Product Detail Section -->
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div
                        class="group relative aspect-square overflow-hidden rounded-3xl bg-gradient-to-br from-slate-700 to-slate-800 shadow-2xl shadow-fuchsia-500/10 border border-fuchsia-500/20 transition-all duration-500 hover:shadow-fuchsia-500/30 hover:border-fuchsia-500/40">
                        <img :src="selectedImage" :alt="product.data.name"
                            class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-110" />
                        <div v-if="product.data.discount_price_percent > 0"
                            class="absolute top-4 left-4 rounded-xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-4 py-2.5 text-sm font-bold text-white shadow-2xl">
                            -{{ product.data.discount_price_percent }}% OFF
                        </div>
                        <!-- Overlay on hover -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-fuchsia-900/30 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        </div>
                    </div>

                    <!-- Thumbnail Images -->
                    <div v-if="productImages.length > 1" class="grid grid-cols-4 gap-3">
                        <button v-for="(image, index) in productImages" :key="index" @click="selectedImage = image"
                            :class="[
                                'aspect-square overflow-hidden rounded-2xl bg-gradient-to-br from-slate-700 to-slate-800 transition-all duration-300 hover:scale-105',
                                selectedImage === image
                                    ? 'border-2 border-fuchsia-500 shadow-lg shadow-fuchsia-500/30'
                                    : 'border border-slate-700/50 hover:border-fuchsia-500/40'
                            ]">
                            <img :src="image" :alt="`${product.data.name} - Image ${index + 1}`"
                                class="h-full w-full object-cover" />
                        </button>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="space-y-6">
                    <!-- Product Title & Rating -->
                    <div
                        class="space-y-4 rounded-3xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 p-6 shadow-lg shadow-fuchsia-500/10">
                        <h1 class="text-3xl font-bold leading-tight text-white md:text-4xl lg:text-5xl drop-shadow-lg">
                            {{ product.data.name }}</h1>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center gap-1">
                                <div class="flex text-yellow-400">
                                    <span v-for="star in 5" :key="star" class="text-base md:text-lg">★</span>
                                </div>
                                <span class="ml-2 text-sm font-medium text-gray-400">(0 reviews)</span>
                            </div>
                        </div>
                        <!-- Description -->
                        <p class="text-base leading-relaxed text-gray-300 md:text-lg">
                            {{ product.data.description }}
                        </p>
                    </div>

                    <!-- Price -->
                    <div
                        class="rounded-3xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 p-8 shadow-lg shadow-fuchsia-500/10">
                        <div class="flex items-baseline space-x-3">
                            <span
                                class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400 md:text-5xl">${{
                                    product.data.discount_price || product.data.price }}</span>
                            <span v-if="product.data.discount_price && product.data.discount_price < product.data.price"
                                class="text-2xl text-gray-500 line-through">${{ product.data.price }}</span>
                        </div>
                        <p v-if="product.data.discount_price && product.data.discount_price < product.data.price"
                            class="mt-3 text-sm font-semibold text-green-400">
                            Save ${{ (product.data.price - product.data.discount_price).toFixed(2) }}
                        </p>
                    </div>

                    <!-- Stock Status -->
                    <div class="flex items-center space-x-2">
                        <span v-if="product.data.stock > 0"
                            class="flex items-center rounded-2xl bg-green-500/10 border border-green-500/20 px-5 py-2.5 text-sm font-semibold text-green-400">
                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            In Stock ({{ product.data.stock }} available)
                        </span>
                        <span v-else
                            class="flex items-center rounded-2xl bg-red-500/10 border border-red-500/20 px-5 py-2.5 text-sm font-semibold text-red-400">
                            Out of Stock
                        </span>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-semibold text-gray-300">Quantity:</span>
                        <div
                            class="flex items-center overflow-hidden rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-slate-700/50 shadow-lg">
                            <button @click="decrementQuantity"
                                class="px-6 py-3.5 text-lg font-semibold text-gray-300 transition-all hover:bg-fuchsia-500/20 hover:text-fuchsia-400 disabled:cursor-not-allowed disabled:opacity-50">
                                −
                            </button>
                            <input v-model.number="quantity" type="number" min="1" :max="product.data.stock"
                                class="w-20 border-x border-slate-700/50 bg-transparent py-3.5 text-center font-semibold text-white focus:outline-none" />
                            <button @click="incrementQuantity" :disabled="quantity >= product.data.stock"
                                class="px-6 py-3.5 text-lg font-semibold text-gray-300 transition-all hover:bg-fuchsia-500/20 hover:text-fuchsia-400 disabled:cursor-not-allowed disabled:opacity-50">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-4 pt-4 sm:flex-row">
                        <button @click="addToCart" :disabled="product.data.stock === 0 || isAddingToCart"
                            class="group flex flex-1 items-center justify-center space-x-2 rounded-2xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-8 py-4 font-bold text-white shadow-2xl shadow-fuchsia-500/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-fuchsia-500/50 disabled:cursor-not-allowed disabled:bg-slate-700 disabled:opacity-60">
                            <svg v-if="!isAddingToCart" class="h-6 w-6 transition-transform group-hover:scale-110"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <svg v-else class="h-6 w-6 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>{{ isAddingToCart ? 'Adding...' : 'Add to Cart' }}</span>
                        </button>
                        <button @click="buyNow" :disabled="product.data.stock === 0 || isAddingToCart"
                            class="group flex items-center justify-center space-x-2 rounded-2xl bg-slate-800/80 backdrop-blur-sm border-2 border-fuchsia-500/50 px-8 py-4 font-bold text-fuchsia-400 shadow-lg shadow-fuchsia-500/10 transition-all duration-300 hover:scale-[1.02] hover:bg-fuchsia-500/10 hover:shadow-fuchsia-500/20 disabled:cursor-not-allowed disabled:opacity-60">
                            <svg class="h-6 w-6 transition-transform group-hover:scale-110" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="hidden sm:inline">Buy Now</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            <div v-if="relatedProducts && relatedProducts.length > 0" class="mt-16 md:mt-20">
                <div class="mb-8 md:mb-10 text-center">
                    <h2
                        class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400 md:text-4xl">
                        {{ $t("You May Also Like") }}</h2>
                </div>
                <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 md:gap-6 lg:grid-cols-3 xl:grid-cols-4">
                    <Link v-for="relatedProduct in relatedProducts" :key="relatedProduct.id"
                        :href="`/product/${relatedProduct.slug}`"
                        class="group relative cursor-pointer overflow-hidden rounded-2xl bg-slate-800/60 backdrop-blur-sm border border-slate-700/50 shadow-lg shadow-slate-900/20 transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-fuchsia-500/10 hover:border-fuchsia-500/30">
                        <!-- Image Container -->
                        <div
                            class="relative aspect-square bg-gradient-to-br from-slate-700 to-slate-800 overflow-hidden">
                            <img :src="relatedProduct.first_image" :alt="relatedProduct.name"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
                            <!-- Overlay on hover -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-fuchsia-900/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-4 md:p-5">
                            <h3 class="mb-2 line-clamp-2 min-h-[2.5rem] text-sm font-semibold text-white md:text-base">
                                {{ relatedProduct.name }}
                            </h3>

                            <!-- Ratings -->
                            <div class="mb-3 flex items-center gap-1">
                                <div class="flex text-yellow-400">
                                    <span v-for="star in 5" :key="star" class="text-xs md:text-sm">★</span>
                                </div>
                                <span class="text-xs font-medium text-gray-400">(0)</span>
                            </div>

                            <!-- Price -->
                            <div class="flex items-baseline gap-2">
                                <span
                                    class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400 md:text-xl">
                                    ${{ relatedProduct.display_price }}
                                </span>
                                <span v-if="relatedProduct.has_discount"
                                    class="text-sm text-gray-500 line-through md:text-base">
                                    ${{ relatedProduct.price }}
                                </span>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { Link, router } from '@inertiajs/vue3'
    import { ref } from 'vue'

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
    const productImages = ref(props.product.data.image_url || [])
    const selectedImage = ref(productImages.value[0] || props.product.data.first_image)
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
                preserveScroll: true,
                onSuccess: () => {
                    isAddingToCart.value = false
                    // Reset quantity after successful add
                    quantity.value = 1
                    // Trigger cart refresh by dispatching a custom event
                    window.dispatchEvent(new CustomEvent('cart-updated'))
                },
                onError: () => {
                    isAddingToCart.value = false
                }
            }
        )
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

    // Buy Now function - Add to cart and redirect to checkout
    const buyNow = () => {
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
                preserveScroll: true,
                onSuccess: () => {
                    // Redirect to checkout address page
                    router.visit('/checkout/address')
                },
                onError: () => {
                    isAddingToCart.value = false
                }
            }
        )
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
