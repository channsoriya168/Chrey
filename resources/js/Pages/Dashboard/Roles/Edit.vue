<template>
    <Head title="កែសម្រួលតួនាទី" />

    <div class="space-y-6">
        <!-- Breadcrumb -->
        <DashboardBreadcrumb :items="[
            {
                label: 'ទំពៅរដើម',
                href: route('dashboard.index')
            },
            {
                label: 'តួនាទី',
                href: route('dashboard.roles.index')
            },
            { label: 'កែសម្រួល' }
        ]" />

        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold text-white">កែសម្រួលតួនាទី</h1>
            <p class="mt-1 text-sm text-slate-400">កែប្រែព័ត៌មានតួនាទី និងសិទ្ធិ</p>
        </div>

        <!-- Form Card -->
        <div class="max-w-4xl rounded-xl border border-slate-700/50 bg-slate-800/80 backdrop-blur-sm p-8 shadow-lg shadow-slate-900/50">
                <form @submit.prevent="submit">
                    <div class="mb-6">
                        <Label for="name" class="text-gray-200">Role Name</Label>
                        <Input id="name" v-model="form.name" type="text" required autofocus
                            placeholder="e.g., editor, manager"
                            class="mt-1 border-slate-600 bg-slate-700/50 text-gray-200 placeholder-gray-400 focus:border-purple-500 focus:ring-purple-500/20" />
                        <div v-if="form.errors.name" class="mt-1 text-sm text-red-400">
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="mb-4 flex items-center justify-between">
                            <Label class="text-gray-200">Permissions</Label>
                            <button type="button" @click="toggleAllPermissions"
                                class="rounded-lg border border-purple-500/30 bg-purple-600/20 px-3 py-1.5 text-sm text-purple-300 hover:bg-purple-600/30 transition-colors">
                                {{ allPermissionsSelected ? 'Uncheck All' : 'Check All' }}
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div v-for="(groupPermissions, group) in permissions" :key="group"
                                class="rounded-lg border border-slate-700/50 bg-slate-900/30 p-4">
                                <div class="mb-3 flex items-center justify-between">
                                    <h3 class="font-medium text-gray-300 capitalize">{{ group }}</h3>
                                    <button type="button" @click="toggleGroupPermissions(group)"
                                        class="text-xs text-purple-400 hover:text-purple-300 transition-colors">
                                        {{ isGroupSelected(group) ? 'Uncheck Group' : 'Check Group' }}
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3">
                                    <div v-for="permission in groupPermissions" :key="permission.id"
                                        class="flex items-center">
                                        <input :id="`permission-${permission.id}`" v-model="form.permissions"
                                            type="checkbox" :value="permission.name"
                                            class="rounded border-slate-600 bg-slate-700 text-purple-600 focus:ring-purple-500/20" />
                                        <label :for="`permission-${permission.id}`" class="ml-2 text-sm text-gray-300">
                                            {{ permission.name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.errors.permissions" class="mt-1 text-sm text-red-400">
                            {{ form.errors.permissions }}
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" :disabled="form.processing"
                            class="rounded-lg bg-purple-600/80 border border-purple-500/30 px-4 py-2 text-white shadow-lg shadow-purple-500/20 hover:bg-purple-600 disabled:opacity-50">
                            Update Role
                        </button>
                        <Link :href="route('dashboard.roles.index')"
                            class="rounded-lg border border-slate-600 bg-slate-700/50 px-4 py-2 text-gray-200 hover:bg-slate-700">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
</template>

<script setup>
    import { Input } from '@/Components/ui/input'
    import { Label } from '@/Components/ui/label'
    import DashboardBreadcrumb from '@/Components/Dashboard/DashboardBreadcrumb.vue'
    import { Head, Link, useForm } from '@inertiajs/vue3'
    import { computed } from 'vue'

    const props = defineProps({
        role: Object,
        permissions: Object,
        rolePermissions: Array
    })

    const form = useForm({
        name: props.role.name,
        permissions: props.rolePermissions
    })

    // Get all permission names as a flat array
    const allPermissionNames = computed(() => {
        return Object.values(props.permissions).flat().map(p => p.name)
    })

    // Check if all permissions are selected
    const allPermissionsSelected = computed(() => {
        return allPermissionNames.value.length > 0 &&
               form.permissions.length === allPermissionNames.value.length
    })

    // Toggle all permissions
    const toggleAllPermissions = () => {
        if (allPermissionsSelected.value) {
            form.permissions = []
        } else {
            form.permissions = [...allPermissionNames.value]
        }
    }

    // Check if all permissions in a group are selected
    const isGroupSelected = (group) => {
        const groupPermissionNames = props.permissions[group].map(p => p.name)
        return groupPermissionNames.every(name => form.permissions.includes(name))
    }

    // Toggle all permissions in a specific group
    const toggleGroupPermissions = (group) => {
        const groupPermissionNames = props.permissions[group].map(p => p.name)

        if (isGroupSelected(group)) {
            // Remove all group permissions
            form.permissions = form.permissions.filter(
                name => !groupPermissionNames.includes(name)
            )
        } else {
            // Add all group permissions
            const newPermissions = [...form.permissions]
            groupPermissionNames.forEach(name => {
                if (!newPermissions.includes(name)) {
                    newPermissions.push(name)
                }
            })
            form.permissions = newPermissions
        }
    }

    const submit = () => {
        form.put(route('dashboard.roles.update', props.role.id))
    }
</script>
