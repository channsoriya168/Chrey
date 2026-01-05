<template>
    <div class="min-h-screen bg-gradient-to-br from-purple-900 via-slate-900 to-slate-950">
        <!-- Hero Carousel Section -->
        <HeroCarousel />

        <!-- Discount Products Section -->
        <ProductDiscount :discountProducts="discountProducts" />

        <!-- All Products Section -->
        <ProductList :products="products" />
    </div>
</template>

<script setup>
import HeroCarousel from '@/Components/Frontend/HeroCarousel.vue'
import ProductDiscount from '@/Components/Frontend/ProductDiscount.vue'
import ProductList from '@/Components/Frontend/ProductList.vue'

defineProps({
    products: {
        type: Object,
        required: true
    },
    discountProducts: {
        type: Array,
        default: () => []
    }
})
</script>
