<template>
    <div class="min-h-screen bg-gray-50">
        <DashboardMenu v-model="drawer" :rail="rail" />
        <DashboardAppBar
            @toggle-drawer="toggleDrawer"
            :drawer="drawer"
            :rail="rail"
        />
        <main class="bg-gray-50 min-h-screen transition-all duration-300 pt-[57px]" :class="{ 'ml-64': drawer && !rail, 'ml-16': rail, 'ml-0': !drawer }">
            <div class="px-6 py-6">
                <FlashMessage />
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import DashboardMenu from '@/Components/Dashboard/Menu.vue';
import DashboardAppBar from '@/Components/Dashboard/AppBar.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

const windowWidth = ref(window.innerWidth);
const mobile = computed(() => windowWidth.value < 768);

const drawer = ref(true);
const rail = ref(false);

const toggleDrawer = () => {
    if (mobile.value) {
        drawer.value = !drawer.value;
    } else {
        rail.value = !rail.value;
        if (rail.value) {
            drawer.value = true;
        }
    }
};

const handleResize = () => {
    windowWidth.value = window.innerWidth;
};

onMounted(() => {
    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
});
</script>