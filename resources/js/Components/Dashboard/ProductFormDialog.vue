<template>
    <AlertDialog v-model:open="isOpen">
        <AlertDialogContent class="max-w-2xl bg-white max-h-[90vh] overflow-y-auto">
            <AlertDialogHeader>
                <AlertDialogTitle>{{ title }}</AlertDialogTitle>
            </AlertDialogHeader>

            <div class="space-y-4 py-4">
                <!-- Name Field -->
                <div class="space-y-2">
                    <label :for="`${mode}-name`" class="text-sm font-medium">ឈ្មោះផលិតផល *</label>
                    <Input v-model="localForm.name" :id="`${mode}-name`" placeholder="ឈ្មោះផលិតផល" />
                    <p v-if="localForm.errors.name" class="text-xs text-red-500">{{ localForm.errors.name }}</p>
                </div>

                <!-- Code Field -->
                <div class="space-y-2">
                    <label :for="`${mode}-code`" class="text-sm font-medium">លេខកូដផលិតផល *</label>
                    <Input v-model="localForm.code" :id="`${mode}-code`" placeholder="លេខកូដផលិតផល" />
                    <p v-if="localForm.errors.code" class="text-xs text-red-500">{{ localForm.errors.code }}</p>
                </div>

                <!-- Description Field -->
                <div class="space-y-2">
                    <label :for="`${mode}-description`" class="text-sm font-medium">ការពិពណ៌នា</label>
                    <textarea
                        v-model="localForm.description"
                        :id="`${mode}-description`"
                        placeholder="ការពិពណ៌នាអំពីផលិតផល"
                        class="flex min-h-[80px] w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-950 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    ></textarea>
                    <p v-if="localForm.errors.description" class="text-xs text-red-500">
                        {{ localForm.errors.description }}
                    </p>
                </div>

                <!-- Price and Discount -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label :for="`${mode}-price`" class="text-sm font-medium">តម្លៃ *</label>
                        <Input
                            v-model="localForm.price"
                            :id="`${mode}-price`"
                            type="number"
                            step="0.01"
                            min="0"
                            placeholder="0.00"
                        />
                        <p v-if="localForm.errors.price" class="text-xs text-red-500">{{ localForm.errors.price }}</p>
                    </div>

                    <div class="space-y-2">
                        <label :for="`${mode}-discount`" class="text-sm font-medium">បញ្ចុះតម្លៃ (%)</label>
                        <Input
                            v-model="localForm.discount_price_percent"
                            :id="`${mode}-discount`"
                            type="number"
                            step="0.01"
                            min="0"
                            max="100"
                            placeholder="0"
                        />
                        <p v-if="localForm.errors.discount_price_percent" class="text-xs text-red-500">
                            {{ localForm.errors.discount_price_percent }}
                        </p>
                    </div>
                </div>

                <!-- Stock and Size -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label :for="`${mode}-stock`" class="text-sm font-medium">ចំនួនស្តុក *</label>
                        <Input
                            v-model="localForm.stock"
                            :id="`${mode}-stock`"
                            type="number"
                            min="0"
                            placeholder="0"
                        />
                        <p v-if="localForm.errors.stock" class="text-xs text-red-500">{{ localForm.errors.stock }}</p>
                    </div>

                    <div class="space-y-2">
                        <label :for="`${mode}-size`" class="text-sm font-medium">ទំហំ *</label>
                        <select
                            v-model="localForm.size"
                            :id="`${mode}-size`"
                            class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-white focus:outline-none focus:ring-2 focus:ring-gray-950 focus:ring-offset-2"
                        >
                            <option value="តូច">តូច</option>
                            <option value="មធ្យម">មធ្យម</option>
                            <option value="ធំ">ធំ</option>
                        </select>
                        <p v-if="localForm.errors.size" class="text-xs text-red-500">{{ localForm.errors.size }}</p>
                    </div>
                </div>

                <!-- Images Field -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-700">រូបភាពផលិតផល</label>
                        <span v-if="imagePreviews.length > 0" class="text-xs text-gray-500">
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
                    <p v-if="localForm.errors.images" class="text-xs text-red-500">{{ localForm.errors.images }}</p>
                </div>
            </div>

            <AlertDialogFooter>
                <AlertDialogCancel @click="handleCancel">Cancel</AlertDialogCancel>
                <Button @click="handleSubmit" :disabled="localForm.processing">
                    <span v-if="localForm.processing">{{ processingText }}</span>
                    <span v-else>{{ submitText }}</span>
                </Button>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle
} from '@/components/ui/alert-dialog'
import Button from '@/Components/ui/Button.vue'
import Input from '@/Components/ui/Input.vue'

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

const handleSubmit = () => {
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