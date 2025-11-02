<template>
    <div class="frontend-layout">
        <header>
            <Menu />
        </header>

        <main class="main-content">
            <div class="container mx-auto px-4">
                <FlashMessage />
            </div>
            <slot />
        </main>
        <Footer />
    </div>
</template>

<script setup>
    import Menu from '@/Components/Frontend/Menu.vue'
    import Footer from '../Components/Frontend/footer.vue';
    import FlashMessage from '@/Components/FlashMessage.vue';
</script>

<style scoped>
    .frontend-layout {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .main-content {
        flex: 1;
        padding: 2rem;
        padding-top: 64px;
        /* Adjust if your app bar is a different height */
    }

    .footer {
        background-color: #f8f9fa;
        padding: 1rem;
        border-top: 1px solid #dee2e6;
        text-align: center;
        color: #6c757d;
    }
</style>
