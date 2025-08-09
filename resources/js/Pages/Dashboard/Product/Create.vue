<template>
    <v-container>
        <v-breadcrumbs class="border bg-primary text-white" :items="breadcrumbsItems"></v-breadcrumbs>
        <v-card class="mt-4 border " elevation="0">
            <v-card-title class="bg-warning">បង្កើតផលិតផល</v-card-title>
            <v-card-text>
                <vee-form :validation-schema="productSchema" v-slot="{ errors, meta }"
                    @submit.prevent="$emit('submit')">
                    <product-form v-model="item" />
                    <v-btn :disabled="!meta.valid || item.processing" :loading="item.processing" color="primary"
                        @click="$emit('submit')" class="w-full">បង្កើតផលិតផល</v-btn>
                </vee-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script setup>
    import { ref } from 'vue';
    import ProductForm from '@/Components/Dashboard/Forms/ProductForm.vue';
    import { productSchema } from '../../../validateSchema/product';
    import { useForm } from 'vuetify/lib/composables/form.mjs';

    const item = useForm({
        code: '',
        name: '',
        quantity: 0,
        price: 0,
        description: '',
        images: []
    });
    const breadcrumbsItems = ref([
        {
            title: 'ផលិតផល',
            disabled: false,
            href: '/dashboard/products'
        },
        {
            title: 'បង្កើតផលិតផល',
            disabled: true,
            href: '/dashboard/products/create'
        }
    ]);

</script>