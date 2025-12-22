<template>
    <header
        class="fixed top-0 right-0 z-40 flex items-center justify-between border-b border-gray-200 bg-white px-6 py-3 shadow-sm transition-all duration-300"
        :class="{ 'left-64': drawer && !rail, 'left-16': rail, 'left-0': !drawer }">
        <div class="flex items-center gap-4">
            <button @click="toggleDrawer" class="rounded-lg p-2 text-gray-700 transition-colors hover:bg-gray-100">
                <Menu class="h-5 w-5" />
            </button>
            <div class="hidden md:block">
                <h1 class="khmer-text text-lg font-semibold text-amber-800">ប្រព័ន្ធគ្រប់គ្រង</h1>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- Link to Frontend -->
            <button @click="goToFrontend" class="rounded-lg p-2 text-gray-700 transition-colors hover:bg-gray-100"
                title="ទៅទំព័រមុខ">
                <Globe class="h-5 w-5" />
            </button>

            <!-- Settings button -->
            <button @click="goToSettings" class="rounded-lg p-2 text-gray-700 transition-colors hover:bg-gray-100"
                title="ការកំណត់">
                <Settings class="h-5 w-5" />
            </button>

            <!-- User menu dropdown -->
            <div class="relative">
                <button @click="toggleDropdown"
                    class="flex items-center gap-2 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-900">
                        <User class="h-4 w-4 text-white" />
                    </div>
                    <span class="khmer-text hidden text-sm font-medium text-gray-900 md:block">{{ userName }}</span>
                    <ChevronDown
                        :class="['h-4 w-4 transition-transform duration-200', { 'rotate-180': isDropdownOpen }]" />
                </button>

                <!-- Dropdown Menu -->
                <Transition enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <div v-if="isDropdownOpen"
                        class="absolute right-0 z-50 mt-2 w-56 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-xl">
                        <div class="border-b border-gray-200 bg-gray-50 p-3">
                            <p class="khmer-text text-sm font-semibold text-gray-900">{{ userName }}</p>
                            <p class="mt-0.5 text-xs text-gray-500">{{ userEmail }}</p>
                        </div>
                        <!-- Bottom Actions -->
                        <div class="space-y-0.5 border-t border-gray-200 p-2">
                            <button @click="handleLogout" :class="cn(
                                'flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 transition-all duration-200 hover:bg-gray-100',
                                {
                                    'justify-center px-0': rail && !mobile
                                }
                            )
                                ">
                                <LogOut class="h-5 w-5" />
                                <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">ចាកចេញ</span>
                            </button>
                        </div>
                    </div>
                </Transition>

            </div>
        </div>
    </header>

    <!-- Backdrop to close dropdown when clicking outside -->
    <div v-if="isDropdownOpen" @click="closeDropdown" class="fixed inset-0 z-30"></div>
</template>

<script setup>
    import { cn } from '@/lib/utils'
    import { router, usePage } from '@inertiajs/vue3'
    import { ChevronDown, Globe, LogOut, Menu, Settings, User } from 'lucide-vue-next'
    import { computed, ref } from 'vue'

    const props = defineProps({
        drawer: {
            type: Boolean,
            default: true
        },
        rail: {
            type: Boolean,
            default: false
        }
    })

    const emit = defineEmits(['toggle-drawer'])

    const page = usePage()

    const userName = computed(() => page.props.auth?.user?.name || 'User')
    const userEmail = computed(() => page.props.auth?.user?.email || '')

    const isDropdownOpen = ref(false)

    const toggleDrawer = () => {
        emit('toggle-drawer')
    }

    const toggleDropdown = () => {
        isDropdownOpen.value = !isDropdownOpen.value
    }

    const closeDropdown = () => {
        isDropdownOpen.value = false
    }

    const goToFrontend = () => {
        router.get(route('home'))
    }

    const handleGoToFrontend = () => {
        closeDropdown()
        goToFrontend()
    }

    /**
     * Handle user logout
     */
    const handleLogout = () => {
        closeDropdown()
        router.post(route('logout'))
    }
    /**
     * goto settings page
     * 
     */
    const goToSettings = () => {
        router.get(route('dashboard.settings.index'))
    }
</script>
