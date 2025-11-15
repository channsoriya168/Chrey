<template>
    <DashboardLayout>
        <Head title="កែសម្រួលអ្នកប្រើប្រាស់" />

        <div class="max-w-3xl space-y-6">
            <!-- Header -->
            <div>
                <h1 class="khmer-text text-2xl font-bold text-gray-900">កែសម្រួលអ្នកប្រើប្រាស់</h1>
                <p class="khmer-text mt-1 text-sm text-gray-600">កែប្រែព័ត៌មានអ្នកប្រើប្រាស់</p>
            </div>

            <!-- Form Card -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Name Field -->
                    <div>
                        <Label for="name" class="khmer-text">ឈ្មោះ</Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            autofocus
                            class="mt-1"
                            :class="{ 'border-red-500': form.errors.name }"
                        />
                        <div v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <Label for="email" class="khmer-text">អ៊ីម៉ែល</Label>
                        <Input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            class="mt-1"
                            :class="{ 'border-red-500': form.errors.email }"
                        />
                        <div v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <Label for="password" class="khmer-text"
                            >លេខសម្ងាត់ថ្មី (ទុកឱ្យទទេ ប្រសិនបើមិនចង់ផ្លាស់ប្តូរ)</Label
                        >
                        <Input
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="mt-1"
                            :class="{ 'border-red-500': form.errors.password }"
                        />
                        <p class="khmer-text mt-1 text-xs text-gray-500">ទុកចោល ប្រសិនបើមិនចង់ប្តូរលេខសម្ងាត់</p>
                        <div v-if="form.errors.password" class="mt-1 text-sm text-red-600">
                            {{ form.errors.password }}
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <Label for="password_confirmation" class="khmer-text">បញ្ជាក់លេខសម្ងាត់ថ្មី</Label>
                        <Input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            class="mt-1"
                        />
                    </div>

                    <!-- Roles Section -->
                    <div>
                        <Label class="khmer-text mb-3 block">តួនាទី</Label>
                        <div class="space-y-3 rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <div v-for="role in roles" :key="role.id" class="flex items-center">
                                <input
                                    :id="`role-${role.id}`"
                                    v-model="form.roles"
                                    type="checkbox"
                                    :value="role.name"
                                    class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                                />
                                <label :for="`role-${role.id}`" class="ml-3 text-sm font-medium text-gray-700">
                                    {{ role.name }}
                                </label>
                            </div>
                            <div v-if="roles.length === 0" class="khmer-text text-sm text-gray-500">គ្មានតួនាទីទេ</div>
                        </div>
                        <div v-if="form.errors.roles" class="mt-1 text-sm text-red-600">
                            {{ form.errors.roles }}
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 border-t border-gray-200 pt-4">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-6 py-2.5 text-white transition-colors hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            <Save class="h-4 w-4" />
                            <span class="khmer-text">រក្សាទុក</span>
                        </button>
                        <Link
                            :href="route('dashboard.users.index')"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-gray-700 transition-colors hover:bg-gray-50"
                        >
                            <X class="h-4 w-4" />
                            <span class="khmer-text">បោះបង់</span>
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import { Link, useForm, Head } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Save, X } from 'lucide-vue-next'

const props = defineProps({
    user: Object,
    roles: Array,
    userRoles: Array
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    roles: props.userRoles
})

const submit = () => {
    form.put(route('dashboard.users.update', props.user.id))
}
</script>
