<template>
    <v-container>
        <v-breadcrumbs class="border bg-primary text-white" :items="breadcrumbsItems"></v-breadcrumbs>
        <v-card class="mt-4 d-flex align-center justify-space-between">
            <v-card-title>បង្កើតផលិតផលថ្មី</v-card-title>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="createProductCallback()">បង្កើតផលិតផល</v-btn>
            <v-card-text>
                <!-- Form for creating a new product will go here -->
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script setup>
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';
    const breadcrumbsItems = ref([
        {
            title: 'ផលិតផល',
            disabled: true,
            href: '/dashboard/products'
        }
    ]);

    const createProductCallback = () => {
        router.visit(route('dashboard.products.create'));
    };

</script>
