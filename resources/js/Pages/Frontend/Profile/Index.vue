<script>
    export default {
        layout: null
    }
</script>

<script setup>
    import Menu from '@/Components/Frontend/Menu.vue';
    import { Head } from '@inertiajs/vue3';
    import { computed } from 'vue';

    // Props
    const props = defineProps({
        user: {
            type: Object,
            required: true
        }
    })

    // Get user initial (first letter of name)
    const getUserInitial = computed(() => {
        if (props.user && props.user.name) {
            return props.user.name.charAt(0).toUpperCase()
        }
        return 'U'
    })

    // Format date
    const formatDate = (dateString) => {
        if (!dateString) return 'N/A'
        const date = new Date(dateString)
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        })
    }

    // Actions
    const editProfile = () => {
        // Handle edit profile
        console.log('Edit profile')
    }

    const changePassword = () => {
        // Handle change password
        console.log('Change password')
    }
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-purple-900 via-slate-900 to-slate-950">

        <Head title="Profile" />

        <!-- Navigation -->
        <Menu />

        <!-- Profile Content -->
        <div class="py-8 px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-5xl">
                <!-- Profile Header Card -->
                <div
                    class="overflow-hidden rounded-3xl border border-fuchsia-500/20 bg-slate-800/60 shadow-2xl shadow-fuchsia-500/20 backdrop-blur-xl">
                    <!-- Cover Background -->
                    <div class="h-32 bg-gradient-to-r from-fuchsia-500 via-pink-500 to-purple-500 sm:h-40"></div>

                    <!-- Profile Content -->
                    <div class="relative px-6 pb-8">
                        <!-- Avatar -->
                        <div class="flex flex-col items-center sm:flex-row sm:items-end sm:space-x-6">
                            <div class="-mt-16 sm:-mt-20">
                                <div
                                    class="flex h-32 w-32 items-center justify-center rounded-full border-4 border-slate-800 bg-gradient-to-r from-fuchsia-500 to-pink-500 text-6xl font-bold text-white shadow-2xl">
                                    {{ getUserInitial }}
                                </div>
                            </div>

                            <div class="mt-4 text-center sm:mt-0 sm:text-left">
                                <h1 class="text-3xl font-bold text-white">{{ user?.name }}</h1>
                                <p class="mt-1 text-sm text-gray-400">{{ user?.email }}</p>
                                <div class="mt-2 flex flex-wrap items-center justify-center gap-2 sm:justify-start">
                                    <span v-for="role in user?.roles" :key="role"
                                        class="inline-flex items-center rounded-full bg-gradient-to-r from-fuchsia-500/20 to-pink-500/20 px-3 py-1 text-xs font-semibold text-fuchsia-400">
                                        {{ role }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information Card -->
                <div class="mt-8">
                    <div
                        class="overflow-hidden rounded-3xl border border-fuchsia-500/20 bg-slate-800/60 shadow-xl shadow-fuchsia-500/10 backdrop-blur-xl transition-all duration-300 hover:shadow-fuchsia-500/20 hover:border-fuchsia-500/30">
                        <div
                            class="border-b border-fuchsia-500/20 bg-gradient-to-r from-fuchsia-500/10 to-pink-500/10 px-6 py-4">
                            <h2 class="flex items-center gap-2 text-lg font-semibold text-white">
                                <svg class="h-5 w-5 text-fuchsia-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Personal Information
                            </h2>
                        </div>
                        <div class="space-y-5 px-6 py-6">
                            <div class="flex items-start justify-between">
                                <div class="w-full">
                                    <p class="text-sm font-medium text-gray-400">Full Name</p>
                                    <p class="mt-1.5 text-lg font-semibold text-white">{{ user?.name }}</p>
                                </div>
                            </div>
                            <div class="h-px bg-gradient-to-r from-transparent via-fuchsia-500/20 to-transparent"></div>
                            <div class="flex items-start justify-between">
                                <div class="w-full">
                                    <p class="text-sm font-medium text-gray-400">Email Address</p>
                                    <p class="mt-1.5 text-lg font-semibold text-white break-all">{{ user?.email }}</p>
                                </div>
                            </div>
                            <div class="h-px bg-gradient-to-r from-transparent via-fuchsia-500/20 to-transparent"></div>
                            <div class="flex items-start justify-between">
                                <div class="w-full">
                                    <p class="text-sm font-medium text-gray-400">Member Since</p>
                                    <p class="mt-1.5 text-lg font-semibold text-white">{{ formatDate(user?.created_at) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                    <button @click="editProfile"
                        class="flex-1 flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-8 py-4 font-bold text-white shadow-2xl shadow-fuchsia-500/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-fuchsia-500/50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profile
                    </button>
                    <button @click="changePassword"
                        class="flex-1 flex items-center justify-center gap-2 rounded-2xl border-2 border-fuchsia-500/50 bg-slate-800/80 backdrop-blur-sm px-8 py-4 font-bold text-fuchsia-400 shadow-lg shadow-fuchsia-500/10 transition-all duration-300 hover:scale-[1.02] hover:bg-fuchsia-500/10 hover:border-fuchsia-500/70 hover:shadow-fuchsia-500/20">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        Change Password
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
