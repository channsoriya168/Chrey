<template>
    <!-- Backdrop overlay for mobile -->
    <div v-if="drawer && mobile" class="bg-opacity-50 fixed inset-0 z-40 bg-black" @click="closeDrawer"></div>

    <!-- Navigation drawer -->
    <nav :class="cn(
        'fixed top-0 left-0 z-50 flex h-full flex-col border-r border-gray-200 bg-white transition-all duration-300',
        {
            'translate-x-0': drawer,
            '-translate-x-full': !drawer && mobile,
            'w-64': !rail || mobile,
            'w-16': rail && !mobile
        }
    )
        " class="shadow-sm">
        <!-- Header section with logo/title -->
        <div :class="cn('flex items-center border-b border-gray-200 p-4', { 'justify-center': rail && !mobile })">
            <div :class="cn('flex h-10 w-10 items-center justify-center rounded-lg bg-amber-800', {
                'mr-0': rail && !mobile,
                'mr-3': !rail || mobile
            })
                ">
                <GraduationCap class="h-5 w-5 text-white" />
            </div>
            <div v-if="!rail || mobile" class="khmer-text text-lg font-bold text-amber-800">ជ្រៃ</div>
        </div>

        <!-- Main Navigation -->
        <div class="flex-1 overflow-y-auto px-2 py-2">
            <div class="space-y-0.5">
                <button @click="navigateCallback('dashboard.index')" :class="cn(
                    'flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200',
                    {
                        'bg-amber-800 text-white': isActive('dashboard'),
                        'text-gray-700 hover:bg-gray-100': !isActive('dashboard'),
                        'justify-center px-0': rail && !mobile
                    }
                )
                    ">
                    <LayoutDashboard class="h-5 w-5" />
                    <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">ផ្ទាំងគ្រប់គ្រង</span>
                </button>
                <!-- products -->

                <button @click="navigateCallback('dashboard.products.index')" :class="cn(
                    'flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200',
                    {
                        'bg-amber-800 text-white': isActive('products'),
                        'text-gray-700 hover:bg-gray-100': !isActive('products'),
                        'justify-center px-0': rail && !mobile
                    }
                )
                    ">
                    <Package class="h-5 w-5" />
                    <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">ផលិតផល</span>
                </button>

                <button @click="navigateCallback('dashboard.orders.index')" :class="cn(
                    'flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200',
                    {
                        'bg-amber-800 text-white': isActive('orders'),
                        'text-gray-700 hover:bg-gray-100': !isActive('orders'),
                        'justify-center px-0': rail && !mobile
                    }
                )
                    ">
                    <ShoppingBag class="h-5 w-5" />
                    <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">ការបញ្ជាទិញ</span>
                </button>

                <button @click="navigateCallback('dashboard.users.index')" :class="cn(
                    'flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200',
                    {
                        'bg-amber-800 text-white': isActive('users'),
                        'text-gray-700 hover:bg-gray-100': !isActive('users'),
                        'justify-center px-0': rail && !mobile
                    }
                )
                    ">
                    <Users class="h-5 w-5" />
                    <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">គ្រប់គ្រងអ្នកប្រើប្រាស់</span>
                </button>

                <button @click="navigateCallback('dashboard.roles.index')" :class="cn(
                    'flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200',
                    {
                        'bg-amber-800 text-white': isActive('roles'),
                        'text-gray-700 hover:bg-gray-100': !isActive('roles'),
                        'justify-center px-0': rail && !mobile
                    }
                )
                    ">
                    <Shield class="h-5 w-5" />
                    <span v-if="!rail || mobile" class="khmer-text flex-1 text-left">គ្រប់គ្រងតួនាទី</span>
                </button>
            </div>
        </div>


    </nav>
</template>

<script setup>
    import { router, usePage } from '@inertiajs/vue3'
    import { computed, toRefs, onMounted, onUnmounted, ref } from 'vue'
    import { cn } from '@/lib/utils'
    import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
    import { GraduationCap, LayoutDashboard, Package, Users, Shield, Home, LogOut, ShoppingBag } from 'lucide-vue-next'

    const props = defineProps({
        modelValue: {
            type: Boolean,
            default: true
        },
        rail: {
            type: Boolean,
            default: false
        }
    })

    const emit = defineEmits(['update:modelValue'])

    const { modelValue, rail } = toRefs(props)

    const windowWidth = ref(window.innerWidth)
    const mobile = computed(() => windowWidth.value < 768)

    const drawer = computed({
        get: () => modelValue.value,
        set: (value) => emit('update:modelValue', value)
    })

    const page = usePage()
    const currentRoute = computed(() => page.url)

    const closeDrawer = () => {
        if (mobile.value) {
            drawer.value = false
        }
    }

    const navigateCallback = (r) => {
        router.get(route(r))
        if (mobile.value) {
            drawer.value = false
        }
    }

    const isActive = (section) => {
        const url = currentRoute.value

        if (section === 'dashboard') {
            return url === '/dashboard' || url === '/dashboard/'
        } else if (section === 'products') {
            return url.includes('/products')
        } else if (section === 'orders') {
            return url.includes('/orders')
        } else if (section === 'users') {
            return url.includes('/users')
        } else if (section === 'roles') {
            return url.includes('/roles')
        }

        return false
    }

    const navigateToFrontend = () => {
        router.get(route('home'))
        if (mobile.value) {
            drawer.value = false
        }
    }



    const handleResize = () => {
        windowWidth.value = window.innerWidth
    }

    onMounted(() => {
        window.addEventListener('resize', handleResize)
    })

    onUnmounted(() => {
        window.removeEventListener('resize', handleResize)
    })
</script>
