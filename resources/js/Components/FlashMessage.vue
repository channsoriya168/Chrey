<template>
    <!-- Fixed position container for toast notifications -->
    <Teleport to="body">
        <div
            class="pointer-events-none fixed top-4 right-4 z-50 flex w-full max-w-md flex-col gap-3"
            aria-live="polite"
            aria-atomic="true"
        >
            <!-- Success Message -->
            <TransitionGroup
                enter-active-class="transform transition duration-300 ease-out"
                enter-from-class="translate-x-full opacity-0"
                enter-to-class="translate-x-0 opacity-100"
                leave-active-class="transform transition duration-200 ease-in"
                leave-from-class="translate-x-0 opacity-100"
                leave-to-class="translate-x-full opacity-0"
            >
                <Alert
                    v-if="show && flash.success"
                    key="success"
                    variant="success"
                    class="pointer-events-auto border-l-4 border-l-green-700 shadow-lg"
                >
                    <div class="flex items-start gap-3">
                        <div
                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-white/20 dark:bg-white/10"
                        >
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="mb-1 text-sm font-semibold text-white">Success!</h4>
                            <AlertDescription class="text-sm text-white/90">
                                {{ flash.success }}
                            </AlertDescription>
                        </div>
                        <button
                            @click="clearMessage('success')"
                            class="flex-shrink-0 rounded-md p-1.5 transition-colors hover:bg-white/20 dark:hover:bg-white/10"
                            aria-label="Dismiss"
                        >
                            <svg class="text-green h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </div>
                    <div
                        v-if="props.autoDismiss && !flash.error"
                        class="absolute bottom-0 left-0 h-1 rounded-b bg-green-700"
                        :style="{ width: progressWidth + '%' }"
                    ></div>
                </Alert>

                <!-- Error Message -->
                <Alert
                    v-if="show && (flash.error || (errors && Object.keys(errors).length > 0))"
                    key="error"
                    variant="destructive"
                    class="pointer-events-auto border-l-4 border-l-red-700 shadow-lg"
                >
                    <div class="flex items-start gap-3">
                        <div
                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-white/20 dark:bg-white/10"
                        >
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="mb-1 text-sm font-semibold text-white">Error!</h4>
                            <AlertDescription v-if="flash.error" class="text-sm text-white/90">
                                {{ flash.error }}
                            </AlertDescription>
                            <AlertDescription
                                v-else-if="errors && Object.keys(errors).length > 0"
                                class="text-sm text-white/90"
                            >
                                <ul class="mt-1 space-y-1">
                                    <li v-for="(error, key) in errors" :key="key" class="flex items-start gap-2">
                                        <span class="mt-0.5 text-white">•</span>
                                        <span>{{ Array.isArray(error) ? error[0] : error }}</span>
                                    </li>
                                </ul>
                            </AlertDescription>
                        </div>
                        <button
                            @click="clearMessage('error')"
                            class="flex-shrink-0 rounded-md p-1.5 transition-colors hover:bg-white/20 dark:hover:bg-white/10"
                            aria-label="Dismiss"
                        >
                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </div>
                </Alert>

                <!-- Warning Message -->
                <Alert
                    v-if="show && flash.warning"
                    key="warning"
                    variant="warning"
                    class="pointer-events-auto border-l-4 border-l-amber-500 shadow-lg"
                >
                    <div class="flex items-start gap-3">
                        <div
                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/30"
                        >
                            <svg
                                class="h-5 w-5 text-amber-600 dark:text-amber-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="mb-1 text-sm font-semibold text-amber-900 dark:text-amber-100">Warning!</h4>
                            <AlertDescription class="text-sm text-amber-800 dark:text-amber-200">
                                {{ flash.warning }}
                            </AlertDescription>
                        </div>
                        <button
                            @click="clearMessage('warning')"
                            class="flex-shrink-0 rounded-md p-1.5 transition-colors hover:bg-amber-100 dark:hover:bg-amber-900/50"
                            aria-label="Dismiss"
                        >
                            <svg
                                class="h-4 w-4 text-amber-600 dark:text-amber-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </div>
                    <div
                        v-if="props.autoDismiss"
                        class="absolute bottom-0 left-0 h-1 rounded-b bg-amber-500"
                        :style="{ width: progressWidth + '%' }"
                    ></div>
                </Alert>

                <!-- Info Message -->
                <Alert
                    v-if="show && flash.info"
                    key="info"
                    variant="default"
                    class="pointer-events-auto border-l-4 border-l-blue-500 shadow-lg"
                >
                    <div class="flex items-start gap-3">
                        <div
                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30"
                        >
                            <svg
                                class="h-5 w-5 text-blue-600 dark:text-blue-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="mb-1 text-sm font-semibold text-blue-900 dark:text-blue-100">Info</h4>
                            <AlertDescription class="text-sm text-blue-800 dark:text-blue-200">
                                {{ flash.info }}
                            </AlertDescription>
                        </div>
                        <button
                            @click="clearMessage('info')"
                            class="flex-shrink-0 rounded-md p-1.5 transition-colors hover:bg-blue-100 dark:hover:bg-blue-900/50"
                            aria-label="Dismiss"
                        >
                            <svg
                                class="h-4 w-4 text-blue-600 dark:text-blue-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </div>
                    <div
                        v-if="props.autoDismiss"
                        class="absolute bottom-0 left-0 h-1 rounded-b bg-blue-500"
                        :style="{ width: progressWidth + '%' }"
                    ></div>
                </Alert>
            </TransitionGroup>
        </div>
    </Teleport>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import { Alert, AlertDescription } from '@/Components/ui/alert'

