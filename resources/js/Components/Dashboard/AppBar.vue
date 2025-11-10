<template>
    <header class="fixed top-0 right-0 z-40 flex items-center justify-between bg-white border-b border-gray-200 px-6 py-3 shadow-sm transition-all duration-300" :class="{ 'left-64': drawer && !rail, 'left-16': rail, 'left-0': !drawer }">
        <div class="flex items-center gap-4">
            <button @click="toggleDrawer" class="p-2 rounded-lg hover:bg-gray-100 transition-colors text-gray-700">
                <Menu class="w-5 h-5" />
            </button>
            <div class="hidden md:block">
                <h1 class="text-lg font-semibold text-gray-900 khmer-text">ប្រព័ន្ធគ្រប់គ្រង</h1>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- Link to Frontend -->
            <button @click="goToFrontend" class="p-2 rounded-lg hover:bg-gray-100 transition-colors text-gray-700" title="ទៅទំព័រមុខ">
                <Globe class="w-5 h-5" />
            </button>

            <!-- Settings button -->
            <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors text-gray-700" title="ការកំណត់">
                <Settings class="w-5 h-5" />
            </button>

            <!-- User menu dropdown -->
            <div class="relative">
                <button @click="toggleDropdown" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors text-gray-700">
                    <div class="w-8 h-8 bg-gray-900 rounded-full flex items-center justify-center">
                        <User class="w-4 h-4 text-white" />
                    </div>
                    <span class="hidden md:block text-sm font-medium khmer-text text-gray-900">{{ userName }}</span>
                    <ChevronDown :class="['w-4 h-4 transition-transform duration-200', { 'rotate-180': isDropdownOpen }]" />
                </button>

                <!-- Dropdown Menu -->
                <Transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                >
                    <div v-if="isDropdownOpen" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden z-50">
                        <div class="p-3 border-b border-gray-200 bg-gray-50">
                            <p class="text-sm font-semibold text-gray-900 khmer-text">{{ userName }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ userEmail }}</p>
                        </div>
                        <div class="py-1">
                            <button @click="handleGoToFrontend" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <Globe class="w-4 h-4" />
                                <span class="khmer-text">ទៅទំព័រមុខ</span>
                            </button>
                            <button class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <UserCircle class="w-4 h-4" />
                                <span class="khmer-text">ប្រវត្តិរូប</span>
                            </button>
                            <button class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <Settings class="w-4 h-4" />
                                <span class="khmer-text">ការកំណត់</span>
                            </button>
                        </div>
                        <div class="border-t border-gray-200 py-1">
                            <button @click="handleLogout" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <LogOut class="w-4 h-4" />
                                <span class="khmer-text">ចាកចេញ</span>
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
import { ref, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { Menu, Settings, User, LogOut, Globe, ChevronDown, UserCircle } from 'lucide-vue-next';

const props = defineProps({
    drawer: {
        type: Boolean,
        default: true
    },
    rail: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['toggle-drawer']);

const page = usePage();

const userName = computed(() => page.props.auth?.user?.name || 'User');
const userEmail = computed(() => page.props.auth?.user?.email || '');

const isDropdownOpen = ref(false);

const toggleDrawer = () => {
    emit('toggle-drawer');
};

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const closeDropdown = () => {
    isDropdownOpen.value = false;
};

const goToFrontend = () => {
    router.get(route('home'));
};

const handleGoToFrontend = () => {
    closeDropdown();
    goToFrontend();
};

const handleLogout = () => {
    closeDropdown();
    router.post(route('logout'));
};
</script>
