<template>
    <transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 transform translate-y-2"
        enter-to-class="opacity-100 transform translate-y-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="show" class="mb-4">
            <!-- Success Message -->
            <Alert v-if="flash.success" variant="success" class="relative">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <AlertDescription>{{ flash.success }}</AlertDescription>
                    </div>
                    <button @click="clearMessage('success')" class="ml-4 flex-shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </Alert>

            <!-- Error Message -->
            <Alert v-if="flash.error || (errors && Object.keys(errors).length > 0)" variant="destructive" class="relative">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <AlertDescription v-if="flash.error">{{ flash.error }}</AlertDescription>
                        <AlertDescription v-else-if="errors && Object.keys(errors).length > 0">
                            <ul class="list-disc list-inside space-y-1">
                                <li v-for="(error, key) in errors" :key="key">
                                    {{ Array.isArray(error) ? error[0] : error }}
                                </li>
                            </ul>
                        </AlertDescription>
                    </div>
                    <button @click="clearMessage('error')" class="ml-4 flex-shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </Alert>

            <!-- Warning Message -->
            <Alert v-if="flash.warning" variant="warning" class="relative">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <AlertDescription>{{ flash.warning }}</AlertDescription>
                    </div>
                    <button @click="clearMessage('warning')" class="ml-4 flex-shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </Alert>

            <!-- Info Message -->
            <Alert v-if="flash.info" variant="default" class="relative">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <AlertDescription>{{ flash.info }}</AlertDescription>
                    </div>
                    <button @click="clearMessage('info')" class="ml-4 flex-shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </Alert>
        </div>
    </transition>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Alert from '@/Components/ui/Alert.vue';
import AlertDescription from '@/Components/ui/AlertDescription.vue';

const props = defineProps({
    autoDismiss: {
        type: Boolean,
        default: true
    },
    dismissTimeout: {
        type: Number,
        default: 5000
    }
});

const page = usePage();
const show = ref(false);
const flash = computed(() => page.props.flash || {});
const errors = computed(() => page.props.errors || {});

let timeoutId = null;

const hasMessages = computed(() => {
    return flash.value.success ||
           flash.value.error ||
           flash.value.warning ||
           flash.value.info ||
           (errors.value && Object.keys(errors.value).length > 0);
});

watch(hasMessages, (newVal) => {
    if (newVal) {
        show.value = true;

        if (props.autoDismiss && !flash.value.error && !errors.value) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                show.value = false;
            }, props.dismissTimeout);
        }
    } else {
        show.value = false;
    }
}, { immediate: true });

const clearMessage = (type) => {
    if (type === 'error') {
        // Clear both flash error and validation errors
        page.props.flash.error = null;
        page.props.errors = {};
    } else {
        page.props.flash[type] = null;
    }

    // Check if any messages remain
    if (!hasMessages.value) {
        show.value = false;
    }
};

onMounted(() => {
    if (hasMessages.value) {
        show.value = true;
    }
});
</script>
