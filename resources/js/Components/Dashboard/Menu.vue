<template>
    <!-- Backdrop overlay for mobile -->
    <div v-if="drawer && mobile" 
         class="fixed inset-0 bg-black bg-opacity-50 z-40" 
         @click="closeDrawer"></div>

    <!-- Navigation drawer -->
    <nav :class="cn('fixed left-0 top-0 z-50 h-full bg-card border-r border-border transition-all duration-300', 
                    {
                        'translate-x-0': drawer,
                        '-translate-x-full': !drawer && mobile,
                        'w-64': !rail || mobile,
                        'w-16': rail && !mobile
                    })" 
         class="shadow-sm">
         
        <!-- Header section with logo/title -->
        <div :class="cn('p-4 flex items-center', { 'justify-center': rail && !mobile })">
            <Avatar size="sm" :class="cn('bg-orange-500', { 'mr-0': rail && !mobile, 'mr-3': !rail || mobile })">
                <GraduationCap class="w-4 h-4 text-white" />
            </Avatar>
            <div v-if="!rail || mobile" class="text-lg font-medium text-foreground khmer-text">
                ជ្រៃ
            </div>
        </div>

        <hr class="border-border" />

        <nav class="p-2 space-y-1">
            <button @click="navigateCallback('dashboard.index')"
                    :class="cn('w-full flex items-center rounded-lg px-3 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground', {
                        'bg-accent text-accent-foreground': isActive('dashboard'),
                        'text-muted-foreground': !isActive('dashboard'),
                        'justify-center': rail && !mobile
                    })">
                <LayoutDashboard :class="cn('w-4 h-4', { 'mr-0': rail && !mobile, 'mr-3': !rail || mobile })" />
                <span v-if="!rail || mobile" class="khmer-text">ផ្ទាំងគ្រប់គ្រង</span>
                <!-- Tooltip for rail mode -->
                <div v-if="rail && !mobile" class="absolute left-full ml-2 px-2 py-1 bg-popover text-popover-foreground text-sm rounded-md shadow-md opacity-0 hover:opacity-100 transition-opacity pointer-events-none">
                    <span class="khmer-text">ផ្ទាំងគ្រប់គ្រង</span>
                </div>
            </button>

            <button @click="navigateCallback('dashboard.products.index')"
                    :class="cn('w-full flex items-center rounded-lg px-3 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground', {
                        'bg-accent text-accent-foreground': isActive('products'),
                        'text-muted-foreground': !isActive('products'),
                        'justify-center': rail && !mobile
                    })">
                <Package :class="cn('w-4 h-4', { 'mr-0': rail && !mobile, 'mr-3': !rail || mobile })" />
                <span v-if="!rail || mobile" class="khmer-text">ផលិតផល</span>
                <!-- Tooltip for rail mode -->
                <div v-if="rail && !mobile" class="absolute left-full ml-2 px-2 py-1 bg-popover text-popover-foreground text-sm rounded-md shadow-md opacity-0 hover:opacity-100 transition-opacity pointer-events-none">
                    <span class="khmer-text">ផលិតផល</span>
                </div>
            </button>

            <button @click="navigateCallback('dashboard.categories.index')"
                    :class="cn('w-full flex items-center rounded-lg px-3 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground', {
                        'bg-accent text-accent-foreground': isActive('categories'),
                        'text-muted-foreground': !isActive('categories'),
                        'justify-center': rail && !mobile
                    })">
                <Tags :class="cn('w-4 h-4', { 'mr-0': rail && !mobile, 'mr-3': !rail || mobile })" />
                <span v-if="!rail || mobile" class="khmer-text">ប្រភេទ</span>
                <!-- Tooltip for rail mode -->
                <div v-if="rail && !mobile" class="absolute left-full ml-2 px-2 py-1 bg-popover text-popover-foreground text-sm rounded-md shadow-md opacity-0 hover:opacity-100 transition-opacity pointer-events-none">
                    <span class="khmer-text">ប្រភេទ</span>
                </div>
            </button>
        </nav>
    </nav>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { computed, toRefs, onMounted, onUnmounted, ref } from 'vue';
import { cn } from '@/lib/utils';
import Avatar from '@/components/ui/Avatar.vue';
import { GraduationCap, LayoutDashboard, Package, Tags } from 'lucide-vue-next';

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
    } else if (section === 'categories') {
        return url.includes('/categories');
    }

    return false;
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