<template>

    <Head title="បង្កើតអ្នកប្រើប្រាស់ថ្មី" />

    <div class="space-y-6">
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
            { label: 'បង្កើតថ្មី' }
        ]" />

        <!-- Header -->
        <div>
            <h1 class="khmer-text text-2xl font-bold text-white">បង្កើតអ្នកប្រើប្រាស់ថ្មី</h1>
            <p class="khmer-text mt-1 text-sm text-slate-400">បំពេញព័ត៌មានដើម្បីបង្កើតអ្នកប្រើប្រាស់ថ្មី</p>
        </div>

        <!-- Form Card -->
        <UserForm :form="form" :roles="roles" :is-edit="false" submit-text="បង្កើត" @submit="submit">
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
        roles: Array
    })

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        roles: []
    })

    const submit = () => {
        form.post(route('dashboard.users.store'))
    }
</script>
