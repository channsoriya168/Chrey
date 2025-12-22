<template>
    <div class="frontend-layout bg-gradient-to-b from-white via-gray-50 to-white">
        <Menu />

        <main class="main-content">
            <FlashMessage />
            <slot />
        </main>
        <Footer />
        <Toaster richColors position="top-right" />
    </div>
</template>

<script setup>
import Menu from '@/Components/Frontend/Menu.vue'
import Footer from '../Components/Frontend/footer.vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import { Toaster } from '@/components/ui/sonner'
</script>

<style scoped>
.frontend-layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.main-content {
    flex: 1;
}
</style>
