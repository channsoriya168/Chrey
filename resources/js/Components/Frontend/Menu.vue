<template>
    <nav class="sticky top-0 z-50 bg-white shadow-lg">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo/Brand -->
                <div class="flex flex-shrink-0 items-center">
                    <Link href="/" class="text-2xl font-bold text-indigo-600 transition-colors hover:text-indigo-700">
                        Chrey
                    </Link>
                </div>

                <!-- Right Side Actions -->
                <div class="hidden items-center space-x-4 md:flex">
                    <!-- Language Switcher -->
                    <div class="relative" ref="languageMenu">
                        <button
                            @click="showLanguageMenu = !showLanguageMenu"
                            class="flex items-center gap-2 rounded-md px-3 py-2 text-gray-700 transition-colors hover:bg-gray-100"
                        >
                            <Icon :icon="currentLanguage.flag" class="w-6 h-6" />
                            <span class="text-sm font-medium">{{ currentLanguage.name }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                ></path>
                            </svg>
                        </button>
                        <div
                            v-if="showLanguageMenu"
                            class="absolute right-0 z-10 mt-2 w-48 rounded-lg bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5"
                        >
                            <button
                                v-for="lang in languages"
                                :key="lang.code"
                                @click="handleLanguageSwitch(lang.code)"
                                :class="[
                                    'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition-colors',
                                    locale === lang.code
                                        ? 'bg-pink-50 text-pink-700 font-semibold'
                                        : 'text-gray-700 hover:bg-gray-100'
                                ]"
                            >
                                <Icon :icon="lang.flag" class="w-6 h-6" />
                                <span>{{ lang.fullName }}</span>
                                <svg
                                    v-if="locale === lang.code"
                                    class="ml-auto h-4 w-4 text-pink-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Cart Button -->
                    <CartDrawer />

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-3">
                        <div v-if="authUser">
                            <!-- User dropdown -->
                            <div class="relative" ref="userMenu">
                                <button
                                    @click="toggleUserMenu"
                                    class="flex items-center justify-center rounded-full p-2 text-gray-600 transition-colors hover:bg-indigo-50 hover:text-indigo-600"
                                    :title="authUser ? authUser.name : ''"
                                >
                                    <Icon icon="heroicons:user-circle-solid" class="h-8 w-8" />
                                </button>

                                <div
                                    v-if="showUserMenu"
                                    class="absolute right-0 z-10 mt-2 w-48 rounded-md bg-white py-1 shadow-lg"
                                >
                                    <!-- My Orders link -->
                                    <Link
                                        :href="route('orders.index')"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100"
                                    >
                                        <Icon icon="heroicons:shopping-bag" class="h-4 w-4" />
                                        {{ t('nav.auth.myOrders') }}
                                    </Link>
                                    <!-- Admin link -->
                                    <Link
                                        v-if="authUser && authUser.roles && authUser.roles.includes('admin')"
                                        :href="route('dashboard.index')"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100"
                                    >
                                        <Icon icon="heroicons:chart-bar" class="h-4 w-4" />
                                        {{ t('nav.auth.dashboard') }}
                                    </Link>
                                    <button
                                        @click="logout"
                                        class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-gray-700 transition-colors hover:bg-gray-100"
                                    >
                                        <Icon icon="heroicons:arrow-left-on-rectangle" class="h-4 w-4" />
                                        {{ t('nav.auth.logout') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-else>
                            <button
                                @click="LoginView"
                                class="flex items-center justify-center rounded-full p-2 text-gray-600 transition-colors hover:bg-indigo-50 hover:text-indigo-600"
                                :title="t('nav.auth.login')"
                            >
                                <Icon icon="heroicons:user-circle-solid" class="h-8 w-8" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center space-x-2 md:hidden">
                    <!-- Language Switcher Mobile -->
                    <div class="relative" ref="languageMenuMobile">
                        <button
                            @click="showLanguageMenu = !showLanguageMenu"
                            class="flex items-center justify-center rounded-full p-2 text-gray-600 transition-colors hover:bg-gray-100"
                        >
                            <Icon :icon="currentLanguage.flag" class="w-6 h-6" />
                        </button>
                    </div>

                    <!-- Cart Button Mobile -->
                    <CartDrawer />

                    <!-- Auth Button Mobile -->
                    <div v-if="authUser" class="relative" ref="userMenuMobile">
                        <button
                            @click="toggleUserMenu"
                            class="flex items-center justify-center rounded-full p-2 text-gray-600 transition-colors hover:bg-indigo-50 hover:text-indigo-600"
                        >
                            <Icon icon="heroicons:user-circle-solid" class="h-7 w-7" />
                        </button>
                    </div>
                    <div v-else>
                        <button
                            @click="LoginView"
                            class="flex items-center justify-center rounded-full p-2 text-gray-600 transition-colors hover:bg-indigo-50 hover:text-indigo-600"
                        >
                            <Icon icon="heroicons:user-circle-solid" class="h-7 w-7" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Language Dropdown for Mobile -->
        <div
            v-if="showLanguageMenu"
            class="absolute right-4 top-16 z-50 mt-2 w-48 rounded-lg bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 md:hidden"
        >
            <button
                v-for="lang in languages"
                :key="lang.code"
                @click="handleLanguageSwitch(lang.code)"
                :class="[
                    'flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition-colors',
                    locale === lang.code ? 'bg-pink-50 text-pink-700 font-semibold' : 'text-gray-700 hover:bg-gray-100'
                ]"
            >
                <Icon :icon="lang.flag" class="w-6 h-6" />
                <span>{{ lang.fullName }}</span>
                <svg
                    v-if="locale === lang.code"
                    class="ml-auto h-4 w-4 text-pink-600"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                    />
                </svg>
            </button>
        </div>

        <!-- User Menu Dropdown for Mobile -->
        <div
            v-if="showUserMenu && authUser"
            class="absolute right-4 top-16 z-50 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 md:hidden"
        >
            <Link
                :href="route('orders.index')"
                @click="closeMenus"
                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100"
            >
                <Icon icon="heroicons:shopping-bag" class="h-4 w-4" />
                {{ t('nav.auth.myOrders') }}
            </Link>
            <Link
                v-if="authUser && authUser.roles && authUser.roles.includes('admin')"
                :href="route('dashboard.index')"
                @click="closeMenus"
                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100"
            >
                <Icon icon="heroicons:chart-bar" class="h-4 w-4" />
                {{ t('nav.auth.dashboard') }}
            </Link>
            <button
                @click="logout"
                class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-gray-700 transition-colors hover:bg-gray-100"
            >
                <Icon icon="heroicons:arrow-left-on-rectangle" class="h-4 w-4" />
                {{ t('nav.auth.logout') }}
            </button>
        </div>
    </nav>
</template>
<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { usePage, router, Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { Icon } from '@iconify/vue'
import { languages, getCurrentLanguage } from '@/composables/useLanguages'
import CartDrawer from './CartDrawer.vue'

const page = usePage()
const { t, locale } = useI18n()

// Get current language object
const currentLanguage = computed(() => getCurrentLanguage(locale.value))

// computed safe reference to authenticated user (may be null)
const authUser = computed(() => {
    return page && page.props && page.props.auth && page.props.auth.user ? page.props.auth.user : null
})

// Dynamic pages based on current locale
const pages = computed(() => [
    { name: t('nav.menu.home'), path: '/' },
    { name: t('nav.menu.about'), path: '/about' },
    { name: t('nav.menu.contact'), path: '/contact' }
])

// Language switcher
const switchLocale = (newLocale) => {
    locale.value = newLocale
    localStorage.setItem('locale', newLocale)

    // Update URL with language parameter
    const url = new URL(window.location.href)
    url.searchParams.set('lang', newLocale)

    // Use Inertia router to navigate with the new language parameter
    router.visit(url.pathname + url.search, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}

// Handle language switch and close dropdown
const handleLanguageSwitch = (newLocale) => {
    switchLocale(newLocale)
    showLanguageMenu.value = false
}

const showMobileMenu = ref(false)
const showLanguageMenu = ref(false)
const showUserMenu = ref(false)
const languageMenu = ref(null)
const languageMenuMobile = ref(null)
const userMenu = ref(null)
const userMenuMobile = ref(null)

function toggleMobileMenu() {
    showMobileMenu.value = !showMobileMenu.value
    showLanguageMenu.value = false
    showUserMenu.value = false
}

function toggleUserMenu() {
    showUserMenu.value = !showUserMenu.value
    showLanguageMenu.value = false
}

function closeMobileMenu() {
    showMobileMenu.value = false
}

function closeMenus() {
    showMobileMenu.value = false
    showLanguageMenu.value = false
    showUserMenu.value = false
}

function handleClickOutside(event) {
    const clickedInsideLanguageMenu =
        (languageMenu.value && languageMenu.value.contains(event.target)) ||
        (languageMenuMobile.value && languageMenuMobile.value.contains(event.target))

    const clickedInsideUserMenu =
        (userMenu.value && userMenu.value.contains(event.target)) ||
        (userMenuMobile.value && userMenuMobile.value.contains(event.target))

    if (!clickedInsideLanguageMenu) {
        showLanguageMenu.value = false
    }
    if (!clickedInsideUserMenu) {
        showUserMenu.value = false
    }
}

const LoginView = () => {
    router.visit('/login', {
        method: 'get'
    })
    closeMobileMenu()
}

const RegisterView = () => {
    router.visit('/register', {
        method: 'get'
    })
    closeMobileMenu()
}

const logout = () => {
    router.post(
        '/logout',
        {},
        {
            onSuccess: () => {
                closeMenus()
            }
        }
    )
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})
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
