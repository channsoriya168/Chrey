<template>
    <v-container>
        <v-row>
            <v-col :cols="12">
                <vee-field v-slot="{ field, errors }" name="code">
                    <v-text-field variant="outlined" label="លេខកូដផលិតផល" v-bind="field" :error-messages="errors"
                        v-model="item.code" required></v-text-field>
                </vee-field>
                <vee-field v-slot="{ field, errors }" name="name">
                    <v-text-field variant="outlined" label="ឈ្មោះផលិតផល" v-bind="field" :error-messages="errors"
                        v-model="item.name" required></v-text-field>
                </vee-field>

            </v-col>

            <v-col :cols="12" :md="6">
                <vee-field v-slot="{ field, errors }" name="quantity">
                    <v-text-field variant="outlined" label="ចំនួន" type="number" v-bind="field" :error-messages="errors"
                        v-model="item.quantity" required></v-text-field>
                </vee-field>
            </v-col>
            <v-col :cols="12" :md="6">
                <vee-field v-slot="{ field, errors }" name="price">
                    <v-text-field variant="outlined" label="តម្លៃ" type="number" v-bind="field" :error-messages="errors"
                        v-model="item.price" required></v-text-field>
                </vee-field>
            </v-col>
            <v-col :cols="12">
                <vee-field v-slot="{ field, errors }" name="description">
                    <v-textarea variant="outlined" label="ការពិពណ៌នា" v-bind="field" :error-messages="errors"
                        v-model="item.description" required></v-textarea>
                </vee-field>
            </v-col>
            <v-col :cols="12">
                <vee-field v-slot="{ field, errors }" name="images">
                    <v-label class="mb-2">រូបភាពផលិតផល</v-label>
                    <div v-if="errors.length > 0" class="text-error text-caption mb-2">
                        {{ errors[0] }}
                    </div>
                    
                    <!-- Hidden file input -->
                    <input
                        type="file"
                        ref="fileInput"
                        multiple
                        accept="image/*"
                        @change="handleImageChange"
                        style="display: none;"
                    />
                    
                    <!-- Image Preview Grid -->
                    <v-row>
                        <!-- Existing Images -->
                        <v-col v-for="(image, index) in imagePreview" :key="index" :cols="12" :sm="6" :md="4" :lg="3">
                            <v-card class="position-relative" elevation="2">
                                <v-img 
                                    :src="image.url" 
                                    :alt="image.name"
                                    height="150" 
                                    width="100%"
                                    cover
                                    :aspect-ratio="1"
                                    class="rounded"
                                >
                                    <template v-slot:placeholder>
                                        <div class="d-flex align-center justify-center fill-height">
                                            <v-progress-circular
                                                color="grey-lighten-4"
                                                indeterminate
                                            ></v-progress-circular>
                                        </div>
                                    </template>
                                </v-img>
                                <v-btn
                                    icon="mdi-close"
                                    size="small"
                                    color="error"
                                    class="position-absolute"
                                    style="top: 5px; right: 5px;"
                                    @click="removeImage(index)"
                                ></v-btn>
                            </v-card>
                        </v-col>
                        
                        <!-- Add Image Button -->
                        <v-col v-if="imagePreview.length < 5" :cols="12" :sm="6" :md="4" :lg="3">
                            <v-card 
                                class="d-flex align-center justify-center cursor-pointer"
                                height="150"
                                elevation="2"
                                variant="outlined"
                                @click="triggerFileInput"
                            >
                                <div class="text-center">
                                    <v-icon size="48" color="grey-lighten-1">mdi-plus</v-icon>
                                    <div class="text-grey-lighten-1 mt-2">បន្ថែមរូបភាព</div>
                                </div>
                            </v-card>
                        </v-col>
                    </v-row>
                </vee-field>
            </v-col>
        </v-row>


    </v-container>
</template>

<script setup>
import { ref, watch } from 'vue';

const item = defineModel();
const imagePreview = ref([]);
const fileInput = ref(null);

const triggerFileInput = () => {
    fileInput.value.click();
};

const handleImageChange = (event) => {
    const files = event.target.files;
    if (!files || files.length === 0) return;

    // Convert FileList to Array
    const fileArray = Array.from(files);
    
    // Add new files to existing images (don't clear previous ones)
    const existingFiles = imagePreview.value.map(img => img.file);
    const allFiles = [...existingFiles, ...fileArray];
    
    // Limit to 5 images maximum
    const limitedFiles = allFiles.slice(0, 5);
    
    // Clear current previews and rebuild with all files
    imagePreview.value = [];
    
    limitedFiles.forEach((file) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.value.push({
                    file: file,
                    url: e.target.result,
                    name: file.name
                });
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Update the form model with all files
    item.value.images = limitedFiles;
    
    // Clear the file input to allow re-selecting same files
    if (event.target) {
        event.target.value = '';
    }
};

const removeImage = (index) => {
    imagePreview.value.splice(index, 1);
    
    // Update the form model
    const updatedFiles = imagePreview.value.map(img => img.file);
    item.value.images = updatedFiles;
    
    // Update the file input
    if (fileInput.value) {
        const dt = new DataTransfer();
        updatedFiles.forEach(file => dt.items.add(file));
        fileInput.value.$refs.input.files = dt.files;
    }
};

// Watch for external changes to images
watch(() => item.value?.images, (newImages) => {
    if (!newImages || newImages.length === 0) {
        imagePreview.value = [];
    }
}, { deep: true });
</script>