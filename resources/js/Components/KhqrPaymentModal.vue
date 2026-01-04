<template>
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="show"
                class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/70 backdrop-blur-sm p-4">
                <div @click.stop
                    class="relative w-full max-w-md rounded-3xl bg-slate-800/95 backdrop-blur-xl border border-fuchsia-500/30 shadow-2xl shadow-fuchsia-500/20">

                    <!-- Close Button -->
                    <button @click="$emit('close')"
                        class="absolute right-4 top-4 z-10 rounded-full bg-slate-900/80 p-2 text-gray-400 hover:bg-slate-900 hover:text-white transition-all duration-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Content -->
                    <div class="px-6 py-8">
                        <div class="flex flex-col items-center">
                            <!-- Total Amount -->
                            <div class="mb-6 text-center">
                                <p class="text-sm text-gray-400 mb-2">Total Amount</p>
                                <p
                                    class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-400">
                                    ${{ order.total_amount?.toFixed(2) || '0.00' }}
                                </p>
                            </div>

                            <!-- QR Code -->
                            <div class="flex justify-center">
                                <div
                                    class="flex h-72 w-72 items-center justify-center rounded-2xl bg-white p-5 shadow-2xl shadow-fuchsia-500/30 ring-2 ring-fuchsia-500/40">
                                    <div v-if="qrCodeData" class="flex items-center justify-center w-full h-full"
                                        v-html="qrCodeData"></div>
                                    <div v-else class="flex flex-col items-center justify-center">
                                        <div
                                            class="animate-spin rounded-full h-16 w-16 border-4 border-t-fuchsia-500 border-r-pink-500 border-b-purple-500 border-l-slate-300 mb-3">
                                        </div>
                                        <p class="text-sm text-gray-400 font-medium">Generating QR Code...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
    import { computed } from 'vue'

    const props = defineProps({
        show: {
            type: Boolean,
            default: false
        },
        order: {
            type: Object,
            default: () => ({})
        },
        qrData: {
            type: String,
            default: ''
        }
    })

    defineEmits(['close'])

    // Computed QR data to ensure reactivity
    const qrCodeData = computed(() => {
        return props.qrData
    })
</script>

<style scoped>

    .modal-enter-active,
    .modal-leave-active {
        transition: opacity 0.3s ease;
    }

    .modal-enter-from,
    .modal-leave-to {
        opacity: 0;
    }

    .modal-enter-active>div,
    .modal-leave-active>div {
        transition: transform 0.3s ease;
    }

    .modal-enter-from>div,
    .modal-leave-to>div {
        transform: scale(0.95);
    }
</style>
