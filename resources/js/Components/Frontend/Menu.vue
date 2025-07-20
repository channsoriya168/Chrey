<template>
    <v-app-bar elevation="0">
        <v-container class="d-flex justify-between align-center">
            <Link v-for="pageItem in pages" :key="pageItem.path" :href="pageItem.path" class="menu"
                :class="{ 'active': $page.url === pageItem.path }" tabindex="0">
            {{ pageItem.name }}
            </Link>
            <v-spacer></v-spacer>

            <!-- order -->
            <v-btn elevation="0" text to="/order"><v-icon>mdi-cart</v-icon> Order</v-btn>
            <!-- cart -->
            <v-btn elevation="0" text to="/cart"><v-icon>mdi-cart-outline</v-icon> Cart</v-btn>
            <!-- change language -->
            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn elevation="0" icon size="small" class="mr-2" v-bind="props">
                        <v-icon color="black">mdi-translate</v-icon>
                    </v-btn>
                </template>
                <v-list class="pa-0">
                    <v-list-item v-for="language in languages" :key="language.code"
                        @click="changeLanguage(language.code)"
                        :class="{ 'bg-grey-lighten-2': currentLanguage === language.code }">
                        <template v-slot:prepend>
                            <v-icon>{{ language.icon }}</v-icon>
                        </template>
                        <v-list-item-title>{{ language.name }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-btn elevation="0" icon>
                <v-icon>mdi-account</v-icon>
            </v-btn>

        </v-container>
    </v-app-bar>
</template>
<script setup>
    import { ref } from 'vue';
    import { usePage } from '@inertiajs/vue3';

    const page = usePage();

    const pages = ref([
        { name: 'ទំព័រដើម', path: '/' },
        { name: 'អំពី', path: '/about' },
        { name: 'ទំនាក់ទំនង', path: '/contact' },
    ]);

    const languages = ref([
        { code: 'en', name: 'English', icon: 'mdi-flag-uk' },
        { code: 'km', name: 'ខ្មែរ (Khmer)', icon: 'mdi-flag' },
    ]);

    const currentLanguage = ref('en');

    function changeLanguage(code) {
        currentLanguage.value = code;
    }
</script>

<style scoped>
    .menu {
        padding: 7px 12px;
        margin-right: 20px;
        font-family: 'Courier New', Courier, monospace;
        border-radius: 10px;
        outline: none;
        transition: background 0.2s, color 0.2s;
        cursor: pointer;
        color: inherit;
        text-decoration: none;
    }

    .menu:hover,
    .menu:focus {
        background-color: #a09d9d;
        color: #222;
    }

    .menu.active,
    .menu:active {
        background-color: #7e7b7b;
        color: #fff;
    }
</style>
