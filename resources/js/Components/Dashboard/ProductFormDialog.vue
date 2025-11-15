<template>
    <AlertDialog v-model:open="isOpen">
        <AlertDialogContent class="max-w-2xl bg-white/95 backdrop-blur-xl max-h-[90vh] rounded-2xl border border-white/20 shadow-2xl flex flex-col overflow-hidden">
            <AlertDialogHeader class="px-3 pt-1 pb-1 bg-white/95 backdrop-blur-xl border-b border-gray-100 flex-shrink-0">
                <AlertDialogTitle class="text-2xl font-bold text-black pr-10">{{ title }}</AlertDialogTitle>
                <button
                    @click="handleCancel"
                    class="absolute right-6 top-1 p-1 rounded-full bg-white hover:bg-red-50 border border-gray-200 hover:border-red-200 shadow-md hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 group"
                    type="button"
                >
                    <svg class="h-5 w-5 text-gray-600 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </AlertDialogHeader>

            <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
                <!-- Name Field -->
                <FormField
                    :id="`${mode}-name`"
                    v-model="localForm.name"
                    label="ឈ្មោះផលិតផល"
                    placeholder="ឈ្មោះផលិតផល"
                    :error="localForm.errors.name"
                    required
                />

                <!-- Code Field -->
                <FormField
                    :id="`${mode}-code`"
                    v-model="localForm.code"
                    label="លេខកូដផលិតផល"
                    placeholder="លេខកូដផលិតផល"
                    :error="localForm.errors.code"
                    required
                />

                <!-- Description Field -->
                <FormField
                    :id="`${mode}-description`"
                    v-model="localForm.description"
                    type="textarea"
                    label="ការពិពណ៌នា"
                    placeholder="ការពិពណ៌នាអំពីផលិតផល"
                    :error="localForm.errors.description"
                />

                <!-- Price and Discount -->
                <div class="grid grid-cols-2 gap-4">
                    <FormField
                        :id="`${mode}-price`"
                        v-model="localForm.price"
                        type="number"
                        label="តម្លៃ"
                        placeholder="0.00"
                        :error="localForm.errors.price"
                        step="0.01"
                        min="0"
                        required
                    />

                    <FormField
                        :id="`${mode}-discount`"
                        v-model="localForm.discount_price_percent"
                        type="number"
                        label="បញ្ចុះតម្លៃ (%)"
                        placeholder="0"
                        :error="localForm.errors.discount_price_percent"
                        step="0.01"
                        min="0"
                        max="100"
                    />
                </div>

                <!-- Stock and Size -->
                <div class="grid grid-cols-2 gap-4">
                    <FormField
                        :id="`${mode}-stock`"
                        v-model="localForm.stock"
                        type="number"
                        label="ចំនួនស្តុក"
                        placeholder="0"
                        :error="localForm.errors.stock"
                        min="0"
                        required
                    />

                    <FormField
                        :id="`${mode}-size`"
                        v-model="localForm.size"
                        type="select"
                        label="ទំហំ"
                        placeholder="Select size"
                        :error="localForm.errors.size"
                        :options="[
                            { value: 'តូច', label: 'តូច' },
                            { value: 'មធ្យម', label: 'មធ្យម' },
                            { value: 'ធំ', label: 'ធំ' }
                        ]"
                        required
                    />
                </div>

                <!-- Images Field -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <Label class="text-xs font-bold text-gray-800 tracking-wide flex items-center gap-1.5">
                            <div class="w-1 h-3 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                            រូបភាពផលិតផល
                        </Label>
                        <span v-if="imagePreviews.length > 0" class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">
                            {{ imagePreviews.length }} {{ imagePreviews.length > 1 ? 'images' : 'image' }}
                        </span>
                    </div>

                    <!-- Upload Container -->
                    <div class="relative overflow-hidden rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                        <!-- Multiple Image Upload Grid -->
                        <div v-if="imagePreviews.length > 0" class="mb-3 grid grid-cols-4 gap-2">
                            <div
                                v-for="(image, index) in imagePreviews"
                                :key="index"
                                class="group relative aspect-square overflow-hidden rounded-lg bg-gray-100 ring-1 ring-gray-200 transition-all hover:ring-2 hover:ring-indigo-500"
                            >
                                <img :src="image" alt="Product image" class="h-full w-full object-cover" />

                                <!-- Hover Overlay -->
                                <div
                                    class="absolute inset-0 flex items-center justify-center gap-1.5 bg-gradient-to-t from-black/70 via-black/40 to-transparent opacity-0 transition-all duration-200 group-hover:opacity-100"
                                >
                                    <button
                                        type="button"
                                        @click="replaceImage(index)"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/95 text-gray-700 shadow-lg backdrop-blur-sm transition-all hover:bg-white hover:scale-105"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                    </button>
                                    <button
                                        type="button"
                                        @click="removeImage(index)"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/95 text-red-500 shadow-lg backdrop-blur-sm transition-all hover:bg-white hover:scale-105"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Badge -->
                                <div
                                    class="absolute right-1.5 top-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-white/90 text-[10px] font-bold text-gray-700 shadow-sm backdrop-blur-sm"
                                >
                                    {{ index + 1 }}
                                </div>
                            </div>
                        </div>

                        <!-- Upload Area -->
                        <button
                            type="button"
                            @click="openImageDialog"
                            class="group relative flex w-full items-center gap-3 rounded-lg border border-dashed border-gray-300 bg-gray-50/50 px-4 py-3 transition-all hover:border-indigo-400 hover:bg-indigo-50/50"
                        >
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-white shadow-sm ring-1 ring-gray-200 transition-all group-hover:bg-indigo-50 group-hover:ring-indigo-300">
                                <svg
                                    class="h-5 w-5 text-gray-600 transition-colors group-hover:text-indigo-600"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <p class="text-sm font-medium text-gray-700">
                                    បន្ថែមរូបភាព
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG, WEBP</p>
                            </div>
                        </button>

                        <!-- Hidden Inputs -->
                        <input
                            ref="imageInput"
                            type="file"
                            @change="handleImageChange"
                            accept="image/*"
                            multiple
                            class="hidden"
                        />
                        <input
                            ref="replaceImageInput"
                            type="file"
                            @change="handleReplaceImageChange"
                            accept="image/*"
                            class="hidden"
                        />
                    </div>
                    <p v-if="localForm.errors.images" class="text-xs text-red-600 flex items-center gap-1.5 ml-1 animate-shake">
                        <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ localForm.errors.images }}</span>
                    </p>
                </div>
            </div>

                        <AlertDialogFooter class="px-6 pb-6 pt-4 border-t border-gray-100 bg-white/95 backdrop-blur-xl flex-shrink-0 flex items-center justify-end gap-3">
                <Button 
                    type="button"
                    @click="handleCancel"
                    variant="outline"
                    class="h-11 px-8 rounded-lg border-2 border-gray-300 hover:border-gray-400 hover:bg-gray-50 transition-all duration-300 font-semibold shadow-sm hover:shadow-md"
                >
                    Cancel
                </Button>
                <Button 
                    type="button"
                    @click="handleSubmit" 
                    :disabled="localForm.processing"
                    class="h-11 px-8 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-bold rounded-lg transition-all duration-300 transform shadow-lg hover:shadow-xl shadow-indigo-300/50 disabled:opacity-60 disabled:cursor-not-allowed hover:scale-[1.02] active:scale-[0.98] relative overflow-hidden"
                >
                    <span v-if="localForm.processing" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ processingText }}
                    </span>
                    <span v-else>{{ submitText }}</span>
                </Button>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import * as yup from 'yup'
