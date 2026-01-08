<template>
    <Head title="គ្រប់គ្រងតួនាទី" />

    <div class="space-y-6">
        <!-- Breadcrumb -->
        <DashboardBreadcrumb :items="[
            {
                label: 'ទំពៅរដើម',
                href: route('dashboard.index')
            },
            { label: 'តួនាទី' }
        ]" />

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">គ្រប់គ្រងតួនាទី</h1>
                <p class="mt-1 text-sm text-slate-400">គ្រប់គ្រង និងកែប្រែតួនាទីក្នុងប្រព័ន្ធ</p>
            </div>
            <Link
                v-if="$page.props.auth.user.permissions.includes('create roles')"
                :href="route('dashboard.roles.create')"
                class="inline-flex items-center gap-2 rounded-lg bg-purple-600/80 border border-purple-500/30 px-4 py-2.5 text-white transition-colors hover:bg-purple-600 shadow-lg shadow-purple-500/20"
            >
                <Plus class="h-4 w-4" />
                <span>បង្កើតតួនាទីថ្មី</span>
            </Link>
        </div>

        <FlashMessage />

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div v-for="role in roles" :key="role.id"
                class="group rounded-xl bg-slate-800/80 backdrop-blur-sm border border-slate-700/50 p-6 shadow-lg shadow-slate-900/50 hover:border-purple-500/30 transition-all duration-300">
                <div class="mb-4 flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="rounded-lg bg-purple-500/20 p-2.5 border border-purple-500/30">
                            <Shield class="h-5 w-5 text-purple-400" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold capitalize text-white">{{ role.name }}</h3>
                            <p class="text-xs text-gray-400">{{ role.permissions.length }} permissions</p>
                        </div>
                    </div>
                    <div class="flex gap-1">
                        <Link
                            v-if="$page.props.auth.user.permissions.includes('edit roles')"
                            :href="route('dashboard.roles.edit', role.id)"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-amber-400 transition-colors hover:bg-amber-500/10"
                            title="កែសម្រួល"
                        >
                            <Edit class="h-4 w-4" />
                        </Link>
                        <button
                            v-if="$page.props.auth.user.permissions.includes('delete roles') && role.name !== 'admin'"
                            @click="deleteRole(role.id)"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-red-400 transition-colors hover:bg-red-500/10"
                            title="លុប"
                        >
                            <Trash2 class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <div class="border-t border-slate-700/50 pt-4">
                    <h4 class="mb-3 text-xs font-medium uppercase tracking-wide text-gray-400">Permissions</h4>
                    <div class="flex flex-wrap gap-1.5">
                        <span
                            v-for="permission in role.permissions.slice(0, 6)"
                            :key="permission.id"
                            class="inline-flex items-center rounded-md bg-slate-700/50 px-2.5 py-1 text-xs text-gray-300 border border-slate-600/50"
                        >
                            {{ permission.name }}
                        </span>
                        <span
                            v-if="role.permissions.length > 6"
                            class="inline-flex items-center rounded-md bg-purple-500/20 px-2.5 py-1 text-xs text-purple-300 border border-purple-500/30"
                        >
                            +{{ role.permissions.length - 6 }} more
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import DashboardBreadcrumb from '@/Components/Dashboard/DashboardBreadcrumb.vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { Plus, Shield, Edit, Trash2 } from 'lucide-vue-next'

defineProps({
    roles: Array
})

const deleteRole = (id) => {
    if (confirm('តើអ្នកប្រាកដថាចង់លុបតួនាទីនេះ?')) {
        router.delete(route('dashboard.roles.destroy', id))
    }
}
</script>
