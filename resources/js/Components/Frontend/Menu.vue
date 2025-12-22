<template>
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-lg border-b border-gray-200/50 shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <!-- Logo/Brand -->
                <div class="flex flex-shrink-0 items-center">
                    <Link href="/" class="group flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 shadow-lg transition-transform duration-300 group-hover:scale-110 group-hover:shadow-xl">
                            <span class="text-xl font-bold text-white">C</span>
                        </div>
                        <span
                            class="text-2xl font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent transition-all duration-300 group-hover:scale-105">
                            Chrey
                        </span>
                    </Link>
                </div>

                <!-- Right Side Actions -->
                <div class="hidden items-center space-x-3 md:flex">
                    <!-- Language Switcher -->
                    <div class="relative" ref="languageMenu">
                        <button @click="showLanguageMenu = !showLanguageMenu"
                            class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-gray-700 transition-all duration-200 hover:bg-orange-50 hover:text-orange-600 hover:shadow-sm">
                            <Icon :icon="currentLanguage.flag" class="w-5 h-5" />
                            <span class="text-sm font-semibold">{{ currentLanguage.name }}</span>
                            <svg class="h-4 w-4 transition-transform duration-200"
                                :class="{ 'rotate-180': showLanguageMenu }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div v-if="showLanguageMenu"
                            class="absolute right-0 z-10 mt-3 w-52 rounded-2xl bg-white py-2 shadow-2xl ring-1 ring-gray-200 backdrop-blur-sm">
                            <button v-for="lang in languages" :key="lang.code" @click="handleLanguageSwitch(lang.code)"
                                :class="[
                                    'flex w-full items-center gap-3 px-4 py-3 text-left text-sm transition-all duration-150 rounded-xl mx-1',
                                    locale === lang.code
                                        ? 'bg-gradient-to-r from-orange-50 to-orange-100 text-orange-600 font-semibold'
                                        : 'text-gray-700 hover:bg-gray-50'
                                ]">
                                <Icon :icon="lang.flag" class="w-5 h-5" />
                                <span>{{ lang.fullName }}</span>
                                <svg v-if="locale === lang.code" class="ml-auto h-4 w-4 text-orange-600"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Cart Button -->
                    <Link href="/cart" :class="[
                        'relative flex items-center justify-center rounded-xl p-3 text-gray-600 transition-all duration-200 hover:bg-orange-50 hover:text-orange-600 hover:shadow-md',
                        page.url === '/cart' ? 'bg-gradient-to-r from-orange-50 to-orange-100 text-orange-600 shadow-sm' : ''
                    ]" :title="t('nav.cart')">
                        <Icon icon="heroicons:shopping-cart" class="h-6 w-6" />
                        <span v-if="cartCount > 0"
                            class="absolute -top-1.5 -right-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-r from-red-500 to-orange-500 text-xs font-bold text-white ring-2 ring-white shadow-lg">
                            {{ cartCount > 99 ? '99+' : cartCount }}
                        </span>
                    </Link>

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-2">
                        <div v-if="authUser">
                            <!-- User dropdown -->
                            <div class="relative" ref="userMenu">
                                <button @click="toggleUserMenu"
                                    class="flex items-center justify-center rounded-xl p-3 text-gray-600 transition-all duration-200 hover:bg-orange-50 hover:text-orange-600 hover:shadow-md"
                                    :title="authUser ? authUser.name : ''">
                                    <Icon icon="heroicons:user-circle-solid" class="h-6 w-6" />
                                </button>

                                <div v-if="showUserMenu"
                                    class="absolute right-0 z-10 mt-3 w-56 rounded-2xl bg-white py-2 shadow-2xl ring-1 ring-gray-200">
                                    <!-- My Orders link -->
                                    <Link :href="route('orders.index')"
                                        v-if="authUser && !authUser.roles.includes('admin')"
                                        class="flex items-center gap-3 px-4 py-3 mx-1 rounded-xl text-sm font-medium text-gray-700 transition-all duration-150 hover:bg-orange-50 hover:text-orange-600">
                                        <Icon icon="heroicons:shopping-bag" class="h-5 w-5" />
                                        {{ t('nav.auth.myOrders') }}
                                    </Link>
                                    <!-- Admin link -->
                                    <Link v-if="authUser && authUser.roles && authUser.roles.includes('admin')"
                                        :href="route('dashboard.index')"
                                        class="flex items-center gap-3 px-4 py-3 mx-1 rounded-xl text-sm font-medium text-gray-700 transition-all duration-150 hover:bg-orange-50 hover:text-orange-600">
                                        <Icon icon="heroicons:chart-bar" class="h-5 w-5" />
                                        {{ t('nav.auth.dashboard') }}
                                    </Link>
                                    <div class="my-2 h-px bg-gray-100"></div>
                                    <button @click="logout"
                                        class="flex w-full items-center gap-3 px-4 py-3 mx-1 rounded-xl text-left text-sm font-medium text-red-600 transition-all duration-150 hover:bg-red-50">
                                        <Icon icon="heroicons:arrow-left-on-rectangle" class="h-5 w-5" />
                                        {{ t('nav.auth.logout') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-else>
                            <button @click="LoginView"
                                class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 px-5 py-2.5 font-semibold text-white shadow-md transition-all duration-200 hover:scale-105 hover:shadow-lg"
                                :title="t('nav.auth.login')">
                                <Icon icon="heroicons:user-circle-solid" class="h-5 w-5" />
                                <span class="text-sm">Login</span>
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Mobile menu button -->
                <div class="flex items-center space-x-1.5 md:hidden">
                    <!-- Language Switcher Mobile -->
                    <div class="relative" ref="languageMenuMobile">
                        <button @click="showLanguageMenu = !showLanguageMenu"
                            class="flex items-center justify-center rounded-full p-2 text-gray-600 transition-all duration-200 hover:bg-gray-100/80">
                            <Icon :icon="currentLanguage.flag" class="w-6 h-6" />
                        </button>
                    </div>

                    <!-- Cart Button Mobile -->
                    <Link href="/cart" :class="[
                        'relative flex items-center justify-center rounded-full p-2 text-gray-600 transition-all duration-200 hover:bg-gray-100/80',
                        page.url === '/cart' ? 'bg-orange-50 text-orange-500' : ''
                    ]">
                        <Icon icon="heroicons:shopping-cart" class="h-7 w-7" />
                        <span v-if="cartCount > 0"
                            class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-orange-500 text-xs font-semibold text-white ring-2 ring-white">
                            {{ cartCount > 99 ? '99+' : cartCount }}
                        </span>
                    </Link>

                    <!-- Auth Button Mobile -->
                    <div v-if="authUser" class="relative" ref="userMenuMobile">
                        <button @click="toggleUserMenu"
                            class="flex items-center justify-center rounded-full p-2 text-gray-600 transition-all duration-200 hover:text-orange-500">
                            <Icon icon="heroicons:user-circle-solid" class="h-7 w-7" />
                        </button>
                    </div>
                    <div v-else>
                        <button @click="LoginView"
                            class="flex items-center justify-center rounded-full p-2 text-gray-600 transition-all duration-200 hover:text-orange-500">
                            <Icon icon="heroicons:user-circle-solid" class="h-7 w-7" />
                        </button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Language Dropdown for Mobile -->
        <div v-if="showLanguageMenu"
            class="absolute right-4 top-20 z-50 mt-2 w-52 rounded-xl bg-white py-2 shadow-xl ring-1 ring-gray-900/5 md:hidden">
            <button v-for="lang in languages" :key="lang.code" @click="handleLanguageSwitch(lang.code)" :class="[
                'flex w-full items-center gap-3 px-4 py-3 text-left text-sm transition-all duration-150',
                locale === lang.code ? 'bg-gray-100 text-gray-900 font-semibold' : 'text-gray-700 hover:bg-gray-50'
            ]">
                <Icon :icon="lang.flag" class="w-5 h-5" />
                <span>{{ lang.fullName }}</span>
                <svg v-if="locale === lang.code" class="ml-auto h-4 w-4 text-gray-900" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <!-- User Menu Dropdown for Mobile -->
        <div v-if="showUserMenu && authUser"
            class="absolute right-4 top-20 z-50 mt-2 w-52 rounded-xl bg-white py-2 shadow-xl ring-1 ring-gray-900/5 md:hidden">
            <Link :href="route('orders.index')" @click="closeMenus"
                v-if="authUser && authUser.roles && !authUser.roles.includes('admin')"
                class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 transition-all duration-150 hover:bg-gray-50">
                <Icon icon="heroicons:shopping-bag" class="h-5 w-5" />
                {{ t('nav.auth.myOrders') }}
            </Link>
            <Link v-if="authUser && authUser.roles && authUser.roles.includes('admin')" :href="route('dashboard.index')"
                @click="closeMenus"
                class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 transition-all duration-150 hover:bg-gray-50">
                <Icon icon="heroicons:chart-bar" class="h-5 w-5" />
                {{ t('nav.auth.dashboard') }}
            </Link>
            <div class="my-1 h-px bg-gray-100"></div>
            <button @click="logout"
                class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm text-red-600 transition-all duration-150 hover:bg-red-50">
                <Icon icon="heroicons:arrow-left-on-rectangle" class="h-5 w-5" />
                {{ t('nav.auth.logout') }}
            </button>
        </div>
    </nav>
