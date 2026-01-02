<template>

    <Head title="កែសម្រួលអ្នកប្រើប្រាស់" />

    <div class="space-y-6 pb-32">
        <!-- Breadcrumb -->
        <DashboardBreadcrumb :items="[
            {
                label: 'ទំពៅរដើម',
                href: route('dashboard.index')
            },
            {
                label: 'អ្នកប្រើប្រាស់',
                href: route('dashboard.users.index')
            },
            { label: 'កែសម្រួល' }
        ]" />

        <!-- Header -->
        <div>
            <h1 class="khmer-text text-2xl font-bold text-white">កែសម្រួលអ្នកប្រើប្រាស់</h1>
            <p class="khmer-text mt-1 text-sm text-slate-400">កែប្រែព័ត៌មានអ្នកប្រើប្រាស់</p>
        </div>

        <!-- Form Card -->
        <UserForm :form="form" :roles="roles" :is-edit="true" submit-text="រក្សាទុក" @submit="submit">
            <template #cancel-button>
                <Link :href="route('dashboard.users.index')"
                    class="inline-flex items-center gap-2 rounded-lg border-2 border-gray-600 bg-transparent px-6 py-2.5 font-medium text-slate-200 transition-all hover:border-blue-400 hover:bg-blue-500/10 active:scale-95">
                    <X class="h-4 w-4" />
                    <span class="khmer-text">បោះបង់</span>
                </Link>
            </template>
        </UserForm>
    </div>
</template>

<script setup>
    import DashboardBreadcrumb from '@/Components/Dashboard/DashboardBreadcrumb.vue'
    import UserForm from '@/Components/Dashboard/UserForm.vue'
    import { Head, Link, useForm } from '@inertiajs/vue3'
    import { X } from 'lucide-vue-next'

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
