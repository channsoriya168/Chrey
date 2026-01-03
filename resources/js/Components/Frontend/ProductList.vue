<template>
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 md:pb-6 lg:px-8">
        <div class="mb-8 text-center md:mb-10">
            <h2
                class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400 md:text-4xl leading-relaxed ">
                {{ $t('home.products.featured') }}</h2>
        </div>

        <!-- Initial Loading Shimmer -->
        <div v-if="isInitialLoad" class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:gap-6 lg:grid-cols-4 xl:grid-cols-5">
            <div v-for="i in 10" :key="'initial-shimmer-' + i"
                class="overflow-hidden rounded-2xl bg-slate-800/60 backdrop-blur-sm border border-slate-700/50 shimmer-card">
                <!-- Image Shimmer -->
                <div
                    class="relative aspect-square bg-gradient-to-br from-slate-700 via-slate-600 to-slate-700 shimmer-bg">
                </div>

                <!-- Content Shimmer -->
                <div class="p-3 md:p-4 space-y-3">
                    <div class="space-y-2">
                        <div class="h-4 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-4 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded w-3/4 shimmer-bg">
                        </div>
                    </div>
                    <div class="flex gap-1">
                        <div
                            class="h-3 w-3 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-3 w-3 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-3 w-3 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-3 w-3 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-3 w-3 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div
                            class="h-6 w-20 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-6 w-16 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div v-else class="grid grid-cols-2 gap-5 sm:grid-cols-3 md:gap-6 lg:grid-cols-3 xl:grid-cols-4">
            <Link v-for="product in allProducts" :key="product.id" :href="`/product/${product.slug}`"
                class="group relative cursor-pointer overflow-hidden rounded-2xl bg-slate-800/60 backdrop-blur-sm border border-slate-700/50 shadow-lg shadow-slate-900/20 transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-fuchsia-500/10 hover:border-fuchsia-500/30 product-card-fade-in">
                <!-- Image Container -->
                <div class="relative aspect-square bg-gradient-to-br from-slate-700 to-slate-800 overflow-hidden">
                    <img :src="product.first_image" :alt="product.name"
                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
                    <!-- Discount Badge (if applicable) -->
                    <div v-if="product.discount_price_percent > 0" class="absolute top-2 left-2 z-10">
                        <div
                            class="rounded-lg bg-gradient-to-r from-fuchsia-500 to-pink-500 px-2 py-1 shadow-xl md:rounded-xl md:px-3 md:py-2">
                            <span class="text-xs font-bold text-white">
                                -{{ product.discount_price_percent }}%
                            </span>
                        </div>
                    </div>
                    <!-- Overlay on hover -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-fuchsia-900/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-2.5 md:p-4">
                    <h3 class="mb-1.5 line-clamp-2 min-h-[2.25rem] text-xs font-semibold text-white md:text-base">
                        {{ product.name }}
                    </h3>

                    <!-- Ratings -->
                    <div class="mb-2 flex items-center gap-1">
                        <div class="flex text-yellow-400">
                            <span v-for="star in 5" :key="star" class="text-xs md:text-sm">★</span>
                        </div>
                        <span class="text-xs font-medium text-gray-400">(0)</span>
                    </div>

                    <!-- Price -->
                    <div class="flex items-baseline gap-1.5">
                        <span
                            class="text-base font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400 md:text-xl">
                            ${{ product.display_price }}
                        </span>
                        <span v-if="product.has_discount" class="text-xs text-gray-500 line-through md:text-base">
                            ${{ product.price }}
                        </span>
                    </div>
                </div>
            </Link>
        </div>

        <!-- Loading Shimmer (Infinite Scroll) -->
        <div v-if="isLoading" class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 md:gap-6 lg:grid-cols-4 xl:grid-cols-5">
            <div v-for="i in 10" :key="'shimmer-' + i"
                class="overflow-hidden rounded-2xl bg-slate-800/60 backdrop-blur-sm border border-slate-700/50 shimmer-card"
                :style="`animation-delay: ${i * 50}ms`">
                <!-- Image Shimmer -->
                <div
                    class="relative aspect-square bg-gradient-to-br from-slate-700 via-slate-600 to-slate-700 shimmer-bg">
                </div>

                <!-- Content Shimmer -->
                <div class="p-3 md:p-4 space-y-3">
                    <div class="space-y-2">
                        <div class="h-4 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-4 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded w-3/4 shimmer-bg">
                        </div>
                    </div>
                    <div class="flex gap-1">
                        <div
                            class="h-3 w-3 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-3 w-3 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-3 w-3 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-3 w-3 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-3 w-3 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div
                            class="h-6 w-20 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                        <div
                            class="h-6 w-16 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700 rounded shimmer-bg">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End of results message -->
        <div v-else-if="!hasMorePages && allProducts.length > 0" class="mt-8 text-center"
            style="animation: fadeInUp 0.5s ease-out">
            <p class="text-gray-400 text-sm">{{ $t('home.pagination.noMore') || 'No more products to load' }}</p>
        </div>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3'
    import { onMounted, onUnmounted, ref } from 'vue'

    const props = defineProps({
        products: {
            type: Object,
            required: true
        }
    })

    const isLoading = ref(false)
    const isInitialLoad = ref(true)
    const allProducts = ref([])
    const currentPage = ref(1)
    const hasMorePages = ref(true)

    // Initialize products data
    if (props.products && props.products.data) {
        allProducts.value = [...props.products.data]
        currentPage.value = props.products.current_page || 1
        hasMorePages.value = props.products.current_page < props.products.last_page
        isInitialLoad.value = false
    }

    // Handle infinite scroll
    const handleScroll = () => {
        const scrollPosition = window.innerHeight + window.scrollY
        const bottomPosition = document.documentElement.offsetHeight - 300 // Trigger 300px before bottom

        if (scrollPosition >= bottomPosition && !isLoading.value && hasMorePages.value) {
            loadMoreProducts()
        }
    }

    // Load more products
    const loadMoreProducts = async () => {
        if (isLoading.value || !hasMorePages.value) return

        isLoading.value = true
        const nextPage = currentPage.value + 1

        try {
            const response = await fetch(`?page=${nextPage}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })

            const data = await response.json()

            if (data.props && data.props.products) {
                const newProducts = data.props.products.data
                allProducts.value = [...allProducts.value, ...newProducts]
                currentPage.value = data.props.products.current_page
                hasMorePages.value = data.props.products.current_page < data.props.products.last_page
            }
        } catch (error) {
            console.error('Error loading more products:', error)
        } finally {
            isLoading.value = false
        }
    }

    // Add scroll listener for infinite scroll
    onMounted(() => {
        window.addEventListener('scroll', handleScroll)
    })

    onUnmounted(() => {
        window.removeEventListener('scroll', handleScroll)
    })
</script>

<style scoped>

    /* Shimmer Animation */
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }

        100% {
            background-position: 1000px 0;
        }
    }

    .shimmer-bg {
        animation: shimmer 2s infinite linear;
        background-size: 1000px 100%;
    }

    /* Shimmer Card Fade In */
    @keyframes shimmerFadeIn {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .shimmer-card {
        animation: shimmerFadeIn 0.4s ease-out forwards;
        opacity: 0;
    }

    /* Product Card Fade In Animation */
    @keyframes productFadeIn {
        0% {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .product-card-fade-in {
        animation: productFadeIn 0.5s ease-out forwards;
        opacity: 0;
    }

    /* Stagger animation delay for product cards */
    .product-card-fade-in:nth-child(1) {
        animation-delay: 0ms;
    }

    .product-card-fade-in:nth-child(2) {
        animation-delay: 50ms;
    }

    .product-card-fade-in:nth-child(3) {
        animation-delay: 100ms;
    }

    .product-card-fade-in:nth-child(4) {
        animation-delay: 150ms;
    }

    .product-card-fade-in:nth-child(5) {
        animation-delay: 200ms;
    }

    .product-card-fade-in:nth-child(6) {
        animation-delay: 250ms;
    }

    .product-card-fade-in:nth-child(7) {
        animation-delay: 300ms;
    }

    .product-card-fade-in:nth-child(8) {
        animation-delay: 350ms;
    }

    .product-card-fade-in:nth-child(9) {
        animation-delay: 400ms;
    }

    .product-card-fade-in:nth-child(10) {
        animation-delay: 450ms;
    }

    .product-card-fade-in:nth-child(n+11) {
        animation-delay: 0ms;
    }

    /* Loading Indicator Animation */
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>