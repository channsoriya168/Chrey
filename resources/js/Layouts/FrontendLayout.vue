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
    import FlashMessage from '@/Components/FlashMessage.vue';
    import Menu from '@/Components/Frontend/Menu.vue';
    import { Toaster } from '@/Components/ui/sonner';
    import Footer from '../Components/Frontend/footer.vue';
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
