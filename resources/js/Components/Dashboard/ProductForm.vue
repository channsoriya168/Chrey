<template>
    <form @submit.prevent="handleSubmit" class="space-y-8 border-b-amber-100">
        <!-- Basic Information Section -->
            <div class="grid grid-cols- gap-4">
                <!-- Name Field -->
                <FormField
                    id="name"
                    v-model="form.name"
                    label="ឈ្មោះផលិតផល"
                    placeholder="បញ្ចូលឈ្មោះផលិតផល"
                    :error="form.errors.name"
                    required
                />

                <!-- Code Field -->
                <FormField
                    id="code"
                    v-model="form.code"
                    label="លេខកូដផលិតផល"
                    placeholder="បញ្ចូលលេខកូដផលិតផល"
                    :error="form.errors.code"
                    required
                />

                <!-- Description Field - Full Width -->
                <div class="col-span-2">
                    <FormField
                        id="description"
                        v-model="form.description"
                        type="textarea"
                        label="ការពិពណ៌នា"
                        placeholder="សរសេរការពិពណ៌នាលម្អិតអំពីផលិតផល..."
                        :error="form.errors.description"
                    />
                </div>
                <FormField
                    id="price"
                    v-model="form.price"
                    type="number"
                    label="តម្លៃ ($)"
                    placeholder="0.00"
                    :error="form.errors.price"
                    step="0.01"
                    min="0"
                    required
                />

                <FormField
                    id="discount"
                    v-model="form.discount_price_percent"
                    type="number"
                    label="បញ្ចុះតម្លៃ (%)"
                    placeholder="0"
                    :error="form.errors.discount_price_percent"
                    step="0.01"
                    min="0"
                    max="100"
                />
                 <FormField
                    id="stock"
                    v-model="form.stock"
                    type="number"
                    label="ចំនួនស្តុក"
                    placeholder="0"
                    :error="form.errors.stock"
                    min="0"
                    required
                />

                <FormField
                    id="size"
                    v-model="form.size"
                    type="select"
                    label="ទំហំ"
                    placeholder="ជ្រើសរើសទំហំ"
                    :error="form.errors.size"
                    :options="[
                        { value: 'តូច', label: 'តូច' },
                        { value: 'មធ្យម', label: 'មធ្យម' },
                        { value: 'ធំ', label: 'ធំ' }
                    ]"
                    required
                />
            </div>

        <!-- Images Section -->
        <div class="space-y-3">
            <div>
                <Label class="khmer-text text-sm font-medium text-gray-700">រូបភាព</Label>
                <p class="mt-0.5 text-xs text-gray-500">បន្ថែមរូបភាព (Max 2MB)</p>
            </div>

            <!-- Upload Area / Empty State -->
            <div v-if="imagePreviews.length === 0"
        
                class="grid grid-cols-4 gap-3 md:grid-cols-5 lg:grid-cols-6"
            >

                <div
                    @click="openImageDialog"
                    class="group flex aspect-square cursor-pointer items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 transition-all duration-200 hover:border-gray-400 hover:bg-gray-100"
                >
                    <svg class="h-6 w-6 text-gray-400 transition-colors group-hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>

            <!-- Images Grid Display -->
            <div v-else class="grid grid-cols-4 gap-3 md:grid-cols-5 lg:grid-cols-6">
                <!-- Add More Button -->
                <div
                    @click="openImageDialog"
                    class="group flex aspect-square cursor-pointer items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 transition-all duration-200 hover:border-gray-400 hover:bg-gray-100"
                >
                    <svg class="h-6 w-6 text-gray-400 transition-colors group-hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>

                <!-- Existing Images -->
                <div
                    v-for="(image, index) in imagePreviews"
                    :key="index"
                    class="group relative aspect-square overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition-all duration-200 hover:shadow-md"
                >
                    <!-- Image -->
                    <img :src="image" alt="Product image" class="h-full w-full object-cover" />

                    <!-- Overlay on Hover -->
                    <div class="absolute inset-0 flex items-center justify-center gap-2 bg-black/50 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                        <!-- Replace Button -->
                        <button
                            type="button"
                            @click="replaceImage(index)"
                            class="flex h-8 w-8 items-center justify-center rounded-md bg-white text-amber-600 shadow-md transition-all hover:bg-amber-50"
                            title="Replace"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>

                        <!-- Delete Button -->
                        <button
                            type="button"
                            @click="removeImage(index)"
                            class="flex h-8 w-8 items-center justify-center rounded-md bg-white text-red-600 shadow-md transition-all hover:bg-red-50"
                            title="Delete"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>

                    <!-- Badge Number -->
                    <div class="absolute right-2 top-2 flex h-5 w-5 items-center justify-center rounded-md bg-gray-900 text-xs font-medium text-white shadow-sm">
                        {{ index + 1 }}
                    </div>
                </div>
            </div>

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

            <!-- Error Message -->
            <p v-if="form.errors.images" class="flex items-center gap-1.5 text-xs text-red-600">
                <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ form.errors.images }}</span>
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6">
            <Button 
                type="submit"
                :disabled="form.processing"
                class="relative overflow-hidden rounded-lg bg-gray-900 px-5 py-2.5 font-medium text-white shadow-md transition-all duration-200 hover:bg-gray-800 hover:shadow-lg active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span v-if="form.processing" class="flex items-center justify-center gap-2">
                    <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="khmer-text text-sm">{{ processingText }}</span>
                </span>
                <span v-else class="flex items-center justify-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="khmer-text text-sm">{{ submitText }}</span>
                </span>
            </Button>
            <Button 
                type="button"
                @click="handleCancel"
                variant="outline"
                class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 font-medium text-gray-700 shadow-sm transition-all duration-200 hover:bg-gray-50 hover:shadow-md active:scale-[0.98]"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="khmer-text text-sm">បោះបង់</span>
            </Button>
        </div>
    </form>