const props = defineProps({
    autoDismiss: {
        type: Boolean,
        default: true
    },
    dismissTimeout: {
        type: Number,
        default: 5000
    }
})

const page = usePage()
const show = ref(false)
const flash = computed(() => page.props.flash || {})
const errors = computed(() => page.props.errors || {})
const progressWidth = ref(100)
const messageKey = ref(0)

let timeoutId = null
let progressInterval = null

const hasMessages = computed(() => {
    return (
        flash.value.success ||
        flash.value.error ||
        flash.value.warning ||
        flash.value.info ||
        (errors.value && Object.keys(errors.value).length > 0)
    )
})

const startProgressBar = () => {
    progressWidth.value = 100
    const step = 100 / (props.dismissTimeout / 50)

    progressInterval = setInterval(() => {
        progressWidth.value -= step
        if (progressWidth.value <= 0) {
            clearInterval(progressInterval)
        }
    }, 50)
}

const stopProgressBar = () => {
    if (progressInterval) {
        clearInterval(progressInterval)
        progressInterval = null
    }
}

// Watch for flash message changes (including on navigation)
watch(
    () => [flash.value.success, flash.value.error, flash.value.warning, flash.value.info],
    () => {
        if (hasMessages.value) {
            // Force re-render by updating key
            messageKey.value++
            show.value = true

            // Clear existing timers
            stopProgressBar()
            clearTimeout(timeoutId)

            // Only auto-dismiss success, warning, and info messages
            if (props.autoDismiss && !flash.value.error && !(errors.value && Object.keys(errors.value).length > 0)) {
                startProgressBar()

                timeoutId = setTimeout(() => {
                    show.value = false
                    stopProgressBar()
                }, props.dismissTimeout)
            }
        } else {
            show.value = false
            stopProgressBar()
        }
    },
    { immediate: true, deep: true }
)

const clearMessage = (type) => {
    stopProgressBar()
    clearTimeout(timeoutId)

    if (type === 'error') {
        // Clear both flash error and validation errors
        page.props.flash.error = null
        page.props.errors = {}
    } else {
        page.props.flash[type] = null
    }

    // Check if any messages remain
    if (!hasMessages.value) {
        show.value = false
    }
}

// Listen to Inertia navigation events to reset messages
router.on('success', () => {
    // Reset the message key to trigger re-render
    messageKey.value++
})

onMounted(() => {
    if (hasMessages.value) {
        show.value = true
        messageKey.value++
    }
})

onUnmounted(() => {
    stopProgressBar()
    if (timeoutId) {
        clearTimeout(timeoutId)
    }
})
</script>
