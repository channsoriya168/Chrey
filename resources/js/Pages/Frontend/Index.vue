<template>
    <div class="min-h-screen">
        <!-- Hero Carousel Section -->
        <div class="mx-auto max-w-7xl px-1 sm:px-1 lg:px-1">
            <div class="relative">
                <!-- Carousel Container -->
                <div class="overflow-hidden">
                    <div class="relative h-[220px] sm:h-[280px] md:h-[500px]">
                        <!-- Slide 1 -->
                        <div v-show="currentSlide === 0" class="absolute inset-0 transition-opacity duration-500">
                            <div
                                class="grid h-full grid-cols-2 items-center gap-3 px-4 py-2 sm:gap-4 sm:px-6 sm:py-8 md:gap-8 md:px-16 md:py-0"
                            >
                                <div class="space-y-2 sm:space-y-3 md:space-y-6">
                                    <div
                                        class="inline-block rounded-full bg-pink-100 px-2.5 py-1 text-[11px] font-semibold text-pink-600 sm:px-3 sm:py-1.5 sm:text-xs md:px-4 md:py-2 md:text-sm"
                                    >
                                        #Big Fashion Sale
                                    </div>
                                    <h1
                                        class="text-base leading-tight font-bold text-gray-900 sm:text-2xl md:text-5xl lg:text-6xl"
                                    >
                                        Limited Time Offer!<br />
                                        Up to <span class="text-pink-600">50% OFF!</span>
                                    </h1>
                                    <p class="hidden text-xs text-gray-600 sm:block sm:text-sm md:text-lg">
                                        Redefine Your Everyday Style
                                    </p>
                                    <button
                                        class="rounded-lg bg-pink-600 px-4 py-2 text-xs font-semibold text-white transition-colors duration-200 hover:bg-pink-700 sm:px-6 sm:py-2.5 sm:text-sm md:px-8 md:py-3 md:text-base"
                                    >
                                        Shop Now
                                    </button>
                                </div>
                                <div class="flex items-center justify-center">
                                    <img
                                        src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=600&h=400&fit=crop"
                                        alt="Fashion products"
                                        class="h-auto max-h-[180px] w-full rounded-lg object-cover sm:max-h-[240px] md:max-h-96"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div v-show="currentSlide === 1" class="absolute inset-0 transition-opacity duration-500">
                            <div
                                class="grid h-full grid-cols-2 items-center gap-3 px-4 py-2 sm:gap-4 sm:px-6 sm:py-8 md:gap-8 md:px-16 md:py-0"
                            >
                                <div class="space-y-2 sm:space-y-3 md:space-y-6">
                                    <div
                                        class="inline-block rounded-full bg-blue-100 px-2.5 py-1 text-[11px] font-semibold text-blue-600 sm:px-3 sm:py-1.5 sm:text-xs md:px-4 md:py-2 md:text-sm"
                                    >
                                        #Summer Collection
                                    </div>
                                    <h1
                                        class="text-base leading-tight font-bold text-gray-900 sm:text-2xl md:text-5xl lg:text-6xl"
                                    >
                                        New Season<br />
                                        <span class="text-blue-600">New Styles</span>
                                    </h1>
                                    <p class="hidden text-xs text-gray-600 sm:block sm:text-sm md:text-lg">
                                        Discover the latest trends
                                    </p>
                                    <button
                                        class="rounded-lg bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition-colors duration-200 hover:bg-blue-700 sm:px-6 sm:py-2.5 sm:text-sm md:px-8 md:py-3 md:text-base"
                                    >
                                        Explore Now
                                    </button>
                                </div>
                                <div class="flex items-center justify-center">
                                    <img
                                        src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=600&h=400&fit=crop"
                                        alt="New collection"
                                        class="h-auto max-h-[180px] w-full rounded-lg object-cover sm:max-h-[240px] md:max-h-96"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div v-show="currentSlide === 2" class="absolute inset-0 transition-opacity duration-500">
                            <div
                                class="grid h-full grid-cols-2 items-center gap-3 px-4 py-2 sm:gap-4 sm:px-6 sm:py-8 md:gap-8 md:px-16 md:py-0"
                            >
                                <div class="space-y-2 sm:space-y-3 md:space-y-6">
                                    <div
                                        class="inline-block rounded-full bg-purple-100 px-2.5 py-1 text-[11px] font-semibold text-purple-600 sm:px-3 sm:py-1.5 sm:text-xs md:px-4 md:py-2 md:text-sm"
                                    >
                                        #Best Sellers
                                    </div>
                                    <h1
                                        class="text-base leading-tight font-bold text-gray-900 sm:text-2xl md:text-5xl lg:text-6xl"
                                    >
                                        Top Rated<br />
                                        <span class="text-purple-600">Products</span>
                                    </h1>
                                    <p class="hidden text-xs text-gray-600 sm:block sm:text-sm md:text-lg">
                                        Customer favorites just for you
                                    </p>
                                    <button
                                        class="rounded-lg bg-purple-600 px-4 py-2 text-xs font-semibold text-white transition-colors duration-200 hover:bg-purple-700 sm:px-6 sm:py-2.5 sm:text-sm md:px-8 md:py-3 md:text-base"
                                    >
                                        View Collection
                                    </button>
                                </div>
                                <div class="flex items-center justify-center">
                                    <img
                                        src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=600&h=400&fit=crop"
                                        alt="Best sellers"
                                        class="h-auto max-h-[180px] w-full rounded-lg object-cover sm:max-h-[240px] md:max-h-96"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carousel Indicators -->
                    <div
                        class="absolute bottom-1 left-1/2 z-10 flex -translate-x-1/2 transform space-x-1.5 sm:bottom-3 md:bottom-6 md:space-x-2"
                    >
                        <button
                            v-for="index in 3"
                            :key="index"
                            @click="currentSlide = index - 1"
                            :class="[
                                'h-1.5 w-1.5 rounded-full transition-all duration-300 md:h-2 md:w-2',
                                currentSlide === index - 1 ? 'w-6 bg-pink-600 md:w-8' : 'bg-gray-300'
                            ]"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 md:py-12 lg:px-8">
            <div class="mb-6 flex items-center justify-between md:mb-8">
                <h2 class="text-xl font-bold text-gray-900 md:text-3xl">Featured Products</h2>
                <a href="#" class="text-xs font-semibold text-pink-600 hover:text-pink-700 md:text-sm">See All →</a>
            </div>

            <div class="grid grid-cols-2 gap-3 md:grid-cols-3 md:gap-6 lg:grid-cols-4 xl:grid-cols-5">
                <Link
                    v-for="product in products.data"
                    :key="product.id"
                    :href="`/product/${product.slug}`"
                    class="group cursor-pointer overflow-hidden rounded-lg bg-white shadow-sm transition-shadow duration-200 hover:shadow-lg"
                >
                    <div class="relative aspect-square bg-gray-100">
                        <img
                            :src="getImageUrl(product)"
                            :alt="product.name"
                            class="h-full w-full object-cover transition-transform duration-200 group-hover:scale-105"
                        />
                        <div
                            v-if="calculateDiscount(product.price, product.discount_price)"
                            class="absolute top-1.5 left-1.5 rounded bg-red-500 px-1.5 py-0.5 text-[10px] font-bold text-white md:top-2 md:left-2 md:px-2 md:py-1 md:text-xs"
                        >
                            -{{ calculateDiscount(product.price, product.discount_price) }}%
                        </div>
                    </div>
                    <div class="p-2.5 md:p-4">
                        <h3 class="mb-1 truncate text-xs font-semibold text-gray-800 md:text-sm">{{ product.name }}</h3>
                        <div class="mb-1.5 flex items-center md:mb-2">
                            <div class="flex text-[10px] text-yellow-400 md:text-xs">
                                <span v-for="star in 5" :key="star">★</span>
                            </div>
                            <span class="ml-1 text-[10px] text-gray-500 md:text-xs">(0)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-sm font-bold text-gray-900 md:text-lg"
                                    >${{ getDisplayPrice(product) }}</span
                                >
                                <span
                                    v-if="product.discount_price && product.discount_price < product.price"
                                    class="ml-1 text-[10px] text-gray-400 line-through md:ml-2 md:text-sm"
                                    >${{ product.price }}</span
                                >
                            </div>
                        </div>
                    </div>
                </Link>
            </div>

            <!-- Pagination -->
            <div v-if="products.last_page > 1" class="mt-8 flex items-center justify-center space-x-2">
                <!-- Previous Button -->
                <Link
                    v-if="products.prev_page_url"
                    :href="products.prev_page_url"
                    class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100"
                    preserve-scroll
                >
                    ← Previous
                </Link>
                <span
                    v-else
                    class="cursor-not-allowed rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-gray-400"
                >
                    ← Previous
                </span>

                <!-- Page Numbers -->
                <div class="flex space-x-1">
                    <template v-for="page in getPaginationPages()" :key="page">
                        <span v-if="page === '...'" class="px-3 py-2 text-gray-500">...</span>
                        <Link
                            v-else
                            :href="getPageUrl(page)"
                            :class="[
                                'rounded-lg px-3 py-2 text-sm font-medium transition-colors',
                                page === products.current_page
                                    ? 'bg-pink-600 text-white'
                                    : 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-100'
                            ]"
                            preserve-scroll
                        >
                            {{ page }}
                        </Link>
                    </template>
                </div>

                <!-- Next Button -->
                <Link
                    v-if="products.next_page_url"
                    :href="products.next_page_url"
                    class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100"
                    preserve-scroll
                >
                    Next →
                </Link>
                <span
                    v-else
                    class="cursor-not-allowed rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-gray-400"
                >
                    Next →
                </span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    products: {
        type: Object,
        required: true
    }
})

