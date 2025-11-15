<template>
    <Head title="Dashboard" />
    <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="khmer-text text-3xl font-bold text-gray-800">ស្វាគមន៍មកកាន់ផ្ទាំងគ្រប់គ្រង</h1>
                <p class="khmer-text mt-1 text-gray-500">ទិដ្ឋភាពទូទៅនៃប្រព័ន្ធរបស់អ្នក</p>
            </div>
            <div class="text-sm text-gray-500">
                {{ currentDate }}
            </div>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Users Card -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
            >
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
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
                        <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-medium">+12%</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="khmer-text text-sm font-medium opacity-90">អ្នកប្រើប្រាស់</h3>
                        <p class="text-4xl font-bold">{{ countCategories }}</p>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
            >
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
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
                        <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-medium">+8%</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="khmer-text text-sm font-medium opacity-90">ផលិតផលសរុប</h3>
                        <p class="text-4xl font-bold">85</p>
                    </div>
                </div>
            </div>

            <!-- Categories Card -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
            >
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
                <div class="relative">
                    <div class="mb-4 flex items-start justify-between">
                        <div class="rounded-xl bg-white/20 p-3 backdrop-blur-sm">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                />
                            </svg>
                        </div>
                        <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-medium">+5%</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="khmer-text text-sm font-medium opacity-90">ប្រភេទសរុប</h3>
                        <p class="text-4xl font-bold">12</p>
                    </div>
                </div>
            </div>

            <!-- Orders Card -->
            <div
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 p-6 text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
            >
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
                <div class="relative">
                    <div class="mb-4 flex items-start justify-between">
                        <div class="rounded-xl bg-white/20 p-3 backdrop-blur-sm">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                        </div>
                        <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-medium">+18%</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="khmer-text text-sm font-medium opacity-90">ការបញ្ជាទិញ</h3>
                        <p class="text-4xl font-bold">45</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Stats -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Revenue Chart Placeholder -->
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="khmer-text text-lg font-semibold text-gray-800">ចំណូលប្រចាំខែ</h3>
                    <select
                        class="rounded-lg border border-gray-200 px-3 py-1.5 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                        <option>ខែនេះ</option>
                        <option>ខែមុន</option>
                        <option>បីខែចុងក្រោយ</option>
                    </select>
                </div>
                <div
                    class="flex h-64 items-center justify-center rounded-xl bg-gradient-to-br from-gray-50 to-gray-100"
                >
                    <div class="text-center text-gray-400">
                        <svg class="mx-auto mb-2 h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                            />
                        </svg>
                        <p class="khmer-text">គំនូសតាងនឹងត្រូវបានបង្ហាញនៅទីនេះ</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="khmer-text mb-6 text-lg font-semibold text-gray-800">សកម្មភាពថ្មីៗ</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="rounded-lg bg-blue-100 p-2">
                            <svg class="h-4 w-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="khmer-text text-sm font-medium text-gray-800">អ្នកប្រើថ្មី បានចុះឈ្មោះ</p>
                            <p class="text-xs text-gray-500">២ នាទីមុន</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="rounded-lg bg-green-100 p-2">
                            <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="khmer-text text-sm font-medium text-gray-800">ការបញ្ជាទិញបានបញ្ចប់</p>
                            <p class="text-xs text-gray-500">១៥ នាទីមុន</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="rounded-lg bg-amber-100 p-2">
                            <svg class="h-4 w-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                <path
                                    d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="khmer-text text-sm font-medium text-gray-800">ផលិតផលថ្មី បានបន្ថែម</p>
                            <p class="text-xs text-gray-500">៣០ នាទីមុន</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="rounded-lg bg-purple-100 p-2">
                            <svg class="h-4 w-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="khmer-text text-sm font-medium text-gray-800">ការជូនដំណឹង ពីប្រព័ន្ធ</p>
                            <p class="text-xs text-gray-500">១ ម៉ោងមុន</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="rounded-2xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-8 text-white shadow-xl">
            <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                <div>
                    <h3 class="khmer-text mb-2 text-2xl font-bold">ត្រៀមរួចជាស្រេច?</h3>
                    <p class="khmer-text text-white/90">ចាប់ផ្តើមគ្រប់គ្រងផលិតផល និងការបញ្ជាទិញរបស់អ្នក</p>
                </div>
                <div class="flex gap-3">
                    <button
                        class="khmer-text rounded-xl bg-white px-6 py-3 font-semibold text-purple-600 shadow-lg transition-colors hover:bg-gray-50"
                    >
                        បន្ថែមផលិតផល
                    </button>
                    <button
                        class="khmer-text rounded-xl bg-white/20 px-6 py-3 font-semibold text-white backdrop-blur-sm transition-colors hover:bg-white/30"
                    >
                        មើលរបាយការណ៍
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed } from 'vue'

const props = defineProps({
    countCategories: Number
})

// Get current date in a nice format
const currentDate = computed(() => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' }
    return new Date().toLocaleDateString('km-KH', options)
})
</script>
