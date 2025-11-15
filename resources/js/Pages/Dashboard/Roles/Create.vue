<template>
    <DashboardLayout>
        <div class="p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Create Role</h1>
            </div>

            <div class="max-w-4xl rounded-lg bg-white p-6 shadow">
                <form @submit.prevent="submit">
                    <div class="mb-6">
                        <Label for="name">Role Name</Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            autofocus
                            placeholder="e.g., editor, manager"
                        />
                        <div v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <div class="mb-6">
                        <Label class="mb-4 block">Permissions</Label>
                        <div class="space-y-4">
                            <div v-for="(groupPermissions, group) in permissions" :key="group">
                                <h3 class="mb-2 font-medium text-gray-900 capitalize">{{ group }}</h3>
                                <div class="grid grid-cols-1 gap-2 pl-4 md:grid-cols-2 lg:grid-cols-3">
                                    <div
                                        v-for="permission in groupPermissions"
                                        :key="permission.id"
                                        class="flex items-center"
                                    >
                                        <input
                                            :id="`permission-${permission.id}`"
                                            v-model="form.permissions"
                                            type="checkbox"
                                            :value="permission.name"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        />
                                        <label :for="`permission-${permission.id}`" class="ml-2 text-sm text-gray-700">
                                            {{ permission.name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.errors.permissions" class="mt-1 text-sm text-red-600">
                            {{ form.errors.permissions }}
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 disabled:opacity-50"
                        >
                            Create Role
                        </button>
                        <Link
                            :href="route('dashboard.roles.index')"
                            class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400"
                        >
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

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
