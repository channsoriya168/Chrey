<template>
    <Head title="Categories" />
    <div class="space-y-4">
        <Breadcrumb 
            class="bg-primary text-white px-4 py-2 rounded-md border" 
            :items="breadcrumbsItems" 
        />
        
        <Card>
            <CardHeader class="bg-primary text-white">
                <div class="flex items-center justify-between">
                    <CardTitle class="khmer-text text-white">ប្រភេទផលិតផល</CardTitle>
                    <Button variant="secondary" @click="createCategory" class="khmer-text">
                        បង្កើត
                    </Button>
                </div>
            </CardHeader>
            <CardContent class="p-0">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-24">រូបភាព</TableHead>
                            <TableHead>ឈ្មោះប្រភេទ</TableHead>
                            <TableHead class="w-36">សកម្មភាព</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="category in props.categories" :key="category.id">
                            <TableCell>
                                <img 
                                    :src="category.image_url ? `/storage/${category.image_url}` : '/images/placeholder.png'"
                                    :alt="category.name" 
                                    class="w-15 h-15 object-cover rounded"
                                />
                            </TableCell>
                            <TableCell class="font-medium">{{ category.name }}</TableCell>
                            <TableCell>
                                <div class="flex space-x-2">
                                    <Button 
                                        variant="ghost" 
                                        size="sm" 
                                        @click="viewCategory(category.id)"
                                        class="text-blue-600 hover:text-blue-800"
                                    >
                                        <Eye class="h-4 w-4" />
                                    </Button>
                                    <Button 
                                        variant="ghost" 
                                        size="sm" 
                                        @click="editCategory(category.id)"
                                        class="text-green-600 hover:text-green-800"
                                    >
                                        <Pencil class="h-4 w-4" />
                                    </Button>
                                    <Button 
                                        variant="ghost" 
                                        size="sm" 
                                        @click="deleteCategory(category.id)"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>
        </Card>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import { Head, router } from '@inertiajs/vue3';
    import Card from '@/components/ui/Card.vue';
    import CardHeader from '@/components/ui/CardHeader.vue';
    import CardTitle from '@/components/ui/CardTitle.vue';
    import CardContent from '@/components/ui/CardContent.vue';
    import Button from '@/components/ui/Button.vue';
    import Breadcrumb from '@/components/ui/Breadcrumb.vue';
    import Table from '@/components/ui/Table.vue';
    import TableHeader from '@/components/ui/TableHeader.vue';
    import TableBody from '@/components/ui/TableBody.vue';
    import TableRow from '@/components/ui/TableRow.vue';
    import TableHead from '@/components/ui/TableHead.vue';
    import TableCell from '@/components/ui/TableCell.vue';
    import { Eye, Pencil, Trash2 } from 'lucide-vue-next';

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