import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle
} from '@/components/ui/alert-dialog'
import { Button } from '@/components/ui/button'
import FormField from '@/Components/ui/FormField.vue'

// Validation schema
const validationSchema = yup.object().shape({
    name: yup.string().required('ឈ្មោះផលិតផលត្រូវបានទាមទារ').min(2, 'ឈ្មោះផលិតផលត្រូវមានយ៉ាងហោចណាស់ 2 តួអក្សរ'),
    code: yup.string().required('លេខកូដផលិតផលត្រូវបានទាមទារ'),
    price: yup.number()
        .required('តម្លៃត្រូវបានទាមទារ')
        .positive('តម្លៃត្រូវតែជាលេខវិជ្ជមាន')
        .typeError('តម្លៃត្រូវតែជាលេខ'),
    stock: yup.number()
        .required('ចំនួនស្តុកត្រូវបានទាមទារ')
        .integer('ចំនួនស្តុកត្រូវតែជាលេខគត់')
        .min(0, 'ចំនួនស្តុកមិនអាចតិចជាង 0')
        .typeError('ចំនួនស្តុកត្រូវតែជាលេខ'),
    size: yup.string().required('ទំហំត្រូវបានទាមទារ'),
    discount_price_percent: yup.number()
        .min(0, 'បញ្ចុះតម្លៃមិនអាចតិចជាង 0%')
        .max(100, 'បញ្ចុះតម្លៃមិនអាចលើសពី 100%')
        .nullable()
        .transform((value, originalValue) => originalValue === '' ? null : value)
        .typeError('បញ្ចុះតម្លៃត្រូវតែជាលេខ')
})

const props = defineProps({
    modelValue: {
        type: Boolean,
        required: true
    },
    mode: {
        type: String,
        default: 'create',
        validator: (value) => ['create', 'edit'].includes(value)
    },
    initialData: {
        type: Object,
        default: () => ({
            name: '',
            code: '',
            description: '',
            price: '',
            discount_price_percent: '',
            stock: '',
            size: 'មធ្យម',
            image_url: null
        })
    },
    title: {
        type: String,
        default: ''
    },
    submitText: {
        type: String,
        default: 'Submit'
    },
    processingText: {
        type: String,
        default: 'Processing...'
    }
})

const emit = defineEmits(['update:modelValue', 'submit', 'cancel'])

const isOpen = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

