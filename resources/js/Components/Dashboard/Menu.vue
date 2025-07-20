<template>
    <v-navigation-drawer v-model="drawer" :permanent="!mobile" :temporary="mobile" :rail="rail && !mobile" color="white"
        class="border-e" app>
        <!-- Header section with logo/title -->
        <div class="pa-4 d-flex align-center " :class="{ 'justify-center': rail && !mobile }">
            <v-avatar size="32" class="mr-3" color="orange" :class="{ 'mr-0': rail && !mobile }">
                <v-icon color="white">mdi-school</v-icon>
            </v-avatar>
            <div v-if="!rail || mobile" class="text-body-1 font-weight-medium text-black khmer-text">
                ជ្រៃ
            </div>
        </div>

        <v-divider></v-divider>

        <v-list density="compact" nav class="pa-2 bg-white">
            <v-list-item prepend-icon="mdi-apps" value="dashboard" :active="isActive('dashboard')"
                @click="navigateCallback('dashboard.index')" class="mb-1 rounded-lg hover:bg-grey-lighten-3" :class="{
                    'bg-teal-lighten-4 text-teal-darken-2': isActive('dashboard'),
                    'text-grey-darken-2': !isActive('dashboard')
                }">
                <v-list-item-title v-if="!rail || mobile" class="khmer-text">ផ្ទាំងគ្រប់គ្រង</v-list-item-title>
                <v-tooltip v-if="rail && !mobile" activator="parent" location="end">
                    <span class="khmer-text">ផ្ទាំងគ្រប់គ្រង</span>
                </v-tooltip>
            </v-list-item>

            <v-list-item prepend-icon="mdi-archive-edit-outline" value="products" :active="isActive('products')"
                @click="navigateCallback('dashboard.products.index')" class="mb-1 rounded-lg hover:bg-grey-lighten-3"
                :class="{
                    'bg-teal-lighten-4 text-teal-darken-2': isActive('products'),
                    'text-grey-darken-2': !isActive('products')
                }">
                <v-list-item-title v-if="!rail || mobile" class="khmer-text">ផលិតផល</v-list-item-title>
                <v-tooltip v-if="rail && !mobile" activator="parent" location="end">
                    <span class="khmer-text">ផលិតផល</span>
                </v-tooltip>
            </v-list-item>

            <v-list-item prepend-icon="mdi-tag-multiple-outline" value="categories" :active="isActive('categories')"
                @click="navigateCallback('dashboard.categories.index')" class="mb-1 rounded-lg hover:bg-grey-lighten-3"
                :class="{
                    'bg-teal-lighten-4 text-teal-darken-2': isActive('categories'),
                    'text-grey-darken-2': !isActive('categories')
                }">
                <v-list-item-title v-if="!rail || mobile" class="khmer-text">ប្រភេទ</v-list-item-title>
                <v-tooltip v-if="rail && !mobile" activator="parent" location="end">
                    <span class="khmer-text">ប្រភេទ</span>
                </v-tooltip>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script setup>
    import { router, usePage } from '@inertiajs/vue3';
    import { computed, ref, toRefs } from 'vue';
    import { useDisplay } from 'vuetify';

    const props = defineProps({
        modelValue: {
            type: Boolean,
            default: true
        },
        rail: {
            type: Boolean,
            default: false
        }
    });

    const emit = defineEmits(['update:modelValue']);

    const { modelValue, rail } = toRefs(props);
    const { mobile } = useDisplay();

    const drawer = computed({
        get: () => modelValue.value,
        set: (value) => emit('update:modelValue', value)
    });

    const page = usePage();

    const currentRoute = computed(() => page.url);

    const navigateCallback = (r) => {
        router.get(route(r));
    };

    const isActive = (section) => {
        const url = currentRoute.value;

        if (section === 'dashboard') {
            return url === '/dashboard' || url === '/dashboard/';
        } else if (section === 'products') {
            return url.includes('/products');
        } else if (section === 'categories') {
            return url.includes('/categories');
        }

        return false;
    };
</script>

<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@100;300;400;500;700;900&display=swap');

    .khmer-text {
        font-family: 'Noto Sans Khmer', serif !important;
        font-feature-settings: "kern" 1, "liga" 1;
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
</style>