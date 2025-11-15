<template>
        <Head title="គ្រប់គ្រងអ្នកប្រើប្រាស់" />

        <div class="space-y-6">
            <!-- Breadcrumb -->
            <Breadcrumb>
                <BreadcrumbList>
                    <BreadcrumbItem>
                        <BreadcrumbLink :href="route('dashboard.index')">
                            <span class="khmer-text">ទំព័រដើម</span>
                        </BreadcrumbLink>
                    </BreadcrumbItem>
                    <BreadcrumbSeparator />
                    <BreadcrumbItem>
                        <BreadcrumbPage class="khmer-text">អ្នកប្រើប្រាស់</BreadcrumbPage>
                    </BreadcrumbItem>
                </BreadcrumbList>
            </Breadcrumb>

            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="khmer-text text-2xl font-bold text-gray-900">គ្រប់គ្រងអ្នកប្រើប្រាស់</h1>
                    <p class="khmer-text mt-1 text-sm text-gray-600">គ្រប់គ្រង និងកែប្រែអ្នកប្រើប្រាស់ក្នុងប្រព័ន្ធ</p>
                </div>
                <Link
                    v-if="$page.props.auth.user.permissions.includes('create users')"
                    :href="route('dashboard.users.create')"
                    class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-white transition-colors hover:bg-gray-800"
                >
                    <UserPlus class="h-4 w-4" />
                    <span class="khmer-text">បង្កើតអ្នកប្រើថ្មី</span>
                </Link>
            </div>

            <!-- Table Card -->
            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="khmer-text px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase"
                                >
                                    ឈ្មោះ
                                </th>
                                <th
                                    scope="col"
                                    class="khmer-text px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase"
                                >
                                    អ៊ីម៉ែល
                                </th>
                                <th
                                    scope="col"
                                    class="khmer-text px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase"
                                >
                                    តួនាទី
                                </th>
                                <th
                                    scope="col"
                                    class="khmer-text px-6 py-3 text-right text-xs font-medium tracking-wider text-gray-500 uppercase"
                                >
                                    សកម្មភាព
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-if="users.data.length === 0">
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <Users class="mb-2 h-12 w-12" />
                                        <p class="khmer-text">គ្មានអ្នកប្រើប្រាស់</p>
                                    </div>
                                </td>
                            </tr>
                            <tr v-for="user in users.data" :key="user.id" class="transition-colors hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-900"
                                        >
                                            <span class="text-sm font-semibold text-white">{{
                                                user.name.charAt(0).toUpperCase()
                                            }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">{{ user.email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        <span
                                            v-for="role in user.roles"
                                            :key="role.id"
                                            class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800"
                                        >
                                            {{ role.name }}
                                        </span>
                                        <span v-if="user.roles.length === 0" class="khmer-text text-xs text-gray-400"
                                            >គ្មានតួនាទី</span
                                        >
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium whitespace-nowrap">
                                    <div class="flex justify-end gap-2">
                                        <Link
                                            v-if="$page.props.auth.user.permissions.includes('edit users')"
                                            :href="route('dashboard.users.edit', user.id)"
                                            class="inline-flex items-center gap-1 rounded px-3 py-1.5 text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900"
                                        >
                                            <Edit class="h-4 w-4" />
                                            <span class="khmer-text">កែសម្រួល</span>
                                        </Link>
                                        <button
                                            v-if="
                                                $page.props.auth.user.permissions.includes('delete users') &&
                                                user.id !== $page.props.auth.user.id
                                            "
                                            @click="deleteUser(user.id)"
                                            class="inline-flex items-center gap-1 rounded px-3 py-1.5 text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                            <span class="khmer-text">លុប</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="users.links.length > 3" class="flex justify-center gap-1">
                <Link
                    v-for="(link, index) in users.links"
                    :key="index"
                    :href="link.url"
                    :class="[
                        'rounded-lg border px-4 py-2 text-sm font-medium transition-colors',
                        link.active
                            ? 'border-gray-900 bg-gray-900 text-white'
                            : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50',
                        !link.url ? 'cursor-not-allowed opacity-50' : ''
                    ]"
                    :disabled="!link.url"
                    v-html="link.label"
                />
            </div>
        </div>
</template>

<script setup>
import { Link, router, Head } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { UserPlus, Users, Edit, Trash2 } from 'lucide-vue-next'
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator
} from '@/components/ui/breadcrumb'

defineProps({
    users: Object
})

const deleteUser = (id) => {
    if (confirm('តើអ្នកប្រាកដថាចង់លុបអ្នកប្រើប្រាស់នេះ?')) {
        router.delete(route('dashboard.users.destroy', id))
    }
}
</script>
