<template>
    <div v-if="discountProducts.length > 0" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8 text-center md:mb-10">
            <h2
                class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400 md:text-4xl">
                Special Offers</h2>
            <p class="mt-2 text-base text-gray-300 md:text-lg">Limited time deals - Don't miss out!</p>
        </div>

        <div class="flex gap-5 overflow-x-auto pb-4 scrollbar-hide md:gap-6" style="scroll-behavior: smooth;">
            <Link v-for="(product, index) in discountProducts" :key="'discount-' + product.id"
                :href="`/product/${product.slug}`"
                class="group relative cursor-pointer overflow-hidden rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 shadow-lg shadow-fuchsia-500/10 transition-all duration-300 hover:scale-[1.03] hover:shadow-2xl hover:shadow-fuchsia-500/20 hover:border-fuchsia-500/40 flex-shrink-0 w-[170px] sm:w-[210px] md:w-[250px] discount-card-slide-in"
                :style="`animation-delay: ${index * 80}ms`">
                <!-- Image Container -->
                <div class="relative aspect-square bg-gradient-to-br from-slate-700 to-slate-800 overflow-hidden">
                    <img :src="getImageUrl(product)" :alt="product.name"
                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
                    <!-- Discount Badge -->
                    <div class="absolute top-3 left-3 z-10">
                        <div class="rounded-xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-3 py-2 shadow-xl">
                            <span class="text-xs font-bold text-white md:text-sm">
                                -{{ calculateDiscount(product.price, product.discount_price) }}%
                            </span>
                        </div>
                    </div>
                    <!-- Overlay on hover -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-fuchsia-900/30 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-4 md:p-5">
                    <h3 class="mb-2 line-clamp-2 min-h-[2.5rem] text-sm font-semibold text-white md:text-base">
                        {{ product.name }}
                    </h3>

                    <!-- Ratings -->
                    <div class="mb-3 flex items-center gap-1">
                        <div class="flex text-yellow-400">
                            <span v-for="star in 5" :key="star" class="text-xs md:text-sm">★</span>
                        </div>
                        <span class="text-xs font-medium text-gray-400">(0)</span>
                    </div>

                    <!-- Price -->
                    <div class="flex flex-col gap-1.5">
                        <div class="flex items-baseline gap-2">
                            <span
                                class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400 md:text-2xl">
                                ${{ getDisplayPrice(product) }}
                            </span>
                            <span class="text-sm text-gray-500 line-through md:text-base">
                                ${{ product.price }}
                            </span>
                        </div>
                        <span class="text-xs font-semibold text-green-400">
                            Save ${{ (parseFloat(product.price) - parseFloat(product.discount_price)).toFixed(2) }}
                        </span>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>
<script setup>
    import { Link } from '@inertiajs/vue3'
    const props = defineProps({
        discountProducts: {
            type: Array,
            required: true
        }
    })

    // Calculate discount percentage
    const calculateDiscount = (price, discountPrice) => {
        if (!discountPrice || discountPrice >= price) return null
        return Math.round(((price - discountPrice) / price) * 100)
    }

    // Get display price (discount price if available, otherwise regular price)
    const getDisplayPrice = (product) => {
        return product.discount_price || product.price
    }

    // Function to get the image URL
    const getImageUrl = (product) => {
        if (product.image_url && Array.isArray(product.image_url) && product.image_url.length > 0) {
            return product.image_url[0]
        }
        return '/images/placeholder.png' // Fallback image
    }
</script>

<style scoped>

    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }
</style>