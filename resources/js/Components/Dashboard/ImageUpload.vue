<template>
    <div class="space-y-2">
        <label v-if="label" class="text-sm font-medium">{{ label }}</label>

        <!-- Hidden file input -->
        <input
            ref="fileInput"
            type="file"
            @change="handleFileChange"
            accept="image/*"
            class="hidden"
        />

        <!-- Image Preview -->
        <div v-if="previewUrl" class="relative overflow-hidden rounded-lg border border-gray-300">
            <img :src="previewUrl" alt="Preview" class="h-48 w-full object-cover" />
            <div class="absolute top-2 right-2 flex gap-2">
                <!-- Delete Button -->
                <button
                    type="button"
                    @click="handleClear"
                    class="rounded-full bg-red-500 p-2 text-white shadow-lg hover:bg-red-600"
                    title="Delete image"
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
                <!-- Edit Button -->
                <button
                    type="button"
                    @click="openFileDialog"
                    class="rounded-full bg-indigo-500 p-2 text-white shadow-lg hover:bg-indigo-600"
                    title="Change image"
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

        <!-- Upload Button -->
        <button
            v-else
            type="button"
            @click="openFileDialog"
            class="flex w-full flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-white px-4 py-8 transition-colors hover:border-indigo-400 hover:bg-indigo-50"
        >
            <svg class="mb-2 h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <div v-if="progress" class="mt-2">
            <div class="mb-1 flex items-center justify-between text-xs text-gray-600">
                <span class="font-medium">Uploading...</span>
                <span class="font-semibold text-indigo-600">{{ progress.percentage }}%</span>
            </div>
            <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200">
                <div
                    class="h-2 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-600 transition-all duration-300 ease-out"
                    :style="{ width: progress.percentage + '%' }"
                ></div>
            </div>
        </div>

        <!-- Error Message -->
        <p v-if="error" class="flex items-center gap-1 text-xs text-red-500">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path
                    fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd"
                />
            </svg>
            {{ error }}
        </p>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    label: {
        type: String,
        default: ''
    },
    modelValue: {
        type: File,
        default: null
    },
    previewUrl: {
        type: String,
        default: null
    },
    progress: {
        type: Object,
        default: null
    },
    error: {
        type: String,
        default: ''
    }
})

const emit = defineEmits(['update:modelValue', 'change', 'clear'])

const fileInput = ref(null)

const openFileDialog = () => {
    fileInput.value?.click()
}

const handleFileChange = (event) => {
    const file = event.target.files[0]
    if (file) {
        emit('update:modelValue', file)
        emit('change', file)
    }
}

const handleClear = () => {
    if (fileInput.value) {
        fileInput.value.value = ''
    }
    emit('update:modelValue', null)
    emit('clear')
}
</script>
