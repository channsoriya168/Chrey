<template>
    <!-- Backdrop overlay for mobile -->
    <div v-if="drawer && mobile" class="fixed inset-0 bg-black bg-opacity-50 z-40" @click="closeDrawer"></div>

    <!-- Navigation drawer -->
    <nav :class="cn('fixed left-0 top-0 z-50 h-full bg-white border-r border-gray-200 transition-all duration-300 flex flex-col',
        {
            'translate-x-0': drawer,
            '-translate-x-full': !drawer && mobile,
            'w-64': !rail || mobile,
            'w-16': rail && !mobile
        })" class="shadow-sm">

        <!-- Header section with logo/title -->
        <div :class="cn('p-4 flex items-center border-b border-gray-200', { 'justify-center': rail && !mobile })">
            <div
                :class="cn('w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center', { 'mr-0': rail && !mobile, 'mr-3': !rail || mobile })">
                <GraduationCap class="w-5 h-5 text-white" />
            </div>
            <div v-if="!rail || mobile" class="text-lg font-bold text-gray-900 khmer-text">
                ជ្រៃ
            </div>
        </div>

        <!-- Main Navigation -->
        <div class="flex-1 overflow-y-auto py-2 px-2">
            <div class="space-y-0.5">
                <button @click="navigateCallback('dashboard.index')" :class="cn('w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200', {
                    'bg-gray-900 text-white': isActive('dashboard'),
                    'text-gray-700 hover:bg-gray-100': !isActive('dashboard'),
                    'justify-center px-0': rail && !mobile
                })">
                    <LayoutDashboard class="w-5 h-5" />
                    <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">ផ្ទាំងគ្រប់គ្រង</span>
                </button>

                <button @click="navigateCallback('dashboard.products.index')" :class="cn('w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200', {
                    'bg-gray-900 text-white': isActive('products'),
                    'text-gray-700 hover:bg-gray-100': !isActive('products'),
                    'justify-center px-0': rail && !mobile
                })">
                    <Package class="w-5 h-5" />
                    <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">ផលិតផល</span>
                </button>

                <button @click="navigateCallback('dashboard.categories.index')" :class="cn('w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200', {
                    'bg-gray-900 text-white': isActive('categories'),
                    'text-gray-700 hover:bg-gray-100': !isActive('categories'),
                    'justify-center px-0': rail && !mobile
                })">
                    <Tags class="w-5 h-5" />
                    <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">ប្រភេទ</span>
                </button>

                <button @click="navigateCallback('dashboard.users.index')" :class="cn('w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200', {
                    'bg-gray-900 text-white': isActive('users'),
                    'text-gray-700 hover:bg-gray-100': !isActive('users'),
                    'justify-center px-0': rail && !mobile
                })">
                    <Users class="w-5 h-5" />
                    <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">គ្រប់គ្រងអ្នកប្រើប្រាស់</span>
                </button>

                <button @click="navigateCallback('dashboard.roles.index')" :class="cn('w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200', {
                    'bg-gray-900 text-white': isActive('roles'),
                    'text-gray-700 hover:bg-gray-100': !isActive('roles'),
                    'justify-center px-0': rail && !mobile
                })">
                    <Shield class="w-5 h-5" />
                    <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">គ្រប់គ្រងតួនាទី</span>
                </button>
            </div>
        </div>

        <!-- Bottom Actions -->
        <div class="border-t border-gray-200 p-2 space-y-0.5">
            <button @click="navigateToFrontend"
                    :class="cn('w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 text-gray-700 hover:bg-gray-100', {
                        'justify-center px-0': rail && !mobile
                    })">
                <Home class="w-5 h-5" />
                <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">ទៅទំព័រមុខ</span>
            </button>

            <button @click="handleLogout"
                    :class="cn('w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 text-gray-700 hover:bg-gray-100', {
                        'justify-center px-0': rail && !mobile
                    })">
                <LogOut class="w-5 h-5" />
                <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">ចាកចេញ</span>
            </button>
        </div>
    </nav>
</template>

<script setup>
    import { router, usePage } from '@inertiajs/vue3';
    import { computed, toRefs, onMounted, onUnmounted, ref } from 'vue';
    import { cn } from '@/lib/utils';
    import Avatar from '@/components/ui/Avatar.vue';
    import { GraduationCap, LayoutDashboard, Package, Tags, Users, Shield, Home, LogOut } from 'lucide-vue-next';

    const props = defineProps({
        modelValue: {
            type: Boolean,
            default: true
        },
        rail: {
            type: Boolean,
            default: false
        }
    });

    const emit = defineEmits(['update:modelValue']);

    const { modelValue, rail } = toRefs(props);

    const windowWidth = ref(window.innerWidth);
    const mobile = computed(() => windowWidth.value < 768);

    const drawer = computed({
        get: () => modelValue.value,
        set: (value) => emit('update:modelValue', value)
    });

    const page = usePage();
    const currentRoute = computed(() => page.url);

    const closeDrawer = () => {
        if (mobile.value) {
            drawer.value = false;
        }
    };

    const navigateCallback = (r) => {
        router.get(route(r));
        if (mobile.value) {
            drawer.value = false;
        }
    };

    const isActive = (section) => {
        const url = currentRoute.value;

        if (section === 'dashboard') {
            return url === '/dashboard' || url === '/dashboard/';
        } else if (section === 'products') {
            return url.includes('/products');
        } else if (section === 'products') {
            return url.includes('/products');
        } else if (section === 'categories') {
            return url.includes('/categories');
        } else if (section === 'users') {
            return url.includes('/users');
        } else if (section === 'roles') {
            return url.includes('/roles');
        }

        return false;
    };

    const navigateToFrontend = () => {
        router.get(route('home'));
        if (mobile.value) {
            drawer.value = false;
        }
    };

    const handleLogout = () => {
        router.post(route('logout'));
    };

    const handleResize = () => {
        windowWidth.value = window.innerWidth;
    };

    onMounted(() => {
        window.addEventListener('resize', handleResize);
    });

    onUnmounted(() => {
        window.removeEventListener('resize', handleResize);
    });
</script>