</template>

<script setup>
import { ref } from 'vue'
import FormField from '@/Components/ui/FormField.vue'
import { Label } from '@/Components/ui/label'
import { Button } from '@/components/ui/button'

const form = defineModel('form', { required: true })

const props = defineProps({
    submitText: {
        type: String,
        default: 'បង្កើត'
    },
    processingText: {
        type: String,
        default: 'កំពុងដំណើរការ...'
    }
})

const emit = defineEmits(['submit', 'cancel'])

const imagePreviews = defineModel('imagePreviews', { default: () => [] })
const imageInput = ref(null)
const replaceImageInput = ref(null)
const replaceImageIndex = ref(null)
const existingImageUrls = defineModel('existingImageUrls', { default: () => [] })

const openImageDialog = () => {
    imageInput.value?.click()
}

const handleImageChange = (event) => {
    const files = Array.from(event.target.files)

    files.forEach((file) => {
        form.value.images.push(file)

        const reader = new FileReader()
        reader.onload = (e) => {
            imagePreviews.value.push(e.target.result)
        }
        reader.readAsDataURL(file)
    })

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
        const existingImageCount = existingImageUrls.value.length

        if (index < existingImageCount) {
            form.value.existing_images.splice(index, 1)
            existingImageUrls.value.splice(index, 1)
        } else {
            const newImageIndex = index - existingImageCount
            if (newImageIndex < form.value.images.length) {
                form.value.images.splice(newImageIndex, 1)
            }
        }

        form.value.images.push(file)

        const reader = new FileReader()
        reader.onload = (e) => {
            imagePreviews.value[index] = e.target.result
        }
        reader.readAsDataURL(file)

        replaceImageIndex.value = null
        if (replaceImageInput.value) {
            replaceImageInput.value.value = ''
        }
    }
}

const removeImage = (index) => {
    const existingImageCount = existingImageUrls.value.length

    if (index < existingImageCount) {
        form.value.existing_images.splice(index, 1)
        existingImageUrls.value.splice(index, 1)
    } else {
        const newImageIndex = index - existingImageCount
        if (newImageIndex >= 0 && newImageIndex < form.value.images.length) {
            form.value.images.splice(newImageIndex, 1)
        }
    }

    imagePreviews.value.splice(index, 1)
}

const getImageType = (imageUrl) => {
    if (imageUrl.startsWith('data:')) {
        const match = imageUrl.match(/data:image\/([a-zA-Z]+);/)
        return match ? match[1].toUpperCase() : 'Image'
    }
    const extension = imageUrl.split('.').pop().split('?')[0]
    return extension ? extension.toUpperCase() : 'Image'
}

const handleSubmit = () => {
    emit('submit')
}

const handleCancel = () => {
    emit('cancel')
}
</script>
