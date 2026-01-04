<template>
    <Teleport to="body">
        <div
            class="pointer-events-none fixed top-0 right-0 z-[9999] flex flex-col items-end px-4 pt-4"
            aria-live="polite"
            aria-atomic="true"
        >
            <TransitionGroup
                enter-active-class="transform transition-all duration-300 ease-out"
                enter-from-class="translate-x-full opacity-0"
                enter-to-class="translate-x-0 opacity-100"
                leave-active-class="transform transition-all duration-200 ease-in"
                leave-from-class="translate-x-0 opacity-100"
                leave-to-class="translate-x-full opacity-0"
            >
                <!-- Success Toast -->
                <div
                    v-if="show && flash.success"
                    key="success"
                    class="pointer-events-auto mb-3 flex min-w-[320px] max-w-md items-center gap-3 rounded-xl bg-gradient-to-r from-fuchsia-600 to-pink-600 px-4 py-3 shadow-2xl shadow-fuchsia-500/50 backdrop-blur-sm"
                >
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-white/20">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </div>
                    <div class="flex-1 text-white">
                        <p class="text-sm font-semibold">{{ t('flash.success.title') }}</p>
                        <p class="text-xs opacity-90">{{ t(flash.success) }}</p>
                    </div>
                    <button
                        @click="clearMessage('success')"
                        class="flex-shrink-0 rounded-lg p-1 text-white/80 transition-all hover:bg-white/20 hover:text-white"
                        :aria-label="t('flash.success.dismiss')"
                    >
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <div
                        v-if="props.autoDismiss && !flash.error"
                        class="absolute bottom-0 left-0 h-1 rounded-b-xl bg-white/30"
                        :style="{ width: progressWidth + '%' }"
                    ></div>
                </div>

                <!-- Error Toast -->
                <div
                    v-if="show && (flash.error || (errors && Object.keys(errors).length > 0))"
                    key="error"
                    class="pointer-events-auto mb-3 flex min-w-[320px] max-w-md items-start gap-3 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 px-4 py-3 shadow-2xl shadow-red-500/50 backdrop-blur-sm"
                >
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-white/20">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </div>
                    <div class="flex-1 text-white">
                        <p class="text-sm font-semibold">{{ t('flash.error.title') }}</p>
                        <p v-if="flash.error" class="text-xs opacity-90">{{ t(flash.error) }}</p>
                        <div v-else-if="errors && Object.keys(errors).length > 0" class="text-xs opacity-90">
                            <ul class="mt-1 space-y-0.5">
                                <li v-for="(error, key) in errors" :key="key">
                                    {{ Array.isArray(error) ? error[0] : error }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <button
                        @click="clearMessage('error')"
                        class="flex-shrink-0 rounded-lg p-1 text-white/80 transition-all hover:bg-white/20 hover:text-white"
                        :aria-label="t('flash.error.dismiss')"
                    >
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Warning Toast -->
                <div
                    v-if="show && flash.warning"
                    key="warning"
                    class="pointer-events-auto mb-3 flex min-w-[320px] max-w-md items-center gap-3 rounded-xl bg-gradient-to-r from-amber-500 to-yellow-500 px-4 py-3 shadow-2xl shadow-amber-500/50 backdrop-blur-sm"
                >
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-white/20">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                            />
                        </svg>
                    </div>
                    <div class="flex-1 text-white">
                        <p class="text-sm font-semibold">{{ t('flash.warning.title') }}</p>
                        <p class="text-xs opacity-90">{{ t(flash.warning) }}</p>
                    </div>
                    <button
                        @click="clearMessage('warning')"
                        class="flex-shrink-0 rounded-lg p-1 text-white/80 transition-all hover:bg-white/20 hover:text-white"
                        :aria-label="t('flash.warning.dismiss')"
                    >
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <div
                        v-if="props.autoDismiss"
                        class="absolute bottom-0 left-0 h-1 rounded-b-xl bg-white/30"
                        :style="{ width: progressWidth + '%' }"
                    ></div>
                </div>

                <!-- Info Toast -->
                <div
                    v-if="show && flash.info"
                    key="info"
                    class="pointer-events-auto mb-3 flex min-w-[320px] max-w-md items-center gap-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 shadow-2xl shadow-blue-500/50 backdrop-blur-sm"
                >
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-white/20">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                    <div class="flex-1 text-white">
                        <p class="text-sm font-semibold">{{ t('flash.info.title') }}</p>
                        <p class="text-xs opacity-90">{{ t(flash.info) }}</p>
                    </div>
                    <button
                        @click="clearMessage('info')"
                        class="flex-shrink-0 rounded-lg p-1 text-white/80 transition-all hover:bg-white/20 hover:text-white"
                        :aria-label="t('flash.info.dismiss')"
                    >
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <div
                        v-if="props.autoDismiss"
                        class="absolute bottom-0 left-0 h-1 rounded-b-xl bg-white/30"
                        :style="{ width: progressWidth + '%' }"
                    ></div>
                </div>
            </TransitionGroup>
        </div>
    </Teleport>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

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

const { t } = useI18n()
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

watch(
    () => [flash.value.success, flash.value.error, flash.value.warning, flash.value.info],
    () => {
        if (hasMessages.value) {
            messageKey.value++
            show.value = true

            stopProgressBar()
            clearTimeout(timeoutId)

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
        page.props.flash.error = null
        page.props.errors = {}
    } else {
        page.props.flash[type] = null
    }

    if (!hasMessages.value) {
        show.value = false
    }
}

router.on('success', () => {
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