const localForm = useForm({
    name: '',
    code: '',
    description: '',
    price: '',
    discount_price_percent: '',
    stock: '',
    size: 'មធ្យម',
    images: [],
    existing_images: []
})

const imagePreviews = ref([])
const imageInput = ref(null)
const replaceImageInput = ref(null)
const replaceImageIndex = ref(null)
const existingImageUrls = ref([]) // Track which previews are existing vs new

// Initialize form data when dialog opens or initialData changes
watch(
    [() => props.modelValue, () => props.initialData],
    ([isOpen, data]) => {
        if (isOpen) {
            localForm.clearErrors()
            localForm.name = data?.name || ''
            localForm.code = data?.code || ''
            localForm.description = data?.description || ''
            localForm.price = data?.price || ''
            localForm.discount_price_percent = data?.discount_price_percent || ''
            localForm.stock = data?.stock || ''
            localForm.size = data?.size || 'មធ្យម'
            localForm.images = []
            localForm.existing_images = []

            // Set existing images for preview
            if (data?.image_url && Array.isArray(data.image_url)) {
                imagePreviews.value = data.image_url.map(url => `/storage/${url}`)
                existingImageUrls.value = data.image_url.slice() // Copy of existing URLs
                localForm.existing_images = data.image_url.slice()
            } else {
                imagePreviews.value = []
                existingImageUrls.value = []
            }
        }
    },
    { immediate: true }
)

const openImageDialog = () => {
    imageInput.value?.click()
}

const handleImageChange = (event) => {
    const files = Array.from(event.target.files)

    files.forEach((file) => {
        localForm.images.push(file)

        // Create preview
        const reader = new FileReader()
        reader.onload = (e) => {
            imagePreviews.value.push(e.target.result)
        }
        reader.readAsDataURL(file)
    })

    // Reset input
    if (imageInput.value) {
        imageInput.value.value = ''
    }
}

const replaceImage = (index) => {
    replaceImageIndex.value = index
    replaceImageInput.value?.click()
}

const handleReplaceImageChange = (event) => {
    const file = event.target.files[0]
    if (file && replaceImageIndex.value !== null) {
        const index = replaceImageIndex.value

        // Check if this is an existing image or a new one
        const existingImageCount = existingImageUrls.value.length

        if (index < existingImageCount) {
            // Replacing an existing image - remove from existing_images
            localForm.existing_images.splice(index, 1)
            existingImageUrls.value.splice(index, 1)
        } else {
            // Replacing a newly added image
            const newImageIndex = index - existingImageCount
            if (newImageIndex < localForm.images.length) {
                localForm.images.splice(newImageIndex, 1)
            }
        }

        // Add the new file
        localForm.images.push(file)

        // Create new preview
        const reader = new FileReader()
        reader.onload = (e) => {
            imagePreviews.value[index] = e.target.result
        }
        reader.readAsDataURL(file)

        // Reset
        replaceImageIndex.value = null
        if (replaceImageInput.value) {
            replaceImageInput.value.value = ''
        }
    }
}

const removeImage = (index) => {
    // Check if this is an existing image or a new one
    const existingImageCount = existingImageUrls.value.length

    if (index < existingImageCount) {
        // Removing an existing image
        localForm.existing_images.splice(index, 1)
        existingImageUrls.value.splice(index, 1)
    } else {
        // Removing a newly added image
        const newImageIndex = index - existingImageCount
        if (newImageIndex >= 0 && newImageIndex < localForm.images.length) {
            localForm.images.splice(newImageIndex, 1)
        }
    }

    // Remove from preview
    imagePreviews.value.splice(index, 1)
}

const handleSubmit = async () => {
    // Clear previous errors
    localForm.clearErrors()
    
    // Prepare data for validation
    const dataToValidate = {
        name: localForm.name,
        code: localForm.code,
        price: localForm.price,
        stock: localForm.stock,
        size: localForm.size,
        discount_price_percent: localForm.discount_price_percent
    }
    
    try {
        // Validate with yup
        await validationSchema.validate(dataToValidate, { abortEarly: false })
        
        // If validation passes, emit submit
        emit('submit', {
            form: localForm,
            resetForm: () => {
                localForm.reset()
                imagePreviews.value = []
                existingImageUrls.value = []
                replaceImageIndex.value = null
                if (imageInput.value) {
                    imageInput.value.value = ''
                }
                if (replaceImageInput.value) {
                    replaceImageInput.value.value = ''
                }
            }
        })
    } catch (error) {
        // Handle validation errors
        if (error.inner) {
            error.inner.forEach(err => {
                localForm.setError(err.path, err.message)
            })
        }
    }
}

const handleCancel = () => {
    localForm.reset()
    imagePreviews.value = []
    existingImageUrls.value = []
    replaceImageIndex.value = null
    if (imageInput.value) {
        imageInput.value.value = ''
    }
    if (replaceImageInput.value) {
        replaceImageInput.value.value = ''
    }
    emit('cancel')
    isOpen.value = false
}
</script>