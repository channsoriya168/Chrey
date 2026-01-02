<template>
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-200">Role Management</h1>
            <Link
                v-if="$page.props.auth.user.permissions.includes('create roles')"
                :href="route('dashboard.roles.create')"
                class="inline-flex items-center gap-2 rounded-lg bg-purple-600/80 border border-purple-500/30 px-4 py-2.5 text-white transition-colors hover:bg-purple-600 shadow-lg shadow-purple-500/20"
            >
                Create Role
            </Link>
        </div>

        <FlashMessage />

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div v-for="role in roles" :key="role.id" class="rounded-lg bg-slate-800/50 border border-slate-700/50 p-6 shadow">
                <div class="mb-4 flex items-start justify-between">
                    <h3 class="text-xl font-semibold capitalize text-gray-200">{{ role.name }}</h3>
                    <div class="flex gap-2">
                        <Link
                            v-if="$page.props.auth.user.permissions.includes('edit roles')"
                            :href="route('dashboard.roles.edit', role.id)"
                            class="text-sm text-purple-400 hover:text-purple-300"
                        >
                            Edit
                        </Link>
                        <button
                            v-if="$page.props.auth.user.permissions.includes('delete roles') && role.name !== 'admin'"
                            @click="deleteRole(role.id)"
                            class="text-sm text-red-400 hover:text-red-300"
                        >
                            Delete
                        </button>
                    </div>
                </div>

                <div class="border-t border-slate-700/50 pt-4">
                    <h4 class="mb-2 text-sm font-medium text-gray-300">Permissions ({{ role.permissions.length }})</h4>
                    <div class="flex flex-wrap gap-1">
                        <span
                            v-for="permission in role.permissions.slice(0, 6)"
                            :key="permission.id"
                            class="rounded bg-slate-700 px-2 py-1 text-xs text-gray-200"
                        >
                            {{ permission.name }}
                        </span>
                        <span
                            v-if="role.permissions.length > 6"
                            class="rounded bg-slate-700 px-2 py-1 text-xs text-gray-200"
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
import { Link, router } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import FlashMessage from '@/Components/FlashMessage.vue'

defineProps({
    roles: Array
})

const deleteRole = (id) => {
    if (confirm('Are you sure you want to delete this role?')) {
        router.delete(route('dashboard.roles.destroy', id))
    }
}
</script>
