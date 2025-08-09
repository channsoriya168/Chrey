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
                    <Link 
                        v-for="pageItem in pages" 
                        :key="pageItem.path" 
                        :href="pageItem.path" 
                        class="nav-link"
                        :class="{ 'active': $page.url === pageItem.path }"
                    >
                        {{ pageItem.name }}
                    </Link>
                </div>

                <!-- Right Side Actions -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Language Switcher -->
                    <div class="relative" ref="languageMenu">
                        <button 
                            @click="toggleLanguageMenu"
                            class="flex items-center p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors"
                        >
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                            </svg>
                            <span class="text-sm">{{ getCurrentLanguageName() }}</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Language Dropdown -->
                        <div v-if="showLanguageMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                            <button 
                                v-for="language in languages" 
                                :key="language.code"
                                @click="changeLanguage(language.code)"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors"
                                :class="{ 'bg-indigo-50 text-indigo-700': currentLanguage === language.code }"
                            >
                                {{ language.name }}
                            </button>
                        </div>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-3">
                        <button 
                            @click="LoginView"
                            class="text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-md border border-gray-300 hover:border-indigo-300 transition-colors font-medium"
                            :class="{ 'text-indigo-600 border-indigo-300 bg-indigo-50': $page.url === '/login' }"
                        >
                            Login
                        </button>
                        <button 
                            @click="RegisterView"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors font-medium"
                            :class="{ 'bg-indigo-700': $page.url === '/register' }"
                        >
                            Register
                        </button>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button 
                        @click="toggleMobileMenu"
                        class="text-gray-600 hover:text-gray-900 hover:bg-gray-100 p-2 rounded-md transition-colors"
                    >
                        <svg v-if="!showMobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div v-if="showMobileMenu" class="md:hidden bg-white border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <Link 
                    v-for="pageItem in pages" 
                    :key="pageItem.path" 
                    :href="pageItem.path"
                    @click="closeMobileMenu"
                    class="mobile-nav-link"
                    :class="{ 'active': $page.url === pageItem.path }"
                >
                    {{ pageItem.name }}
                </Link>
            </div>
            
            <!-- Mobile Actions -->
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="px-2 space-y-1">
                    <!-- Language Switcher Mobile -->
                    <div class="px-3 py-2">
                        <p class="text-sm font-medium text-gray-500 mb-2">Language</p>
                        <div class="space-y-1">
                            <button 
                                v-for="language in languages" 
                                :key="language.code"
                                @click="changeLanguage(language.code)"
                                class="block w-full text-left px-3 py-2 text-sm rounded-md transition-colors"
                                :class="currentLanguage === language.code ? 
                                    'bg-indigo-100 text-indigo-700' : 
                                    'text-gray-700 hover:bg-gray-100'"
                            >
                                {{ language.name }}
                            </button>
                        </div>
                    </div>
                    
                    <!-- Auth Buttons Mobile -->
                    <div class="px-2 space-y-2">
                        <button 
                            @click="LoginView"
                            class="w-full text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-md border border-gray-300 hover:border-indigo-300 transition-colors font-medium"
                            :class="{ 'text-indigo-600 border-indigo-300 bg-indigo-50': $page.url === '/login' }"
                        >
                            Login
                        </button>
                        <button 
                            @click="RegisterView"
                            class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors font-medium"
                            :class="{ 'bg-indigo-700': $page.url === '/register' }"
                        >
                            Register
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
<script setup>
    import { ref, onMounted, onUnmounted } from 'vue';
    import { usePage, router, Link } from '@inertiajs/vue3';

    const page = usePage();

    const pages = ref([
        { name: 'ទំព័រដើម', path: '/' },
        { name: 'អំពី', path: '/about' },
        { name: 'ទំនាក់ទំនង', path: '/contact' },
    ]);

    const languages = ref([
        { code: 'en', name: 'English' },
        { code: 'km', name: 'ខ្មែរ (Khmer)' },
    ]);

    const currentLanguage = ref('en');
    const showMobileMenu = ref(false);
    const showLanguageMenu = ref(false);
    const languageMenu = ref(null);

    function getCurrentLanguageName() {
        return languages.value.find(lang => lang.code === currentLanguage.value)?.name || 'English';
    }

    function changeLanguage(code) {
        currentLanguage.value = code;
        showLanguageMenu.value = false;
        showMobileMenu.value = false;
    }

    function toggleMobileMenu() {
        showMobileMenu.value = !showMobileMenu.value;
        showLanguageMenu.value = false;
    }

    function toggleLanguageMenu() {
        showLanguageMenu.value = !showLanguageMenu.value;
    }

    function closeMobileMenu() {
        showMobileMenu.value = false;
    }

    function closeMenus() {
        showMobileMenu.value = false;
        showLanguageMenu.value = false;
    }

    function handleClickOutside(event) {
        if (languageMenu.value && !languageMenu.value.contains(event.target)) {
            showLanguageMenu.value = false;
        }
    }

    const LoginView = () => {
        router.visit('/login', {
            method: 'get',
            preserveState: true,
            preserveScroll: true,
        });
        closeMobileMenu();
    };

    const RegisterView = () => {
        router.visit('/register', {
            method: 'get',
            preserveState: true,
            preserveScroll: true,
        });
        closeMobileMenu();
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
