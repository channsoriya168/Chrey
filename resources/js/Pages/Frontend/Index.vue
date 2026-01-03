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
import { computed } from 'vue'

const props = defineProps({
    products: {
        type: Object,
        required: true
    }
})

// Filter products with discounts
const discountProducts = computed(() => {
    if (!props.products || !props.products.data) return []
    return props.products.data.filter(product => product.has_discount)
})
</script>
