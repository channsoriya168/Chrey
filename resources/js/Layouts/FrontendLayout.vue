<template>
    <v-app class="frontend-layout">
        <header>
            <Menu />
        </header>

        <v-main class="main-content">
            <slot />
        </v-main>

        <footer class="footer">
            <p>&copy; 2025 Your App Name. All rights reserved.</p>
        </footer>
    </v-app>
</template>

<script setup>
    import Menu from '@/Components/Frontend/Menu.vue'
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
