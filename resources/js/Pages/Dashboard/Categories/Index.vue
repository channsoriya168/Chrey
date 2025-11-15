<template>
    <Head title="Categories" />
    <div class="container mx-auto py-6">
        <!-- Header -->
        <div class="mb-6 flex flex-row items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">គ្រប់គ្រងប្រភេទផលិតផលរបស់អ្នក</h1>
            </div>
            <AlertDialog v-model:open="isCreateDialogOpen">
                <AlertDialogTrigger as-child>
                    <Button class="bg-gray-950 text-white hover:bg-gray-800">
                        <Plus class="mr-2 h-4 w-4" />
                        បង្កើត
                    </Button>
                </AlertDialogTrigger>
                <AlertDialogContent class="bg-white">
                    <AlertDialogHeader>
                        <AlertDialogTitle>បង្កើតប្រភេទផលិតផល</AlertDialogTitle>
                        <!-- <vee-field name="phone" v-slot="{ field: { value, ...field } }">
                                                    <v-text-field v-bind="field"
                                                        :error-messages="fieldErrors.phone ? [fieldErrors.phone] : []"
                                                        v-model="item.phone" :label="__('Personal Phone')"
                                                        variant="outlined" type="tel"></v-text-field>
                                                </vee-field> -->
                    </AlertDialogHeader>
                    <AlertDialogDescription>
                        <Form>
                            <!-- Form fields for creating a category go here -->
                            <vee-field name="name">
                                <Input></Input>
                                
                                <!-- block for category image  -->
                            </vee-field>
                        </Form>
                    </AlertDialogDescription>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction @click="handleCreate">បង្កើត</AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </div>

        <!-- Data Table -->
        <DataTable
            :columns="columns"
            :data="categories.data"
            :loading="loading"
            :pagination="categories"
            @page-change="handlePageChange"
            @per-page-change="handlePerPageChange"
        >
            <!-- Filters Slot -->
            <!-- <template #filters>
                <Input v-model="searchQuery" placeholder="Search categories..." class="max-w-sm"
                    @input="handleSearch" />
            </template> -->

            <!-- Custom Cell: Image -->
            <template #cell-image_url="{ value }">
                <div v-if="value" class="h-12 w-12 overflow-hidden rounded-md border">
                    <img :src="`/storage/${value}`" alt="Category" class="h-full w-full object-cover" />
                </div>
                <div v-else class="bg-muted flex h-12 w-12 items-center justify-center rounded-md">
                    <span class="text-muted-foreground text-xs">No image</span>
                </div>
            </template>

            <!-- Actions Slot -->
            <template #actions="{ item }">
                <TableActions :item="item" @edit="handleEdit" @delete="handleDelete" />
            </template>

            <!-- Empty State Slot -->
            <template #empty>
                <div class="flex flex-col items-center justify-center py-12">
                    <FolderOpen class="text-muted-foreground mb-4 h-12 w-12" />
                    <h3 class="text-lg font-semibold">No categories found</h3>
                    <p class="text-muted-foreground mb-4 text-sm">Get started by creating a new category</p>
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
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger
} from '@/components/ui/alert-dialog'
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
const isCreateDialogOpen = ref(false)

// Table columns configuration
const columns = [
    {
        key: 'image_url',
        label: 'រូបភាព',
        cellClass: 'w-20'
    },
    {
        key: 'name',
        label: 'ឈ្មោះ',
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
            onStart: () => (loading.value = true),
            onFinish: () => (loading.value = false)
        })
    }
}

const handlePageChange = (page) => {
    router.get(
        '/dashboard/categories',
        {
            page,
            search: searchQuery.value
        },
        {
            preserveState: true,
            preserveScroll: true,
            onStart: () => (loading.value = true),
            onFinish: () => (loading.value = false)
        }
    )
}

const handlePerPageChange = (perPage) => {
    router.get(
        '/dashboard/categories',
        {
            per_page: perPage,
            search: searchQuery.value
        },
        {
            preserveState: true,
            preserveScroll: true,
            onStart: () => (loading.value = true),
            onFinish: () => (loading.value = false)
        }
    )
}

const handleSearch = () => {
    router.get(
        '/dashboard/categories',
        {
            search: searchQuery.value
        },
        {
            preserveState: true,
            preserveScroll: true,
            onStart: () => (loading.value = true),
            onFinish: () => (loading.value = false)
        }
    )
}
</script>
