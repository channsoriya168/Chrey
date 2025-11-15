<template>
    <Head title="Categories" />
    <div class="container mx-auto py-6">
        <!-- Header -->
        <div class="mb-6 flex flex-row items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">គ្រប់គ្រងប្រភេទផលិតផលរបស់អ្នក</h1>
            </div>
            <Button @click="isCreateDialogOpen = true" class="bg-gray-950 text-white hover:bg-gray-800">
                <Plus class="mr-2 h-4 w-4" />
                បង្កើត
            </Button>
            <AlertDialog v-model:open="isCreateDialogOpen">
                <AlertDialogContent class="max-w-md bg-white">
                    <AlertDialogHeader>
                        <AlertDialogTitle>បង្កើតប្រភេទផលិតផល</AlertDialogTitle>
                    </AlertDialogHeader>
                    <div class="space-y-4 py-4">
                        <!-- Name Field -->
                        {{ item }}
                        <div class="space-y-2">
                            <label for="name" class="text-sm font-medium">ឈ្មោះ *</label>
                            <vee-field name="name" v-model="form.name" v-slot="{ field }">
                                <Input v-bind="field" id="name" placeholder="ឈ្មោះប្រភេទ" />
                            </vee-field>
                            <p v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</p>
                        </div>
                        <!-- Image Field -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium">រូបភាព</label>

                            <!-- Single hidden file input shared by both upload and preview -->
                            <input
                                ref="fileInput"
                                type="file"
                                @change="handleImageChange"
                                accept="image/*"
                                class="hidden"
                            />

                            <!-- Image Preview or Upload Button -->
                            <div v-if="imagePreview" class="relative overflow-hidden rounded-lg border border-gray-300">
                                <img :src="imagePreview" alt="Preview" class="h-48 w-full object-cover" />
                                <div class="absolute top-2 right-2 flex gap-2">
                                    <button
                                        type="button"
                                        @click="clearImage"
                                        class="rounded-full bg-red-500 p-2 text-white shadow-lg hover:bg-red-600"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                    <button
                                        type="button"
                                        @click="$refs.fileInput.click()"
                                        class="rounded-full bg-indigo-500 p-2 text-white shadow-lg hover:bg-indigo-600"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <button
                                v-else
                                type="button"
                                @click="$refs.fileInput.click()"
                                class="flex w-full flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-white px-4 py-8 transition-colors hover:border-indigo-400 hover:bg-indigo-50"
                            >
                                <svg
                                    class="mb-2 h-12 w-12 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                    />
                                </svg>
                                <span class="mb-1 text-sm font-medium text-gray-700">
                                    <span class="text-indigo-600">Click to upload</span> image
                                </span>
                                <span class="text-xs text-gray-500">PNG, JPG, GIF, SVG, WEBP (max 2MB)</span>
                            </button>

                            <!-- Upload Progress -->
                            <div v-if="form.progress" class="mt-2">
                                <div class="mb-1 flex items-center justify-between text-xs text-gray-600">
                                    <span class="font-medium">Uploading...</span>
                                    <span class="font-semibold text-indigo-600">{{ form.progress.percentage }}%</span>
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200">
                                    <div
                                        class="h-2 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600 transition-all duration-300 ease-out"
                                        :style="{ width: form.progress.percentage + '%' }"
                                    ></div>
                                </div>
                            </div>

                            <p v-if="form.errors.image" class="flex items-center gap-1 text-xs text-red-500">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                {{ form.errors.image }}
                            </p>
                        </div>
                    </div>
                    <AlertDialogFooter>
                        <AlertDialogCancel @click="resetForm">Cancel</AlertDialogCancel>
                        <Button @click="submitCreateForm" :disabled="form.processing">
                            <span v-if="form.processing">Creating...</span>
                            <span v-else>បង្កើត</span>
                        </Button>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>

            <!-- Edit Dialog -->
            <AlertDialog v-model:open="isEditDialogOpen">
                <AlertDialogContent class="max-w-md bg-white">
                    <AlertDialogHeader>
                        <AlertDialogTitle>កែប្រែប្រភេទផលិតផល</AlertDialogTitle>
                    </AlertDialogHeader>
                    <div class="space-y-4 py-4">
                        <!-- Name Field -->
                        <div class="space-y-2">
                            <label for="edit-name" class="text-sm font-medium">ឈ្មោះ *</label>
                            <vee-field name="edit-name" v-model="editForm.name" v-slot="{ field }">
                                <Input v-bind="field" id="edit-name" placeholder="ឈ្មោះប្រភេទ" />
                            </vee-field>
                            <p v-if="editForm.errors.name" class="text-xs text-red-500">{{ editForm.errors.name }}</p>
                        </div>
                        <!-- Image Field -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium">រូបភាព</label>

                            <!-- Single hidden file input shared by both upload and preview -->
                            <input
                                ref="editFileInput"
                                type="file"
                                @change="handleEditImageChange"
                                accept="image/*"
                                class="hidden"
                            />

                            <!-- Image Preview or Upload Button -->
                            <div
                                v-if="editImagePreview"
                                class="relative overflow-hidden rounded-lg border border-gray-300"
                            >
                                <img :src="editImagePreview" alt="Preview" class="h-48 w-full object-cover" />
                                <div class="absolute top-2 right-2 flex gap-2">
                                    <button
                                        type="button"
                                        @click="clearEditImage"
                                        class="rounded-full bg-red-500 p-2 text-white shadow-lg hover:bg-red-600"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                    <button
                                        type="button"
                                        @click="$refs.editFileInput.click()"
                                        class="rounded-full bg-indigo-500 p-2 text-white shadow-lg hover:bg-indigo-600"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <button
                                v-else
                                type="button"
                                @click="$refs.editFileInput.click()"
                                class="flex w-full flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-white px-4 py-8 transition-colors hover:border-indigo-400 hover:bg-indigo-50"
                            >
                                <svg
                                    class="mb-2 h-12 w-12 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                    />
                                </svg>
                                <span class="mb-1 text-sm font-medium text-gray-700">
                                    <span class="text-indigo-600">Click to upload</span> image
                                </span>
                                <span class="text-xs text-gray-500">PNG, JPG, GIF, SVG, WEBP (max 2MB)</span>
                            </button>

                            <!-- Upload Progress -->
                            <div v-if="editForm.progress" class="mt-2">
                                <div class="mb-1 flex items-center justify-between text-xs text-gray-600">
                                    <span class="font-medium">Uploading...</span>
                                    <span class="font-semibold text-indigo-600"
                                        >{{ editForm.progress.percentage }}%</span
                                    >
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200">
                                    <div
                                        class="h-2 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600 transition-all duration-300 ease-out"
                                        :style="{ width: editForm.progress.percentage + '%' }"
                                    ></div>
                                </div>
                            </div>

                            <p v-if="editForm.errors.image" class="flex items-center gap-1 text-xs text-red-500">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                {{ editForm.errors.image }}
                            </p>
                        </div>
                    </div>
                    <AlertDialogFooter>
                        <AlertDialogCancel @click="resetEditForm">Cancel</AlertDialogCancel>
                        <Button @click="submitEditForm" :disabled="editForm.processing">
                            <span v-if="editForm.processing">Updating...</span>
                            <span v-else>Update</span>
                        </Button>
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
            <!-- Custom Cell: Image -->
            <template #cell-image_url="{ value }">
                <div v-if="value" class="h-20 w-20 overflow-hidden rounded-md border">
                    <img :src="value" alt="Category" class="h-full w-full object-cover" />
                </div>
                <div v-else class="bg-muted flex h-20 w-20 items-center justify-center rounded-md">
                    <span class="text-muted-foreground text-xs">No image</span>
                </div>
            </template>

            <!-- Actions Slot -->
            <template #actions="{ item }">
                <div class="flex items-center justify-end gap-2">
                    <button
                        @click="handleEdit(item)"
                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900"
                    >
                        <Pencil class="h-4 w-4" />
                        Edit
                    </button>
                    <button
                        @click="handleDelete(item)"
                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition-colors hover:bg-red-50 hover:text-red-700"
                    >
                        <Trash2 class="h-4 w-4" />
                    </button>
                </div>
            </template>
            <!-- Empty State Slot -->
            <template #empty> </template>
        </DataTable>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
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
import { Plus, FolderOpen, Trash2, Pencil } from 'lucide-vue-next'

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

