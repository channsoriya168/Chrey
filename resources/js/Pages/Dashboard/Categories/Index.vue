<template>
    <div class="container mx-auto py-6">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-muted-foreground mb-6">
            <span class="text-foreground">Categories</span>
        </div>

        <!-- Header -->
        <div class="flex flex-row justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-semibold">Categories</h1>
                <p class="text-sm text-muted-foreground">Manage your product categories</p>
            </div>
            <Button @click="handleCreate">
                <Plus class="mr-2 h-4 w-4" />
                បង្កើត
            </Button>
        </div>

        <!-- Data Table -->
        <DataTable :columns="columns" :data="categories.data" :loading="loading" :pagination="categories"
            @page-change="handlePageChange" @per-page-change="handlePerPageChange">
            <!-- Filters Slot -->
            <template #filters>
                <Input v-model="searchQuery" placeholder="Search categories..." class="max-w-sm"
                    @input="handleSearch" />
            </template>

            <!-- Custom Cell: Image -->
            <template #cell-image_url="{ value }">
                <div v-if="value" class="h-12 w-12 rounded-md overflow-hidden border">
                    <img :src="`/storage/${value}`" alt="Category" class="h-full w-full object-cover" />
                </div>
                <div v-else class="h-12 w-12 rounded-md bg-muted flex items-center justify-center">
                    <span class="text-xs text-muted-foreground">No image</span>
                </div>
            </template>

            <!-- Actions Slot -->
            <template #actions="{ item }">
                <TableActions :item="item" @edit="handleEdit" @delete="handleDelete" />
            </template>

            <!-- Empty State Slot -->
            <template #empty>
                <div class="flex flex-col items-center justify-center py-12">
                    <FolderOpen class="h-12 w-12 text-muted-foreground mb-4" />
                    <h3 class="text-lg font-semibold">No categories found</h3>
                    <p class="text-sm text-muted-foreground mb-4">Get started by creating a new category</p>
                    <Button @click="handleCreate" size="sm">
                        <Plus class="mr-2 h-4 w-4" />
                        Create Category
                    </Button>
                </div>
            </template>
        </DataTable>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import { router } from '@inertiajs/vue3'
    import Button from '@/Components/ui/Button.vue'
    import DataTable from '@/Components/ui/DataTable.vue'
    import TableActions from '@/Components/ui/TableActions.vue'
    import Input from '@/Components/ui/Input.vue'
    import { Plus, FolderOpen } from 'lucide-vue-next'

    // Props from Inertia
    const props = defineProps({
        categories: {
            type: Object,
            default: () => ({
                data: [],
                current_page: 1,
                last_page: 1,
                per_page: 10,
                total: 0,
                from: 0,
                to: 0
            })
        }
    })

    // State
    const loading = ref(false)
    const searchQuery = ref('')

    // Table columns configuration
    const columns = [
        {
            key: 'image_url',
            label: 'Image',
            cellClass: 'w-20'
        },
        {
            key: 'name',
            label: 'Name',
            cellClass: 'font-medium'
        }
    ]

    // Handlers
    const handleCreate = () => {
        router.visit('/dashboard/categories/create')
    }

    const handleEdit = (item) => {
        router.visit(`/dashboard/categories/${item.id}/edit`)
    }

    const handleDelete = (item) => {
        if (confirm(`Are you sure you want to delete "${item.name}"?`)) {
            router.delete(`/dashboard/categories/${item.id}`, {
                preserveScroll: true,
                onStart: () => loading.value = true,
                onFinish: () => loading.value = false
            })
        }
    }

    const handlePageChange = (page) => {
        router.get('/dashboard/categories', {
            page,
            search: searchQuery.value
        }, {
            preserveState: true,
            preserveScroll: true,
            onStart: () => loading.value = true,
            onFinish: () => loading.value = false
        })
    }

    const handlePerPageChange = (perPage) => {
        router.get('/dashboard/categories', {
            per_page: perPage,
            search: searchQuery.value
        }, {
            preserveState: true,
            preserveScroll: true,
            onStart: () => loading.value = true,
            onFinish: () => loading.value = false
        })
    }

    const handleSearch = () => {
        router.get('/dashboard/categories', {
            search: searchQuery.value
        }, {
            preserveState: true,
            preserveScroll: true,
            onStart: () => loading.value = true,
            onFinish: () => loading.value = false
        })
    }
</script>