<template>
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex-shrink-0 flex items-center">
                    <Link href="/" class="text-2xl font-bold text-indigo-600 hover:text-indigo-700 transition-colors">
                    Chrey
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <Link v-for="pageItem in pages" :key="pageItem.path" :href="pageItem.path" class="nav-link"
                        :class="{ 'active': $page.url === pageItem.path }">
                    {{ pageItem.name }}
                    </Link>
                </div>

                <!-- Right Side Actions -->
                <div class="hidden md:flex items-center space-x-4">

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-3">
                        <div v-if="authUser">
                            <!-- User dropdown -->
                            <div class="relative" ref="userMenu">
                                <button @click="toggleUserMenu"
                                    class="flex items-center p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors">
                                    <span class="text-sm mr-2">{{ authUser ? authUser.name : '' }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div v-if="showUserMenu"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                    <!-- Admin link -->
                                    <Link v-if="authUser && authUser.roles && authUser.roles.includes('admin')"
                                        :href="route('dashboard.index')"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    Dashboard
                                    </Link>
                                    <button @click="logout"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        Logout
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <button @click="LoginView"
                                class="text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-md border border-gray-300 hover:border-indigo-300 transition-colors font-medium mr-4"
                                :class="{ 'text-indigo-600 border-indigo-300 bg-indigo-50': $page.url === '/login' }">
                                ចូលគណនី
                            </button>
                            <button @click="RegisterView"
                                class="text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-md border border-gray-300 hover:border-indigo-300 transition-colors font-medium"
                                :class="{ 'text-indigo-600 border-indigo-300 bg-indigo-50': $page.url === '/register' }">
                                បង្កើតគណនី
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="toggleMobileMenu"
                        class="text-gray-600 hover:text-gray-900 hover:bg-gray-100 p-2 rounded-md transition-colors">
                        <svg v-if="!showMobileMenu" class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div v-if="showMobileMenu" class="md:hidden bg-white border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <Link v-for="pageItem in pages" :key="pageItem.path" :href="pageItem.path" @click="closeMobileMenu"
                    class="mobile-nav-link" :class="{ 'active': $page.url === pageItem.path }">
                {{ pageItem.name }}
                </Link>
            </div>

            <!-- Mobile Actions -->
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="px-2 space-y-1">

                    <!-- Auth Buttons Mobile -->
                    <div class="px-2 space-y-2">
                        <div v-if="authUser">
                            <div class="px-3 py-2 text-sm text-gray-500">
                                Logged in as: {{ authUser ? authUser.name : '' }}
                            </div>
                            <Link v-if="authUser && authUser.roles && authUser.roles.includes('admin')"
                                :href="route('dashboard.index')" @click="closeMobileMenu"
                                class="w-full text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-md border border-gray-300 hover:border-indigo-300 transition-colors font-medium block text-center">
                            Dashboard
                            </Link>
                            <button @click="logout"
                                class="w-full text-red-700 hover:text-red-800 px-4 py-2 rounded-md border border-red-300 hover:border-red-400 transition-colors font-medium">
                                Logout
                            </button>
                        </div>
                        <div v-else>
                            <button @click="LoginView"
                                class="w-full text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-md border border-gray-300 hover:border-indigo-300 transition-colors font-medium"
                                :class="{ 'text-indigo-600 border-indigo-300 bg-indigo-50': $page.url === '/login' }">
                                Login
                            </button>
                            <button @click="RegisterView"
                                class="w-full text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors font-medium"
                                :class="{ 'bg-indigo-700': $page.url === '/register' }">
                                Register
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
<script setup>
    import { ref, computed, onMounted, onUnmounted } from 'vue';
    import { usePage, router, Link } from '@inertiajs/vue3';

    const page = usePage();

    // computed safe reference to authenticated user (may be null)
    const authUser = computed(() => {
        return page && page.props && page.props.auth && page.props.auth.user ? page.props.auth.user : null;
    });

    const pages = ref([
        { name: 'ទំព័រដើម', path: '/' },
        { name: 'អំពី', path: '/about' },
        { name: 'ទំនាក់ទំនង', path: '/contact' },
    ]);

    const showMobileMenu = ref(false);
    const showLanguageMenu = ref(false);
    const showUserMenu = ref(false);
    const languageMenu = ref(null);
    const userMenu = ref(null);

    function toggleMobileMenu() {
        showMobileMenu.value = !showMobileMenu.value;
        showLanguageMenu.value = false;
    }

    function toggleLanguageMenu() {
        showLanguageMenu.value = !showLanguageMenu.value;
        showUserMenu.value = false;
    }

    function toggleUserMenu() {
        showUserMenu.value = !showUserMenu.value;
        showLanguageMenu.value = false;
    }

    function closeMobileMenu() {
        showMobileMenu.value = false;
    }

    function closeMenus() {
        showMobileMenu.value = false;
        showLanguageMenu.value = false;
        showUserMenu.value = false;
    }

    function handleClickOutside(event) {
        if (languageMenu.value && !languageMenu.value.contains(event.target)) {
            showLanguageMenu.value = false;
        }
        if (userMenu.value && !userMenu.value.contains(event.target)) {
            showUserMenu.value = false;
        }
    }

    const LoginView = () => {
        router.visit('/login', {
            method: 'get',
        });
        closeMobileMenu();
    };

    const RegisterView = () => {
        router.visit('/register', {
            method: 'get',
        });
        closeMobileMenu();
    };

    const logout = () => {
        router.post('/logout', {}, {
            onSuccess: () => {
                closeMenus();
            }
        });
    };

    onMounted(() => {
        document.addEventListener('click', handleClickOutside);
    });

    onUnmounted(() => {
        document.removeEventListener('click', handleClickOutside);
    });
</script>

<style scoped>
    .nav-link {
        color: #374151;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
        position: relative;
    }

    .nav-link:hover {
        color: #4f46e5;
        background-color: #f9fafb;
    }

    .nav-link.active {
        color: #4f46e5;
        background-color: #eef2ff;
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50%;
        height: 2px;
        background-color: #4f46e5;
        border-radius: 9999px;
    }

    .mobile-nav-link {
        display: block;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 1rem;
        font-weight: 500;
        color: #374151;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .mobile-nav-link:hover {
        color: #4f46e5;
        background-color: #f9fafb;
    }

    .mobile-nav-link.active {
        color: #4f46e5;
        background-color: #eef2ff;
        border-left: 4px solid #4f46e5;
    }

    /* Custom scrollbar for mobile menu */
    .mobile-menu::-webkit-scrollbar {
        width: 6px;
    }

    .mobile-menu::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .mobile-menu::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .mobile-menu::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