const form = useForm({
    name: '',
    image: null
})

const editForm = useForm({
    name: '',
    image: null
})

// State
const loading = ref(false)
const searchQuery = ref('')
const isCreateDialogOpen = ref(false)
const isEditDialogOpen = ref(false)
const imagePreview = ref(null)
const editImagePreview = ref(null)
const isDragging = ref(false)
const currentEditItem = ref(null)

// Table columns configuration
const columns = [
    {
        key: 'image_url',
        label: 'រូបភាព',
        cellClass: 'w-50'
    },
    {
        key: 'name',
        label: 'ឈ្មោះ',
        cellClass: 'font-medium'
    }
]

// Handle image file selection
const handleImageChange = (event) => {
    const file = event.target.files[0]
    if (file) {
        processImageFile(file)
    }
}

// Handle drag and drop
const handleDrop = (event) => {
    isDragging.value = false
    const file = event.dataTransfer.files[0]
    if (file && file.type.startsWith('image/')) {
        processImageFile(file)
    }
}

// Process image file (common logic for both click and drag-drop)
const processImageFile = (file) => {
    form.image = file

    // Create preview
    const reader = new FileReader()
    reader.onload = (e) => {
        imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
}

// Clear selected image
const clearImage = () => {
    form.image = null
    imagePreview.value = null
    isDragging.value = false
}

// Reset form
const resetForm = () => {
    form.reset()
    clearImage()
}

// submit create form
const submitCreateForm = () => {
    form.post('/dashboard/categories', {
        preserveScroll: true,
        onSuccess: () => {
            isCreateDialogOpen.value = false
            resetForm()
        }
    })
}

// Handle edit image selection
const handleEditImageChange = (event) => {
    const file = event.target.files[0]
    if (file) {
        processEditImageFile(file)
    }
}

// Process edit image file
const processEditImageFile = (file) => {
    editForm.image = file

    // Create preview
    const reader = new FileReader()
    reader.onload = (e) => {
        editImagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
}

// Clear edit image
const clearEditImage = () => {
    editForm.image = null
    editImagePreview.value = null
}

// Reset edit form
const resetEditForm = () => {
    editForm.reset()
    clearEditImage()
    currentEditItem.value = null
}

// submit edit form
const submitEditForm = () => {
    editForm
        .transform((data) => ({
            ...data,
            _method: 'PUT'
        }))
        .post(`/dashboard/categories/${currentEditItem.value.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                isEditDialogOpen.value = false
                resetEditForm()
            }
        })
}

const handleEdit = (item) => {
    currentEditItem.value = item
    editForm.clearErrors()
    editForm.name = item.name
    editForm.image = null
    editImagePreview.value = item.image_url || null
    isEditDialogOpen.value = true
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
</script>
