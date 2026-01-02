<template>
    <DashboardLayout>
        <div class="p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-200">Create Role</h1>
            </div>

            <div class="max-w-4xl rounded-lg border border-slate-700/50 bg-slate-800/80 backdrop-blur-sm p-6 shadow-lg shadow-slate-900/50">
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
                        <Label class="mb-4 block text-gray-200">Permissions</Label>
                        <div class="space-y-4">
                            <div v-for="(groupPermissions, group) in permissions" :key="group">
                                <h3 class="mb-2 font-medium text-gray-300 capitalize">{{ group }}</h3>
                                <div class="grid grid-cols-1 gap-2 pl-4 md:grid-cols-2 lg:grid-cols-3">
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
                            Create Role
                        </button>
                        <Link :href="route('dashboard.roles.index')"
                            class="rounded-lg border border-slate-600 bg-slate-700/50 px-4 py-2 text-gray-200 hover:bg-slate-700">
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
    import { Input } from '@/Components/ui/input'
    import { Label } from '@/Components/ui/label'
    import DashboardLayout from '@/Layouts/DashboardLayout.vue'
    import { Link, useForm } from '@inertiajs/vue3'

    const props = defineProps({
        permissions: Object
    })

    const form = useForm({
        name: '',
        permissions: []
    })

    const submit = () => {
        form.post(route('dashboard.roles.store'))
    }
</script>
