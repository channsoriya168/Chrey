<template>
    <div class="min-h-screen">
        <!-- Hero Carousel Section -->
        <div class="mx-auto max-w-7xl px-1 sm:px-1 lg:px-1 pt-2">
            <div class="relative">
                <!-- Carousel Container -->
                <div class="overflow-hidden">
                    <div class="relative h-[220px] sm:h-[280px] md:h-[500px]">
                        <!-- Slide 1 -->
                        <div v-show="currentSlide === 0" class="absolute inset-0 transition-opacity duration-500">
                            <div
                                class="grid h-full grid-cols-2 items-center gap-3 px-4 py-2 sm:gap-4 sm:px-6 sm:py-8 md:gap-8 md:px-16 md:py-0">
                                <div class="space-y-2 sm:space-y-3 md:space-y-6">
                                    <h1
                                        class="text-base leading-tight font-bold text-gray-900 sm:text-2xl md:text-5xl lg:text-6xl">
                                        {{ t('home.hero.slide1.title') }}<br />
                                        {{ t('home.hero.slide1.subtitle').replace('100%', '') }}
                                        <span class="text-pink-600">100%</span>
                                    </h1>
                                    <p class="hidden text-xs text-gray-600 sm:block sm:text-sm md:text-lg"></p>
                                </div>
                                <div class="flex items-center justify-center">
                                    <img :src="firstImage" alt="Fashion products"
                                        class="h-auto max-h-[180px] w-full rounded-lg object-cover sm:max-h-[240px] md:max-h-96" />
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div v-show="currentSlide === 1" class="absolute inset-0 transition-opacity duration-500">
                            <div
                                class="grid h-full grid-cols-2 items-center gap-3 px-4 py-2 sm:gap-4 sm:px-6 sm:py-8 md:gap-8 md:px-16 md:py-0">
                                <div class="space-y-2 sm:space-y-3 md:space-y-6">
                                    <h1
                                        class="text-base leading-tight font-bold text-gray-900 sm:text-2xl md:text-5xl lg:text-6xl">
                                        {{ t('home.hero.slide2.title') }}<br />
                                        <span class="text-purple-600">{{ t('home.hero.slide2.subtitle') }}</span>
                                    </h1>
                                    <p class="hidden text-xs text-gray-600 sm:block sm:text-sm md:text-lg">
                                        {{ t('home.hero.slide2.description') }}
                                    </p>
                                </div>
                                <div class="flex items-center justify-center">
                                    <img :src="secondImage" alt="Best sellers"
                                        class="h-auto max-h-[180px] w-full rounded-lg object-cover sm:max-h-[240px] md:max-h-96" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carousel Indicators -->
                    <div
                        class="absolute bottom-1 left-1/2 z-10 flex -translate-x-1/2 transform space-x-1.5 sm:bottom-3 md:bottom-6 md:space-x-2">
                        <button v-for="index in 2" :key="index" @click="currentSlide = index - 1" :class="[
                            'h-1.5 w-1.5 rounded-full transition-all duration-300 md:h-2 md:w-2',
                            currentSlide === index - 1 ? 'w-6 bg-pink-600 md:w-8' : 'bg-gray-300'
                        ]" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Discount Products Section -->
        <div v-if="discountProducts.length > 0" class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center justify-between md:mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 md:text-3xl">Special Offers</h2>
                    <p class="mt-1 text-sm text-gray-500">Limited time deals - Don't miss out!</p>
                </div>
            </div>

            <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide md:gap-6" style="scroll-behavior: smooth;">
                <Link v-for="(product, index) in discountProducts" :key="'discount-' + product.id"
                    :href="`/product/${product.slug}`"
                    class="group relative cursor-pointer overflow-hidden rounded-2xl bg-white border border-gray-200 transition-all duration-300 hover:border-gray-300 hover:shadow-xl flex-shrink-0 w-[160px] sm:w-[200px] md:w-[240px] discount-card-slide-in"
                    :style="`animation-delay: ${index * 80}ms`">
                    <!-- Image Container -->
                    <div class="relative aspect-square bg-gradient-to-br from-gray-100 to-gray-50 overflow-hidden">
                        <img :src="getImageUrl(product)" :alt="product.name"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
                        <!-- Discount Badge -->
                        <div class="absolute top-3 left-3 z-10">
                            <div class="rounded-xl bg-gradient-to-r from-red-500 to-pink-500 px-3 py-1.5 shadow-lg">
                                <span class="text-xs font-bold text-white md:text-sm">
                                    -{{ calculateDiscount(product.price, product.discount_price) }}%
                                </span>
                            </div>
                        </div>
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-black/0 transition-colors duration-300 group-hover:bg-black/5">
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-3 md:p-4">
                        <h3 class="mb-2 line-clamp-2 min-h-[2.5rem] text-sm font-semibold text-gray-900 md:text-base">
                            {{ product.name }}
                        </h3>

                        <!-- Ratings -->
                        <div class="mb-3 flex items-center gap-1">
                            <div class="flex text-yellow-400">
                                <span v-for="star in 5" :key="star" class="text-xs md:text-sm">★</span>
                            </div>
                            <span class="text-xs text-gray-500">(0)</span>
                        </div>

                        <!-- Price -->
                        <div class="flex flex-col gap-1">
                            <div class="flex items-baseline gap-2">
                                <span class="text-lg font-bold text-gray-900 md:text-xl">
                                    ${{ getDisplayPrice(product) }}
                                </span>
                                <span class="text-sm text-gray-400 line-through md:text-base">
                                    ${{ product.price }}
                                </span>
                            </div>
                            <span class="text-xs font-medium text-green-600">
                                Save ${{ (product.price - product.discount_price).toFixed(2) }}
                            </span>
                        </div>
                    </div>
                </Link>
            </div>
        </div>

        <!-- All Products Section -->
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 md:py-12 lg:px-8">
            <div class="mb-6 flex items-center justify-between md:mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 md:text-3xl">{{ t('home.products.featured') }}</h2>
                    <p class="mt-1 text-sm text-gray-500">Discover our full collection</p>
                </div>
            </div>

            <!-- Initial Loading Shimmer -->
            <div v-if="isInitialLoad" class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:gap-6 lg:grid-cols-4 xl:grid-cols-5">
                <div v-for="i in 10" :key="'initial-shimmer-' + i" class="overflow-hidden rounded-2xl bg-white border border-gray-200 shimmer-card">
                    <!-- Image Shimmer -->
                    <div class="relative aspect-square bg-gradient-to-br from-gray-200 via-gray-100 to-gray-200 shimmer-bg"></div>

                    <!-- Content Shimmer -->
                    <div class="p-3 md:p-4 space-y-3">
                        <div class="space-y-2">
                            <div class="h-4 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-4 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded w-3/4 shimmer-bg"></div>
                        </div>
                        <div class="flex gap-1">
                            <div class="h-3 w-3 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-3 w-3 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-3 w-3 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-3 w-3 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-3 w-3 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                        </div>
                        <div class="flex gap-2">
                            <div class="h-6 w-20 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-6 w-16 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div v-else class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:gap-6 lg:grid-cols-4 xl:grid-cols-5">
                <Link v-for="product in allProducts" :key="product.id" :href="`/product/${product.slug}`"
                    class="group relative cursor-pointer overflow-hidden rounded-2xl bg-white border border-gray-200 transition-all duration-300 hover:border-gray-300 hover:shadow-xl product-card-fade-in">
                    <!-- Image Container -->
                    <div class="relative aspect-square bg-gradient-to-br from-gray-100 to-gray-50 overflow-hidden">
                        <img :src="getImageUrl(product)" :alt="product.name"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
                        <!-- Discount Badge (if applicable) -->
                        <div v-if="calculateDiscount(product.price, product.discount_price)"
                            class="absolute top-3 left-3 z-10">
                            <div class="rounded-xl bg-gradient-to-r from-red-500 to-pink-500 px-3 py-1.5 shadow-lg">
                                <span class="text-xs font-bold text-white md:text-sm">
                                    -{{ calculateDiscount(product.price, product.discount_price) }}%
                                </span>
                            </div>
                        </div>
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-black/0 transition-colors duration-300 group-hover:bg-black/5">
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-3 md:p-4">
                        <h3 class="mb-2 line-clamp-2 min-h-[2.5rem] text-sm font-semibold text-gray-900 md:text-base">
                            {{ product.name }}
                        </h3>

                        <!-- Ratings -->
                        <div class="mb-3 flex items-center gap-1">
                            <div class="flex text-yellow-400">
                                <span v-for="star in 5" :key="star" class="text-xs md:text-sm">★</span>
                            </div>
                            <span class="text-xs text-gray-500">(0)</span>
                        </div>

                        <!-- Price -->
                        <div class="flex items-baseline gap-2">
                            <span class="text-lg font-bold text-gray-900 md:text-xl">
                                ${{ getDisplayPrice(product) }}
                            </span>
                            <span v-if="product.discount_price && product.discount_price < product.price"
                                class="text-sm text-gray-400 line-through md:text-base">
                                ${{ product.price }}
                            </span>
                        </div>
                    </div>
                </Link>
            </div>

            <!-- Loading Shimmer (Infinite Scroll) -->
            <div v-if="isLoading" class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 md:gap-6 lg:grid-cols-4 xl:grid-cols-5">
                <div v-for="i in 10" :key="'shimmer-' + i" class="overflow-hidden rounded-2xl bg-white border border-gray-200 shimmer-card" :style="`animation-delay: ${i * 50}ms`">
                    <!-- Image Shimmer -->
                    <div class="relative aspect-square bg-gradient-to-br from-gray-200 via-gray-100 to-gray-200 shimmer-bg"></div>

                    <!-- Content Shimmer -->
                    <div class="p-3 md:p-4 space-y-3">
                        <div class="space-y-2">
                            <div class="h-4 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-4 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded w-3/4 shimmer-bg"></div>
                        </div>
                        <div class="flex gap-1">
                            <div class="h-3 w-3 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-3 w-3 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-3 w-3 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-3 w-3 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-3 w-3 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                        </div>
                        <div class="flex gap-2">
                            <div class="h-6 w-20 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                            <div class="h-6 w-16 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 rounded shimmer-bg"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End of results message -->
            <div v-else-if="!hasMorePages && allProducts.length > 0" class="mt-8 text-center" style="animation: fadeInUp 0.5s ease-out">
                <p class="text-gray-500 text-sm">{{ t('home.pagination.noMore') || 'No more products to load' }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted, onUnmounted, computed } from 'vue'
    import { Link, router } from '@inertiajs/vue3'
    import { useI18n } from 'vue-i18n'
    import firstImage from '@/../images/01.png'
    import secondImage from '@/../images/02.png'

    const { t } = useI18n()

    const props = defineProps({
        products: {
            type: Object,
            required: true
        }
    })

    const currentSlide = ref(0)
    let slideInterval = null
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

    // Filter products with discounts
    const discountProducts = computed(() => {
        if (!props.products || !props.products.data) return []
        return props.products.data.filter(product => {
            return product.discount_price && product.discount_price < product.price
        })
    })

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

    // Auto-rotate carousel
    onMounted(() => {
        slideInterval = setInterval(() => {
            currentSlide.value = (currentSlide.value + 1) % 2
        }, 5000)

        // Add scroll listener for infinite scroll
        window.addEventListener('scroll', handleScroll)
    })

    onUnmounted(() => {
        if (slideInterval) {
            clearInterval(slideInterval)
        }
        window.removeEventListener('scroll', handleScroll)
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
</script>

<style scoped>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }

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
    .product-card-fade-in:nth-child(1) { animation-delay: 0ms; }
    .product-card-fade-in:nth-child(2) { animation-delay: 50ms; }
    .product-card-fade-in:nth-child(3) { animation-delay: 100ms; }
    .product-card-fade-in:nth-child(4) { animation-delay: 150ms; }
    .product-card-fade-in:nth-child(5) { animation-delay: 200ms; }
    .product-card-fade-in:nth-child(6) { animation-delay: 250ms; }
    .product-card-fade-in:nth-child(7) { animation-delay: 300ms; }
    .product-card-fade-in:nth-child(8) { animation-delay: 350ms; }
    .product-card-fade-in:nth-child(9) { animation-delay: 400ms; }
    .product-card-fade-in:nth-child(10) { animation-delay: 450ms; }
    .product-card-fade-in:nth-child(n+11) { animation-delay: 0ms; }

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

    /* Discount Products Slide In Animation */
    @keyframes discountSlideIn {
        0% {
            opacity: 0;
            transform: translateX(-30px) scale(0.95);
        }
        100% {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }

    .discount-card-slide-in {
        animation: discountSlideIn 0.5s ease-out forwards;
        opacity: 0;
    }
</style>
