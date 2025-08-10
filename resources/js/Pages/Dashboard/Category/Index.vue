<template>

    <Head title="Categories" />
    <v-container>
        <v-breadcrumbs :items="breadcrumbsItems" class="mb-4" />
        <v-card>
            <v-card-title class="bg-primary d-flex align-center pa-4">
                <span class="text-white font-weight-medium">ប្រភេទផលិតផល</span>
                <v-spacer />
                <v-btn color="white" @click="createCategory">បង្កើត</v-btn>
            </v-card-title>
            <v-card-text>

                <v-data-table :headers="headers" :items="props.categories" item-key="id" class="elevation-0"
                    :items-per-page="10">
                    <template v-slot:item.image_url="{ item }">
                        <v-img :src="item.image_url ? `/storage/${item.image_url}` : '/images/placeholder.png'"
                            :alt="item.name" width="60" height="60" class="rounded" cover />
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <v-btn color="info" size="small" variant="text" @click="viewCategory(item.id)" class="me-2">
                            <v-icon>mdi-eye</v-icon>
                        </v-btn>

                        <v-btn color="primary" size="small" variant="text" @click="editCategory(item.id)" class="me-2">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>

                        <v-btn color="error" size="small" variant="text" @click="deleteCategory(item.id)">
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
    import { ref } from 'vue';
    import { Head, router } from '@inertiajs/vue3';

    const props = defineProps({
        categories: {
            type: Array,
            default: () => []
        }
    });

    const breadcrumbsItems = ref([
        {
            title: 'ប្រភេទផលិតផល',
            disabled: true,
            href: '/dashboard/categories'
        },
    ]);

    const headers = ref([
        {
            title: 'រូបភាព',
            key: 'image_url',
            sortable: false,
            width: '100px'
        },
        {
            title: 'ឈ្មោះប្រភេទ',
            key: 'name',
            sortable: true
        },
        {
            title: 'សកម្មភាព',
            key: 'actions',
            sortable: false,
            width: '150px'
        }
    ]);

    // Function to handle category creation
    const createCategory = () => {
        router.get(route('dashboard.categories.create'), {
            preserveState: true,
            replace: true
        });
    };

    // Function to view category details
    const viewCategory = (id) => {
        router.get(route('dashboard.categories.show', id), {
            preserveState: true,
            replace: true
        });
    };

    // Function to edit category
    const editCategory = (id) => {
        router.get(route('dashboard.categories.edit', id), {
            preserveState: true,
            replace: true
        });
    };

    // Function to delete category
    const deleteCategory = (id) => {
        if (confirm('តើអ្នកពិតជាចង់លុបប្រភេទនេះមែនទេ?')) {
            router.delete(route('dashboard.categories.destroy', id), {
                preserveState: false,
                onSuccess: (page) => {
                    // Force page refresh to show updated data
                    window.location.reload();
                },
                onError: (errors) => {
                    console.error('Error deleting category:', errors);
                    alert('មានបញ្ហាក្នុងការលុប។ សូមព្យាយាមម្តងទៀត។');
                }
            });
        }
    };
</script>