<template>
    <Head title="Dashboard" />
    <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="khmer-text text-3xl font-bold text-gray-800">ស្វាគមន៍មកកាន់ផ្ទាំងគ្រប់គ្រង</h1>
            </div>
            <div class="text-sm text-gray-500">
                {{ currentDate }}
            </div>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Users Card -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-800 to-amber-900 p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
            >
                <div class="absolute right-0 top-0 -mr-4 -mt-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
                <div class="relative">
                    <div class="mb-4 flex items-start justify-between">
                        <div class="rounded-xl bg-white/20 p-3 backdrop-blur-sm">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="khmer-text text-sm font-medium opacity-90">អ្នកប្រើប្រាស់</h3>
                        <p class="text-4xl font-bold">{{ users }}</p>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
            >
                <div class="absolute right-0 top-0 -mr-4 -mt-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
                <div class="relative">
                    <div class="mb-4 flex items-start justify-between">
                        <div class="rounded-xl bg-white/20 p-3 backdrop-blur-sm">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="khmer-text text-sm font-medium opacity-90">ផលិតផលសរុប</h3>
                        <p class="text-4xl font-bold">{{ products }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed } from 'vue'

const props = defineProps({
    users: {
        type: Number,
        required: true,
        default: 0
    },
    products: {
        type: Number,
        required: true,
        default: 0
    }
})

// Get current date in a nice format
const currentDate = computed(() => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' }
    return new Date().toLocaleDateString('km-KH', options)
})
</script>
