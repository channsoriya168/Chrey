<template>
    <div v-if="discountProducts.length > 0" class="mx-auto max-w-7xl px-4 py-6 sm:px-4 lg:px-8">
        <div class="mb-8 text-center md:mb-10">
            <h2
                class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400 md:text-4xl leading-relaxed ">
                {{ $t("Special Offers") }}</h2>
        </div>

        <div class="flex gap-5 overflow-x-auto pb-4 scrollbar-hide md:gap-6" style="scroll-behavior: smooth;">
            <Link v-for="(product, index) in discountProducts" :key="'discount-' + product.id"
                :href="`/product/${product.slug}`"
                class="group relative cursor-pointer overflow-hidden rounded-2xl bg-slate-800/80 backdrop-blur-sm border border-fuchsia-500/20 shadow-lg shadow-fuchsia-500/10 transition-all duration-300 hover:scale-[1.03] hover:shadow-2xl hover:shadow-fuchsia-500/20 hover:border-fuchsia-500/40 flex-shrink-0 w-[180px] sm:w-[220px] md:w-[260px] lg:w-[280px] discount-card-slide-in"
                :style="`animation-delay: ${index * 80}ms`">
                <!-- Image Container -->
                <div class="relative aspect-square bg-gradient-to-br from-slate-700 to-slate-800 overflow-hidden">
                    <img :src="product.first_image" :alt="product.name"
                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
                    <!-- Discount Badge -->
                    <div v-if="product.discount_price_percent > 0" class="absolute top-2 left-2 z-10">
                        <div
                            class="rounded-lg bg-gradient-to-r from-fuchsia-500 to-pink-500 px-2 py-1 shadow-xl md:rounded-xl md:px-3 md:py-2">
                            <span class="text-xs font-bold text-white">
                                {{ product.discount_price_percent }}% OFF
                            </span>
                        </div>
                    </div>
                    <!-- Overlay on hover -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-fuchsia-900/30 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
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
                    <div class="flex flex-col gap-1">
                        <div class="flex items-baseline gap-1.5">
                            <span
                                class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400 md:text-2xl">
                                ${{ product.display_price }}
                            </span>
                            <span class="text-xs text-gray-500 line-through md:text-base">
                                ${{ product.price }}
                            </span>
                        </div>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';

    defineProps({
        discountProducts: {
            type: Array,
            required: true
        }
    })
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