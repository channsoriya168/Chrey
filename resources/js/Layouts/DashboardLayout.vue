<template>
    <v-app>
        <DashboardMenu v-model="drawer" :rail="rail" />
        <v-main class="bg-grey-lighten-5">
            <v-container fluid class="pa-6">
                <v-card class="pa-4" elevation="0">
                    <DashboardAppBar @toggle-drawer="toggleDrawer" />
                    <slot />
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
    import { ref } from 'vue';
    import { useDisplay } from 'vuetify';
    import DashboardMenu from '@/Components/Dashboard/Menu.vue';
    import DashboardAppBar from '@/Components/Dashboard/AppBar.vue';

    const { mobile } = useDisplay();

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
</script>