const currentSlide = ref(0)
let slideInterval = null

// Auto-rotate carousel
onMounted(() => {
    slideInterval = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % 3
    }, 5000)
})

onUnmounted(() => {
    if (slideInterval) {
        clearInterval(slideInterval)
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

// Get image URL (first image from array or placeholder)
const getImageUrl = (product) => {
    // Check if image_url exists and is an array with items
    if (product.image_url) {
        if (Array.isArray(product.image_url) && product.image_url.length > 0) {
            return product.image_url[0]
        }
        // If it's a string (in case it wasn't properly parsed)
        if (typeof product.image_url === 'string') {
            try {
                const parsed = JSON.parse(product.image_url)
                if (Array.isArray(parsed) && parsed.length > 0) {
                    return parsed[0]
                }
            } catch (e) {
                // If it's just a plain URL string
                return product.image_url
            }
        }
    }
    // Fallback to placeholder
    return 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=400&h=400&fit=crop'
}

// Get pagination pages to display
const getPaginationPages = () => {
    const current = props.products.current_page
    const last = props.products.last_page
    const delta = 2 // Number of pages to show on each side of current page
    const pages = []

    // Always show first page
    pages.push(1)

    // Calculate range
    let start = Math.max(2, current - delta)
    let end = Math.min(last - 1, current + delta)

    // Add ellipsis after first page if needed
    if (start > 2) {
        pages.push('...')
    }

    // Add pages in range
    for (let i = start; i <= end; i++) {
        pages.push(i)
    }

    // Add ellipsis before last page if needed
    if (end < last - 1) {
        pages.push('...')
    }

    // Always show last page if more than 1 page
    if (last > 1) {
        pages.push(last)
    }

    return pages
}

// Get URL for specific page
const getPageUrl = (page) => {
    const url = new URL(window.location.href)
    url.searchParams.set('page', page)
    return url.pathname + url.search
}
</script>
