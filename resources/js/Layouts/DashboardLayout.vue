<template>
    <div class="min-h-screen bg-background">
        <DashboardMenu v-model="drawer" :rail="rail" />
        <main class="bg-muted/20 min-h-screen" :class="{ 'ml-64': drawer && !rail, 'ml-16': rail, 'ml-0': !drawer }">
            <div class="container mx-auto px-6 py-6">
                <Card class="p-4 shadow-none border-0">
                    <DashboardAppBar @toggle-drawer="toggleDrawer" />
                    <slot />
                </Card>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import DashboardMenu from '@/Components/Dashboard/Menu.vue';
import DashboardAppBar from '@/Components/Dashboard/AppBar.vue';
import Card from '@/components/ui/Card.vue';

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