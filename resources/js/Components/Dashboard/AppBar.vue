<template>
    <v-app-bar elevation="1" color="teal-darken-1" dark app>
        <v-app-bar-nav-icon @click="toggleDrawer" color="white"></v-app-bar-nav-icon>

        <v-spacer></v-spacer>

        <!-- Action buttons -->
        <v-btn icon size="small" class="mr-2">
            <v-icon color="white">mdi-cog</v-icon>
        </v-btn>

        <v-menu>
            <template #activator="{ props }">
                <v-btn icon size="small" class="mr-2" v-bind="props">
                    <v-icon color="white">mdi-account</v-icon>
                </v-btn>
            </template>
            <v-list class="pa-0">
                <v-list-item>
                    <v-list-item-title> <v-icon>mdi-logout</v-icon> ចាកចេញ</v-list-item-title>
                </v-list-item>

            </v-list>
        </v-menu>

        <!-- Language selector -->
        <v-menu>
            <template v-slot:activator="{ props }">
                <v-btn icon size="small" class="mr-2" v-bind="props">
                    <v-icon color="white">mdi-translate</v-icon>
                </v-btn>
            </template>
            <v-list class="pa-0">
                <v-list-item v-for="language in languages" :key="language.code" @click="changeLanguage(language.code)"
                    :class="{ 'bg-grey-lighten-2': currentLanguage === language.code }">
                    <template v-slot:prepend>
                        <v-icon>{{ language.icon }}</v-icon>
                    </template>
                    <v-list-item-title>{{ language.name }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>

        <!-- <v-btn icon size="small">
            <v-icon color="white">mdi-bell</v-icon>
        </v-btn> -->
    </v-app-bar>
</template>

<script setup>
    import { ref } from 'vue';

    const emit = defineEmits(['toggle-drawer']);

    const currentLanguage = ref('en');

    const languages = ref([
        { code: 'en', name: 'English', icon: 'mdi-flag' },
        { code: 'km', name: 'ខ្មែរ (Khmer)', icon: 'mdi-flag' },
    ]);

    const toggleDrawer = () => {
        emit('toggle-drawer');
    };

    const changeLanguage = (languageCode) => {
        currentLanguage.value = languageCode;
    };
</script>
