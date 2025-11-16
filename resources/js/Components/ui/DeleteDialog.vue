<template>
    <AlertDialog :open="open" @update:open="$emit('update:open', $event)">
        <AlertDialogContent class="bg-white">
            <AlertDialogHeader>
                <AlertDialogTitle class="text-gray-900">{{ title }}</AlertDialogTitle>
                <AlertDialogDescription class="text-gray-600">
                    {{ description }}
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel @click="handleCancel" :disabled="loading">
                    {{ cancelText }}
                </AlertDialogCancel>
                <AlertDialogAction
                    @click="handleConfirm"
                    :disabled="loading"
                    class="bg-red-600 hover:bg-red-700 focus:ring-red-600"
                >
                    <span v-if="loading" class="flex items-center">
                        <svg
                            class="mr-2 h-4 w-4 animate-spin"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        {{ loadingText }}
                    </span>
                    <span v-else>{{ confirmText }}</span>
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

<script setup>
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle
} from '@/components/ui/alert-dialog'

defineProps({
    open: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: 'តើអ្នកប្រាកដទេ?'
    },
    description: {
        type: String,
        default: 'សកម្មភាពនេះមិនអាចត្រឡប់វិញបានទេ។ វានឹងលុបទិន្នន័យនេះជាអចិន្ត្រៃយ៍។'
    },
    confirmText: {
        type: String,
        default: 'លុប'
    },
    cancelText: {
        type: String,
        default: 'បោះបង់'
    },
    loadingText: {
        type: String,
        default: 'កំពុងលុប...'
    },
    loading: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:open', 'confirm', 'cancel'])

const handleConfirm = () => {
    emit('confirm')
}

const handleCancel = () => {
    emit('cancel')
    emit('update:open', false)
}
</script>
