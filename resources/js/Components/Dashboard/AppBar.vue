<template>
    <v-app-bar elevation="1" color="teal-darken-1" dark app>
        <v-app-bar-nav-icon @click="toggleDrawer" color="white"></v-app-bar-nav-icon>

        <!-- <v-app-bar-title class="text-h6 font-weight-medium text-white ml-2">
            ទំព័រគ្រប់គ្រង
        </v-app-bar-title> -->

        <v-spacer></v-spacer>

        <!-- Action buttons -->
        <v-btn icon size="small" class="mr-2">
            <v-icon color="white">mdi-cog</v-icon>
        </v-btn>

        <v-btn icon size="small" class="mr-2">
            <v-icon color="white">mdi-account</v-icon>
        </v-btn>

        <v-btn icon size="small" class="mr-2">
            <v-icon color="white">mdi-translate</v-icon>
        </v-btn>

        <v-btn icon size="small">
            <v-icon color="white">mdi-bell</v-icon>
        </v-btn>
    </v-app-bar>
</template>

<script setup>
    const emit = defineEmits(['toggle-drawer']);

    const toggleDrawer = () => {
        emit('toggle-drawer');
    };
</script>
