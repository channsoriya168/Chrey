<template>
    <div class="space-y-4">
        <!-- Name Field -->
        <div class="space-y-2">
            <label
                for="name"
                class="text-sm leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
            >
                Name <span class="text-red-500">*</span>
            </label>
            <input
                id="name"
                type="text"
                :value="name"
                @input="$emit('update:name', $event.target.value)"
                @blur="$emit('blur:name')"
                :disabled="isSubmitting"
                placeholder="Enter category name"
                class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-red-500': errors.name }"
            />
            <p v-if="errors.name" class="text-sm text-red-500">
                {{ errors.name }}
            </p>
        </div>

        <!-- Image Upload Field -->
        <div class="space-y-2">
            <label
                for="image"
                class="text-sm leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
            >
                Category Image
            </label>

            <!-- Image Preview -->
            <div v-if="imagePreview" class="relative h-32 w-32 overflow-hidden rounded-lg border border-gray-300">
                <img :src="imagePreview" alt="Category preview" class="h-full w-full object-cover" />
                <button
                    type="button"
                    @click="$emit('clear-image')"
                    :disabled="isSubmitting"
                    class="absolute top-1 right-1 rounded-full bg-red-500 p-1 text-white transition-colors hover:bg-red-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </div>

            <!-- File Input -->
            <div class="flex items-center gap-2">
                <input
                    id="image"
                    ref="fileInput"
                    type="file"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml"
                    @change="handleFileChange"
                    :disabled="isSubmitting"
                    class="hidden"
                />
                <button
                    type="button"
                    @click="$refs.fileInput.click()"
                    :disabled="isSubmitting"
                    class="ring-offset-background focus-visible:ring-ring border-input bg-background hover:bg-accent hover:text-accent-foreground inline-flex h-10 items-center justify-center rounded-md border px-4 py-2 text-sm font-medium transition-colors focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mr-2 h-4 w-4"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    Choose Image
                </button>
                <span v-if="!imagePreview" class="text-muted-foreground text-sm"> JPG, PNG, GIF, SVG (Max 2MB) </span>
            </div>

            <p v-if="errors.image_url" class="text-sm text-red-500">
                {{ errors.image_url }}
            </p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    name: {
        type: String,
        default: ''
    },
    errors: {
        type: Object,
        default: () => ({})
    },
    meta: {
        type: Object,
        default: () => ({})
    },
    isSubmitting: {
        type: Boolean,
        default: false
    },
    imagePreview: {
        type: String,
        default: null
    }
})

const emit = defineEmits(['update:name', 'update:image', 'blur:name', 'clear-image'])

const handleFileChange = (event) => {
    const file = event.target.files[0]
    if (file) {
        emit('update:image', file)
    }
}
</script>
