<template>
    <div class="min-h-screen">
        <!-- Hero Carousel Section -->
        <div class="max-w-7xl mx-auto px-1 sm:px-1 lg:px-1">
            <div class="relative">
                <!-- Carousel Container -->
                <div class="overflow-hidden">
                    <div class="relative h-[220px] sm:h-[280px] md:h-[500px]">
                        <!-- Slide 1 -->
                        <div v-show="currentSlide === 0" class="absolute inset-0 transition-opacity duration-500">
                            <div
                                class="grid grid-cols-2 gap-3 sm:gap-4 md:gap-8 items-center h-full px-4 py-2 sm:px-6 sm:py-8 md:px-16 md:py-0">
                                <div class="space-y-2 sm:space-y-3 md:space-y-6">
                                    <div
                                        class="inline-block bg-pink-100 text-pink-600 px-2.5 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2 rounded-full text-[11px] sm:text-xs md:text-sm font-semibold">
                                        #Big Fashion Sale
                                    </div>
                                    <h1
                                        class="text-base sm:text-2xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                                        Limited Time Offer!<br />
                                        Up to <span class="text-pink-600">50% OFF!</span>
                                    </h1>
                                    <p class="text-xs sm:text-sm md:text-lg text-gray-600 hidden sm:block">Redefine Your
                                        Everyday Style</p>
                                    <button
                                        class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-4 py-2 sm:px-6 sm:py-2.5 md:px-8 md:py-3 rounded-lg transition-colors duration-200 text-xs sm:text-sm md:text-base">
                                        Shop Now
                                    </button>
                                </div>
                                <div class="flex justify-center items-center">
                                    <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=600&h=400&fit=crop"
                                        alt="Fashion products"
                                        class="w-full h-auto max-h-[180px] sm:max-h-[240px] md:max-h-96 object-cover rounded-lg" />
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div v-show="currentSlide === 1" class="absolute inset-0 transition-opacity duration-500">
                            <div
                                class="grid grid-cols-2 gap-3 sm:gap-4 md:gap-8 items-center h-full px-4 py-2 sm:px-6 sm:py-8 md:px-16 md:py-0">
                                <div class="space-y-2 sm:space-y-3 md:space-y-6">
                                    <div
                                        class="inline-block bg-blue-100 text-blue-600 px-2.5 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2 rounded-full text-[11px] sm:text-xs md:text-sm font-semibold">
                                        #Summer Collection
                                    </div>
                                    <h1
                                        class="text-base sm:text-2xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                                        New Season<br />
                                        <span class="text-blue-600">New Styles</span>
                                    </h1>
                                    <p class="text-xs sm:text-sm md:text-lg text-gray-600 hidden sm:block">Discover the
                                        latest trends</p>
                                    <button
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 sm:px-6 sm:py-2.5 md:px-8 md:py-3 rounded-lg transition-colors duration-200 text-xs sm:text-sm md:text-base">
                                        Explore Now
                                    </button>
                                </div>
                                <div class="flex justify-center items-center">
                                    <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=600&h=400&fit=crop"
                                        alt="New collection"
                                        class="w-full h-auto max-h-[180px] sm:max-h-[240px] md:max-h-96 object-cover rounded-lg" />
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div v-show="currentSlide === 2" class="absolute inset-0 transition-opacity duration-500">
                            <div
                                class="grid grid-cols-2 gap-3 sm:gap-4 md:gap-8 items-center h-full px-4 py-2 sm:px-6 sm:py-8 md:px-16 md:py-0">
                                <div class="space-y-2 sm:space-y-3 md:space-y-6">
                                    <div
                                        class="inline-block bg-purple-100 text-purple-600 px-2.5 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2 rounded-full text-[11px] sm:text-xs md:text-sm font-semibold">
                                        #Best Sellers
                                    </div>
                                    <h1
                                        class="text-base sm:text-2xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                                        Top Rated<br />
                                        <span class="text-purple-600">Products</span>
                                    </h1>
                                    <p class="text-xs sm:text-sm md:text-lg text-gray-600 hidden sm:block">Customer
                                        favorites just for you</p>
                                    <button
                                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 sm:px-6 sm:py-2.5 md:px-8 md:py-3 rounded-lg transition-colors duration-200 text-xs sm:text-sm md:text-base">
                                        View Collection
                                    </button>
                                </div>
                                <div class="flex justify-center items-center">
                                    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=600&h=400&fit=crop"
                                        alt="Best sellers"
                                        class="w-full h-auto max-h-[180px] sm:max-h-[240px] md:max-h-96 object-cover rounded-lg" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carousel Indicators -->
                    <div
                        class="absolute bottom-1 sm:bottom-3 md:bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-1.5 md:space-x-2 z-10">
                        <button v-for="index in 3" :key="index" @click="currentSlide = index - 1" :class="[
                            'w-1.5 h-1.5 md:w-2 md:h-2 rounded-full transition-all duration-300',
                            currentSlide === index - 1 ? 'bg-pink-600 w-6 md:w-8' : 'bg-gray-300'
                        ]" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Section -->
        <div class="max-w-7xl mx-auto px-2 sm:px-2 lg:px-3 py-2 md:py-12">
            <div class="flex items-center justify-between mb-6 md:mb-8">
                <h2 class="text-xl md:text-3xl font-bold text-gray-900">Shop by Category</h2>
                <a href="#" class="text-pink-600 hover:text-pink-700 font-semibold text-xs md:text-sm">View All →</a>
            </div>

            <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3 md:gap-6">
                <div v-for="category in categories" :key="category.name"
                    class="flex flex-col items-center group cursor-pointer">
                    <div
                        class="w-14 h-14 md:w-20 md:h-20 rounded-full bg-gray-100 flex items-center justify-center mb-2 md:mb-3 group-hover:bg-pink-100 transition-colors duration-200">
                        <img :src="category.icon" :alt="category.name" class="w-7 h-7 md:w-10 md:h-10 object-contain" />
                    </div>
                    <span class="text-[10px] md:text-sm text-gray-700 text-center font-medium leading-tight">{{
                        category.name }}</span>
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <div class="flex items-center justify-between mb-6 md:mb-8">
                <h2 class="text-xl md:text-3xl font-bold text-gray-900">Featured Products</h2>
                <a href="#" class="text-pink-600 hover:text-pink-700 font-semibold text-xs md:text-sm">See All →</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-6">
                <div v-for="product in products" :key="product.id"
                    class="bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-200 overflow-hidden group cursor-pointer">
                    <div class="relative aspect-square bg-gray-100">
                        <img :src="product.image" :alt="product.name"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" />
                        <div v-if="product.discount"
                            class="absolute top-1.5 left-1.5 md:top-2 md:left-2 bg-red-500 text-white text-[10px] md:text-xs font-bold px-1.5 py-0.5 md:px-2 md:py-1 rounded">
                            -{{ product.discount }}%
                        </div>
                    </div>
                    <div class="p-2.5 md:p-4">
                        <h3 class="text-xs md:text-sm font-semibold text-gray-800 mb-1 truncate">{{ product.name }}</h3>
                        <div class="flex items-center mb-1.5 md:mb-2">
                            <div class="flex text-yellow-400 text-[10px] md:text-xs">
                                <span v-for="star in 5" :key="star">★</span>
                            </div>
                            <span class="text-[10px] md:text-xs text-gray-500 ml-1">({{ product.reviews }})</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-sm md:text-lg font-bold text-gray-900">${{ product.price }}</span>
                                <span v-if="product.originalPrice"
                                    class="text-[10px] md:text-sm text-gray-400 line-through ml-1 md:ml-2">${{
                                        product.originalPrice }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banner Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <div class="grid md:grid-cols-2 gap-3 md:gap-6">
                <div
                    class="relative rounded-xl md:rounded-2xl overflow-hidden h-40 md:h-64 bg-gradient-to-r from-orange-400 to-pink-500">
                    <div class="absolute inset-0 p-5 md:p-8 flex flex-col justify-center">
                        <h3 class="text-xl md:text-3xl font-bold text-white mb-1.5 md:mb-2">Summer Sale</h3>
                        <p class="text-white text-xs md:text-base mb-3 md:mb-4">Up to 70% off on selected items</p>
                        <button
                            class="bg-white text-pink-600 font-semibold px-4 py-1.5 md:px-6 md:py-2 rounded-lg w-fit hover:bg-gray-100 transition-colors text-sm md:text-base">
                            Shop Now
                        </button>
                    </div>
                </div>
                <div
                    class="relative rounded-xl md:rounded-2xl overflow-hidden h-40 md:h-64 bg-gradient-to-r from-blue-500 to-purple-600">
                    <div class="absolute inset-0 p-5 md:p-8 flex flex-col justify-center">
                        <h3 class="text-xl md:text-3xl font-bold text-white mb-1.5 md:mb-2">New Arrivals</h3>
                        <p class="text-white text-xs md:text-base mb-3 md:mb-4">Check out the latest products</p>
                        <button
                            class="bg-white text-purple-600 font-semibold px-4 py-1.5 md:px-6 md:py-2 rounded-lg w-fit hover:bg-gray-100 transition-colors text-sm md:text-base">
                            Explore
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted, onUnmounted } from 'vue';

    const currentSlide = ref(0);
    let slideInterval = null;

    // Auto-rotate carousel
    onMounted(() => {
        slideInterval = setInterval(() => {
            currentSlide.value = (currentSlide.value + 1) % 3;
        }, 5000);
    });

    onUnmounted(() => {
        if (slideInterval) {
            clearInterval(slideInterval);
        }
    });

    // Demo categories
    const categories = ref([
        { name: 'Electronics', icon: 'https://api.iconify.design/mdi/laptop.svg' },
        { name: 'Fashion', icon: 'https://api.iconify.design/mdi/tshirt-crew.svg' },
        { name: 'Beauty', icon: 'https://api.iconify.design/mdi/lipstick.svg' },
        { name: 'Sports', icon: 'https://api.iconify.design/mdi/basketball.svg' },
        { name: 'Home', icon: 'https://api.iconify.design/mdi/home.svg' },
        { name: 'Books', icon: 'https://api.iconify.design/mdi/book-open-page-variant.svg' },
        { name: 'Toys', icon: 'https://api.iconify.design/mdi/teddy-bear.svg' },
        { name: 'Jewelry', icon: 'https://api.iconify.design/mdi/diamond-stone.svg' },
    ]);

    // Demo products
    const products = ref([
        {
            id: 1,
            name: 'Classic White T-Shirt',
            price: 29.99,
            originalPrice: 49.99,
            discount: 40,
            image: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
            reviews: 128
        },
        {
            id: 2,
            name: 'Denim Jeans',
            price: 59.99,
            originalPrice: 89.99,
            discount: 33,
            image: 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&h=400&fit=crop',
            reviews: 95
        },
        {
            id: 3,
            name: 'Sneakers',
            price: 79.99,
            originalPrice: null,
            discount: null,
            image: 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&h=400&fit=crop',
            reviews: 234
        },
        {
            id: 4,
            name: 'Leather Jacket',
            price: 149.99,
            originalPrice: 249.99,
            discount: 40,
            image: 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400&h=400&fit=crop',
            reviews: 67
        },
        {
            id: 5,
            name: 'Summer Dress',
            price: 45.99,
            originalPrice: null,
            discount: null,
            image: 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=400&h=400&fit=crop',
            reviews: 156
        },
        {
            id: 6,
            name: 'Backpack',
            price: 39.99,
            originalPrice: 59.99,
            discount: 33,
            image: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop',
            reviews: 89
        },
        {
            id: 7,
            name: 'Sunglasses',
            price: 24.99,
            originalPrice: null,
            discount: null,
            image: 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=400&fit=crop',
            reviews: 203
        },
        {
            id: 8,
            name: 'Watch',
            price: 129.99,
            originalPrice: 199.99,
            discount: 35,
            image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop',
            reviews: 145
        },
        {
            id: 9,
            name: 'Hoodie',
            price: 49.99,
            originalPrice: 79.99,
            discount: 38,
            image: 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400&h=400&fit=crop',
            reviews: 178
        },
        {
            id: 10,
            name: 'Running Shoes',
            price: 89.99,
            originalPrice: 129.99,
            discount: 31,
            image: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop',
            reviews: 267
        },
    ]);
</script>