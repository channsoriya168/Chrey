<template>
    <div class="container mx-auto max-w-2xl py-6">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <div class="text-muted-foreground mb-4 flex items-center gap-2 text-sm">
                <Button variant="link" size="sm" class="h-auto p-0" @click="router.visit('/dashboard/categories')">
                    Categories
                </Button>
                <span>/</span>
                <span class="text-foreground">Edit</span>
            </div>
            <div class="flex items-center gap-2">
                <Button variant="ghost" size="sm" @click="router.visit('/dashboard/categories')">
                    <ArrowLeft class="h-4 w-4" />
                </Button>
                <div>
                    <h1 class="text-2xl font-semibold">Edit Category</h1>
                    <p class="text-muted-foreground text-sm">Update the category information below</p>
                </div>
            </div>
        </div>

        <!-- Card Container -->
        <Card>
            <CardHeader>
                <CardTitle>Category Information</CardTitle>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="onSubmit" class="space-y-4">
                    <CategoryForm
                        v-model:name="values.name"
                        :errors="errors"
                        :meta="meta"
                        :is-submitting="isSubmitting"
                        :image-preview="imagePreview"
                        @update:image="handleImageChange"
                        @blur:name="() => setFieldTouched('name', true)"
                        @clear-image="clearImage"
                    />

                    <!-- Form Actions -->
                    <div class="flex flex-col-reverse gap-2 pt-2 sm:flex-row sm:justify-end">
                        <Button
                            type="button"
                            variant="outline"
                            @click="router.visit('/dashboard/categories')"
                            :disabled="isSubmitting"
                            class="w-full sm:w-auto"
                        >
                            Cancel
                        </Button>
                        <Button type="submit" :disabled="isSubmitting" class="w-full sm:w-auto">
                            <span v-if="isSubmitting">Updating...</span>
                            <span v-else>Update Category</span>
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { useForm } from 'vee-validate'
import * as yup from 'yup'
import Card from '@/Components/ui/Card.vue'
import CardHeader from '@/Components/ui/CardHeader.vue'
import CardTitle from '@/Components/ui/CardTitle.vue'
import CardContent from '@/Components/ui/CardContent.vue'
import Button from '@/Components/ui/Button.vue'
import CategoryForm from '@/Components/Dashboard/Forms/CategoryForm.vue'
import { ArrowLeft } from 'lucide-vue-next'

const props = defineProps({
    category: {
        type: Object,
        required: true
    }
})

// Validation schema
const validationSchema = yup.object({
    name: yup.string().required('Name is required').max(255, 'Name must be at most 255 characters'),
    image_url: yup
        .mixed()
        .nullable()
        .test('fileSize', 'Image must be less than 2MB', (value) => {
            if (!value || typeof value === 'string') return true
            return value.size <= 2048 * 1024
        })
        .test('fileType', 'Invalid image format', (value) => {
            if (!value || typeof value === 'string') return true
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml']
            return validTypes.includes(value.type)
        })
})

// Form setup with vee-validate
const { values, errors, meta, setFieldValue, setFieldTouched, handleSubmit, isSubmitting } = useForm({
    validationSchema,
    initialValues: {
        name: props.category.name || '',
        image_url: props.category.image_url || null
    }
})

// Create computed property for v-model binding with defineModel
const nameModel = computed({
    get: () => values.name,
    set: (value) => setFieldValue('name', value)
})

// Image preview
const imagePreview = ref(props.category.image_url ? `/storage/${props.category.image_url}` : null)

// Handle image change
const handleImageChange = (file) => {
    if (file) {
        setFieldValue('image_url', file)
        // Create preview URL
        const reader = new FileReader()
        reader.onload = (e) => {
            imagePreview.value = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

// Clear image
const clearImage = () => {
    setFieldValue('image_url', null)
    imagePreview.value = null
}

// Submit handler
const onSubmit = handleSubmit((values) => {
    const formData = new FormData()
    formData.append('name', values.name)
    formData.append('_method', 'PUT')

    // Only append image if a new file was selected
    if (values.image_url && typeof values.image_url !== 'string') {
        formData.append('image_url', values.image_url)
    }

    router.post(`/dashboard/categories/${props.category.id}`, formData, {
        preserveScroll: true,
        onSuccess: () => {
            router.visit('/dashboard/categories')
        },
        onError: (errors) => {
            console.error('Form submission errors:', errors)
        }
    })
})
</script>
