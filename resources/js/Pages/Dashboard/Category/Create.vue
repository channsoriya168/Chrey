<template>

    <Head title="Create Category" />
    <v-container>
        <v-breadcrumbs :items="breadcrumbsItems" class="mb-4" />
        <v-card>
            <v-card-title class="bg-primary flex flex-row justify-between items-center px-4 py-3">
                <span class="text-white font-medium">បង្កើតប្រភេទផលិតផល</span>
            </v-card-title>
            <v-card-text>
                <v-form class="py-4" :validation-schema="validationSchema" @submit.prevent="createCategory">
                    <vee-field name="name" v-slot="{ field, errors }">
                        <v-text-field v-bind="field" v-model="item.name" name="name" :error-messages="errors"
                            :label="'ឈ្មោះប្រភេទផលិតផល'" variant="outlined" class="mb-4">
                        </v-text-field>
                    </vee-field>
                    <vee-field name="image_url" v-slot="{ field, errors }">
                        <v-file-input v-bind="field" v-model="item.image_url" name="image_url" :error-messages="errors"
                            label="រូបភាព" variant="outlined" class="mb-4">
                        </v-file-input>
                    </vee-field>
                    <v-btn type="submit" color="primary" class="w-100">បង្កើត</v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import { router, Head } from '@inertiajs/vue3';
    import * as yup from "yup";

    const validationSchema = yup.object().shape({
        name: yup.string().required("ឈ្មោះប្រភេទផលិតផល is required"),
        image_url: yup.mixed().required("រូបភាព is required"),
    });

    const item = useForm({
        name: '',
        image_url: null,
    });

    const breadcrumbsItems = ref([
        {
            title: 'ប្រភេទផលិតផល',
            disabled: false,
            href: '/dashboard/categories'
        },
        {
            title: 'បង្កើតប្រភេទផលិតផល',
            disabled: true,
            href: '/dashboard/categories/create'
        }
    ]);

    const createCategory = () => {
        const formData = new FormData();
        formData.append('name', item.name);
        formData.append('image_url', item.image_url);

        router.visit(route('dashboard.categories.store'), {
            method: 'post',
            data: formData,
            forceFormData: true,
        });
    };
</script>