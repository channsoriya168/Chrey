<template>
    <div class="space-y-8">
        <!-- Basic Information Section -->
        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Code Field -->
                <vee-field name="code" v-slot="{ field, errorMessage }">
                    <FormField id="code" v-model="form.code" label="លេខកូដផលិតផល" placeholder="បញ្ចូលលេខកូដផលិតផល"
                        :error="errorMessage || form.errors.code" required v-bind="field" />
                </vee-field>

                <!-- Name Field -->
                <vee-field name="name" v-slot="{ field, errorMessage }">
                    <FormField id="name" v-model="form.name" label="ឈ្មោះផលិតផល" placeholder="បញ្ចូលឈ្មោះផលិតផល"
                        :error="errorMessage || form.errors.name" required v-bind="field" />
                </vee-field>
            </div>

            <!-- Pricing & Inventory Section -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <vee-field name="price" v-slot="{ field, errorMessage }">
                        <FormField id="price" v-model="form.price" type="number" label="តម្លៃ ($)" placeholder="0.00"
                            :error="errorMessage || form.errors.price" step="0.01" min="0" required v-bind="field" />
                    </vee-field>

                    <div>
                        <vee-field name="discount_price_percent" v-slot="{ field, errorMessage }">
                            <FormField id="discount" v-model="form.discount_price_percent" type="number"
                                label="បញ្ចុះតម្លៃ (%)" placeholder="0"
                                :error="errorMessage || form.errors.discount_price_percent" step="0.01" min="0"
                                max="100" v-bind="field" />
                        </vee-field>
                        <!-- Calculated Discount Price -->
                        <div v-if="calculatedDiscountPrice" class="mt-2 flex items-center gap-2 text-sm">
                            <span class="khmer-text text-gray-600">តម្លៃបន្ទាប់ពីបញ្ចុះ:</span>
                            <span class="font-semibold text-green-600">${{ calculatedDiscountPrice }}</span>
                            <span class="khmer-text text-gray-500">(សន្សំ ${{ discountAmount }})</span>
                        </div>
                    </div>

                    <vee-field name="stock" v-slot="{ field, errorMessage }">
                        <FormField id="stock" v-model="form.stock" type="number" label="ចំនួនស្តុក" placeholder="0"
                            :error="errorMessage || form.errors.stock" min="0" required v-bind="field" />
                    </vee-field>

                    <vee-field name="size" v-slot="{ field, errorMessage }">
                        <FormField id="size" v-model="form.size" type="select" label="ទំហំ" placeholder="ជ្រើសរើសទំហំ"
                            :error="errorMessage || form.errors.size" :options="[
                                {
                                    value: 'តូច',
                                    label: 'តូច',
                                    className: 'bg-blue-50 hover:!bg-blue-100 focus:!bg-blue-100'
                                },
                                {
                                    value: 'មធ្យម',
                                    label: 'មធ្យម',
                                    className: 'bg-green-50 hover:!bg-green-100 focus:!bg-green-100'
                                },
                                {
                                    value: 'ធំ',
                                    label: 'ធំ',
                                    className: 'bg-amber-50 hover:!bg-amber-100 focus:!bg-amber-100'
                                }
                            ]" required v-bind="field" />
                    </vee-field>

                    <!-- Description Field - Full Width -->
                    <div class="md:col-span-2">
                        <vee-field name="description" v-slot="{ field, errorMessage }">
                            <FormField id="description" v-model="form.description" type="textarea" label="ការពិពណ៌នា"
                                placeholder="សរសេរការពិពណ៌នាលម្អិតអំពីផលិតផល..."
                                :error="errorMessage || form.errors.description" v-bind="field" />
                        </vee-field>
                    </div>
                </div>
            </div>
        </div>

        <!-- Images Section -->
        <div class="space-y-6">
            <!-- Upload Area / Empty State -->
            <div v-if="imagePreviews.length === 0" class="grid grid-cols-4 gap-3 md:grid-cols-5 lg:grid-cols-6">
                <div @click="openImageDialog" @dragover.prevent="handleDragOver" @dragleave.prevent="handleDragLeave"
                    @drop.prevent="handleDrop" :class="[
                        'group flex aspect-square cursor-pointer flex-col items-center justify-center gap-2 rounded-lg border-2 border-dashed transition-all duration-200',
                        isDragging
                            ? 'border-blue-500 bg-blue-500/10'
                            : 'border-gray-600 bg-slate-700/30 hover:border-blue-400 hover:bg-slate-700/50'
                    ]" role="button" tabindex="0" aria-label="Upload images" @keydown.enter="openImageDialog"
                    @keydown.space.prevent="openImageDialog">
                    <svg class="h-6 w-6 text-gray-400 transition-colors group-hover:text-blue-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="khmer-text text-xs text-gray-400 group-hover:text-gray-300">រូបភាព</span>
                </div>
            </div>

            <!-- Images Grid Display -->
            <div v-else class="grid grid-cols-4 gap-3 md:grid-cols-5 lg:grid-cols-6">
                <!-- Add More Button -->
                <div @click="openImageDialog" @dragover.prevent="handleDragOver" @dragleave.prevent="handleDragLeave"
                    @drop.prevent="handleDrop" :class="[
                        'group flex aspect-square cursor-pointer flex-col items-center justify-center gap-1 rounded-lg border-2 border-dashed transition-all duration-200',
                        isDragging
                            ? 'border-blue-500 bg-blue-500/10'
                            : 'border-gray-600 bg-slate-700/30 hover:border-blue-400 hover:bg-slate-700/50'
                    ]" role="button" tabindex="0" aria-label="Add more images" @keydown.enter="openImageDialog"
                    @keydown.space.prevent="openImageDialog">
                    <svg class="h-6 w-6 text-gray-400 transition-colors group-hover:text-blue-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="khmer-text text-xs text-gray-400 group-hover:text-gray-300">បន្ថែម</span>
                </div>

                <!-- Existing Images -->
                <div v-for="(image, index) in imagePreviews" :key="index"
                    class="group relative aspect-square overflow-hidden rounded-lg border border-gray-600 bg-slate-700 shadow-sm transition-all duration-200 hover:shadow-md hover:shadow-blue-500/20"
                    :class="{ 'ring-2 ring-blue-500': index === 0 }">
                    <!-- Image -->
                    <img :src="image" :alt="`Product image ${index + 1}`" class="h-full w-full object-cover"
                        loading="lazy" />

                    <!-- Primary Badge -->
                    <div v-if="index === 0"
                        class="absolute top-2 left-2 rounded-md bg-blue-600 px-2 py-0.5 text-xs font-medium text-white shadow-sm">
                        ដំបូង
                    </div>

                    <!-- Overlay on Hover -->
                    <div
                        class="absolute inset-0 flex items-center justify-center gap-2 bg-black/50 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                        <!-- Replace Button -->
                        <button type="button" @click="replaceImage(index)"
                            class="flex h-8 w-8 items-center justify-center rounded-md bg-white text-amber-600 shadow-md transition-all hover:bg-amber-50"
                            title="Replace">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>

                        <!-- Delete Button -->
                        <button type="button" @click="removeImage(index)"
                            class="flex h-8 w-8 items-center justify-center rounded-md bg-white text-red-600 shadow-md transition-all hover:bg-red-50"
                            title="Delete">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>

                    <!-- Badge Number -->
                    <div v-if="index !== 0"
                        class="absolute top-2 right-2 flex h-5 w-5 items-center justify-center rounded-md bg-gray-900 text-xs font-medium text-white shadow-sm">
                        {{ index + 1 }}
                    </div>

                    <!-- Image Size Info -->
                    <div v-if="imageSizes[index]"
                        class="absolute bottom-2 left-2 rounded-md bg-black/70 px-2 py-0.5 text-xs text-white">
                        {{ imageSizes[index] }}
                    </div>
                </div>
            </div>

            <!-- Image Upload Info -->
            <div class="flex items-start gap-2 rounded-lg bg-blue-500/10 border border-blue-500/20 p-3 text-sm">
                <svg class="h-5 w-5 flex-shrink-0 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                <div class="khmer-text text-blue-100">
                    <p class="font-medium">ព័ត៌មានអំពីរូបភាព:</p>
                    <ul class="mt-1 list-inside list-disc space-y-0.5 text-blue-200">
                        <li>ទំហំអតិបរមា: 2MB ក្នុងមួយរូប</li>
                        <li>ប្រភេទ: JPG, PNG, GIF, WebP</li>
                        <li>អាចអូសទម្លាក់ឬចុចដើម្បីជ្រើសរើស</li>
                        <li>រូបភាពដំបូងនឹងត្រូវបង្ហាញជាមេ</li>
                    </ul>
                </div>
            </div>

            <!-- Hidden Inputs -->
            <input ref="imageInput" type="file" @change="handleImageChange" accept="image/*" multiple class="hidden" />
            <input ref="replaceImageInput" type="file" @change="handleReplaceImageChange" accept="image/*"
                class="hidden" />

            <!-- Error Message -->
            <p v-if="form.errors.images" class="flex items-center gap-1.5 text-xs text-red-600">
                <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ form.errors.images }}</span>
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between gap-4 border-t border-slate-700/50 pt-6">
            <p class="khmer-text text-sm text-slate-400">សូមត្រួតពិនិត្យមុនពេលរក្សាទុក</p>
            <div class="flex gap-3">
                <Button type="button" @click="handleCancel" variant="outline"
                    class="khmer-text flex items-center gap-2 rounded-lg border-2 border-gray-600 bg-transparent px-6 py-2.5 font-medium text-slate-200 shadow-sm transition-all duration-200 hover:border-blue-400 hover:bg-blue-500/10 active:scale-[0.98]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>បោះបង់</span>
                </Button>
                <Button type="submit" :disabled="form.processing"
                    class="khmer-text relative overflow-hidden rounded-lg bg-purple-600/80 px-8 py-2.5 font-semibold text-white shadow-lg shadow-purple-500/20 transition-all duration-200 hover:bg-purple-500 hover:shadow-xl hover:shadow-purple-500/30 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-60">
                    <span v-if="form.processing" class="flex items-center gap-2">
                        <svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>{{ processingText }}</span>
                    </span>
                    <span v-else class="flex items-center gap-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ submitText }}</span>
                    </span>
                </Button>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, computed } from 'vue'
    import { ErrorMessage } from 'vee-validate'
    import FormField from '@/Components/ui/FormField.vue'
    import { Label } from '@/Components/ui/label'
    import { Button } from '@/Components/ui/button'

    const form = defineModel('form', { required: true })

    const props = defineProps({
        submitText: {
            type: String,
            default: 'បង្កើត'
        },
        processingText: {
            type: String,
            default: 'កំពុងដំណើរការ...'
        },
        veeErrors: {
            type: Object,
            default: () => ({})
        }
    })

    const emit = defineEmits(['cancel'])

    const imagePreviews = defineModel('imagePreviews', { default: () => [] })
    const imageInput = ref(null)
    const replaceImageInput = ref(null)
    const replaceImageIndex = ref(null)
    const existingImageUrls = defineModel('existingImageUrls', { default: () => [] })
    const isDragging = ref(false)
    const imageSizes = ref([])

    // Computed properties for price calculations
    const calculatedDiscountPrice = computed(() => {
        const price = parseFloat(form.value.price)
        const discount = parseFloat(form.value.discount_price_percent)

        if (isNaN(price) || isNaN(discount) || discount <= 0) {
            return null
        }

        const discountedPrice = price - (price * discount) / 100
        return discountedPrice.toFixed(2)
    })

    const discountAmount = computed(() => {
        const price = parseFloat(form.value.price)
        const discount = parseFloat(form.value.discount_price_percent)

        if (isNaN(price) || isNaN(discount) || discount <= 0) {
            return '0.00'
        }

        const amount = (price * discount) / 100
        return amount.toFixed(2)
    })

    const openImageDialog = () => {
        imageInput.value?.click()
    }

    // Drag and drop handlers
    const handleDragOver = (event) => {
        isDragging.value = true
    }

    const handleDragLeave = (event) => {
        isDragging.value = false
    }

    const handleDrop = (event) => {
        isDragging.value = false
        const files = Array.from(event.dataTransfer.files).filter((file) => file.type.startsWith('image/'))

        if (files.length > 0) {
            processImageFiles(files)
        }
    }

    // Validate and format file size
    const formatFileSize = (bytes) => {
        if (bytes < 1024) return bytes + ' B'
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB'
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB'
    }

    const validateImageSize = (file) => {
        const maxSize = 2 * 1024 * 1024 // 2MB
        return file.size <= maxSize
    }

    // Process image files with validation
    const processImageFiles = (files) => {
        const validFiles = []
        const invalidFiles = []

        files.forEach((file) => {
            if (validateImageSize(file)) {
                validFiles.push(file)
            } else {
                invalidFiles.push(file.name)
            }
        })

        // Show error for invalid files
        if (invalidFiles.length > 0) {
            form.value.errors.images = `រូបភាពខាងក្រោមមានទំហំលើសពី 2MB: ${invalidFiles.join(', ')}`
            setTimeout(() => {
                form.value.errors.images = null
            }, 5000)
        }

        // Process valid files
        validFiles.forEach((file) => {
            form.value.images.push(file)
            imageSizes.value.push(formatFileSize(file.size))

            const reader = new FileReader()
            reader.onload = (e) => {
                imagePreviews.value.push(e.target.result)
            }
            reader.readAsDataURL(file)
        })
    }

    const handleImageChange = (event) => {
        const files = Array.from(event.target.files)
        processImageFiles(files)

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
            // Validate file size
            if (!validateImageSize(file)) {
                form.value.errors.images = `រូបភាព ${file.name} មានទំហំលើសពី 2MB`
                setTimeout(() => {
                    form.value.errors.images = null
                }, 5000)
                replaceImageIndex.value = null
                if (replaceImageInput.value) {
                    replaceImageInput.value.value = ''
                }
                return
            }

            const index = replaceImageIndex.value
            const existingImageCount = existingImageUrls.value.length

            if (index < existingImageCount) {
                form.value.existing_images.splice(index, 1)
                existingImageUrls.value.splice(index, 1)
            } else {
                const newImageIndex = index - existingImageCount
                if (newImageIndex < form.value.images.length) {
                    form.value.images.splice(newImageIndex, 1)
                    imageSizes.value.splice(newImageIndex, 1)
                }
            }

            form.value.images.push(file)
            imageSizes.value[index] = formatFileSize(file.size)

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
                imageSizes.value.splice(newImageIndex, 1)
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

    const handleCancel = () => {
        emit('cancel')
    }
</script>