</template>
<script setup>
    import { getCurrentLanguage, languages } from '@/composables/useLanguages'
    import { Icon } from '@iconify/vue'
    import { Link, router, usePage } from '@inertiajs/vue3'
    import { computed, onMounted, onUnmounted, ref } from 'vue'
    import { useI18n } from 'vue-i18n'

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
    const cartCount = ref(0)

    // Fetch cart count
    const fetchCartCount = async () => {
        if (!authUser.value) {
            cartCount.value = 0
            return
        }

        try {
            const response = await fetch('/api/cart/items')
            const data = await response.json()
            cartCount.value = data.count || 0
        } catch (error) {
            console.error('Failed to fetch cart count:', error)
            cartCount.value = 0
        }
    }

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
        fetchCartCount()

        // Listen for Inertia navigation to refresh cart count
        router.on('success', () => {
            fetchCartCount()
        })
    })

    onUnmounted(() => {
        document.removeEventListener('click', handleClickOutside)
    })
</script>

<style scoped>
    .nav-link {
        color: #374151;
        padding: 0.625rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        position: relative;
    }

    .nav-link:hover {
        color: #111827;
        background-color: rgba(249, 250, 251, 0.8);
        transform: translateY(-1px);
    }

    .nav-link.active {
        color: #111827;
        background-color: rgba(243, 244, 246, 0.9);
        font-weight: 600;
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: 2px;
        background: linear-gradient(to right, transparent, #111827, transparent);
        border-radius: 9999px;
    }

    .mobile-nav-link {
        display: block;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        font-size: 1rem;
        font-weight: 500;
        color: #374151;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
    }

    .mobile-nav-link:hover {
        color: #111827;
        background-color: rgba(249, 250, 251, 0.8);
    }

    .mobile-nav-link.active {
        color: #111827;
        background-color: rgba(243, 244, 246, 0.9);
        font-weight: 600;
        border-left: 3px solid #111827;
    }

    /* Custom scrollbar for mobile menu */
    .mobile-menu::-webkit-scrollbar {
        width: 6px;
    }

    .mobile-menu::-webkit-scrollbar-track {
        background: #f3f4f6;
    }

    .mobile-menu::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

    .mobile-menu::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>
