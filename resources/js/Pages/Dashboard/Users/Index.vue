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
                <!-- <h1 class="khmer-text text-2xl font-bold text-gray-900">គ្រប់គ្រងអ្នកប្រើប្រាស់</h1>
                    <p class="khmer-text mt-1 text-sm text-gray-600">គ្រប់គ្រង និងកែប្រែអ្នកប្រើប្រាស់ក្នុងប្រព័ន្ធ</p> -->
            </div>
            <Link v-if="$page.props.auth.user.permissions.includes('create users')"
                :href="route('dashboard.users.create')"
                class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-white transition-colors hover:bg-gray-800">
                <UserPlus class="h-4 w-4" />
                <span class="khmer-text">បង្កើតអ្នកប្រើថ្មី</span>
            </Link>
        </div>

        <!-- DataTable -->
        <div class="overflow-hidden">
            <DataTable :columns="columns" :data="users.data" :loading="loading" :pagination="users"
                :can-edit="$page.props.auth.user.permissions.includes('edit users')"
                :can-delete="$page.props.auth.user.permissions.includes('delete users')" delete-item-name-key="name"
                edit-label="កែសម្រួល" delete-label="លុប" @page-change="handlePageChange"
                @per-page-change="handlePerPageChange" @edit="editUser" @delete="deleteUser">
                <!-- Custom Cell: Name with Avatar -->
                <template #cell-name="{ item }">
                    <div class="flex items-center">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-gray-900">
                            <span class="text-sm font-semibold text-white">
                                {{ item.name.charAt(0).toUpperCase() }}
                            </span>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">{{ item.name }}</div>
                        </div>
                    </div>
                </template>

                <!-- Custom Cell: Email -->
                <template #cell-email="{ item }">
                    <div class="text-sm text-gray-700">{{ item.email }}</div>
                </template>

                <!-- Custom Cell: Roles -->
                <template #cell-roles="{ item }">
                    <div class="flex flex-wrap gap-1">
                        <span v-for="role in item.roles" :key="role.id"
                            class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                            {{ role.name }}
                        </span>
                        <span v-if="item.roles.length === 0" class="khmer-text text-xs text-gray-400">
                            គ្មានតួនាទី
                        </span>
                    </div>
                </template>

                <!-- Empty State -->
                <template #empty>
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="mb-4 rounded-full bg-gray-100 p-6">
                            <Users class="h-12 w-12 text-gray-400" />
                        </div>
                        <h3 class="khmer-text mb-2 text-lg font-semibold text-gray-900">គ្មានអ្នកប្រើប្រាស់</h3>
                    </div>
                </template>

                <!-- Custom Actions Column -->
                <template #actions="{ item }">
                    <div class="inline-flex items-center justify-end gap-1.5">
                        <button v-if="$page.props.auth.user.permissions.includes('edit users')" @click="editUser(item)"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-amber-500 transition-all duration-200 hover:bg-amber-50 hover:text-amber-600"
                            title="កែសម្រួល">
                            <Edit class="h-4 w-4" />
                        </button>
                        <button v-if="
                            $page.props.auth.user.permissions.includes('delete users') &&
                            item.id !== $page.props.auth.user.id
                        " @click="deleteUser(item)"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-red-500 transition-all duration-200 hover:bg-red-50 hover:text-red-600"
                            title="លុប">
                            <Trash2 class="h-4 w-4" />
                        </button>
                    </div>
                </template>
            </DataTable>
        </div>
    </div>
</template>

<script setup>
    import {
        Breadcrumb,
        BreadcrumbItem,
        BreadcrumbLink,
        BreadcrumbList,
        BreadcrumbPage,
        BreadcrumbSeparator
    } from '@/Components/ui/breadcrumb'
    import DataTable from '@/Components/ui/DataTable.vue'
    import { Head, Link, router } from '@inertiajs/vue3'
    import { Edit, Trash2, UserPlus, Users } from 'lucide-vue-next'
    import { ref } from 'vue'

    const props = defineProps({
        users: {
            type: Object,
            default: () => ({
                data: [],
                current_page: 1,
                last_page: 1,
                per_page: 10,
                total: 0,
                from: 0,
                to: 0
            })
        },
        filters: {
            type: Object,
            default: () => ({
                per_page: 10
            })
        }
    })

    // State
    const loading = ref(false)

    // Table columns configuration
    const columns = [
        {
            key: 'name',
            label: 'ឈ្មោះ'
        },
        {
            key: 'email',
            label: 'អ៊ីម៉ែល'
        },
        {
            key: 'roles',
            label: 'តួនាទី'
        }
    ]

    // Navigate to edit page
    const editUser = (item) => {
        router.visit(route('dashboard.users.edit', item.id))
    }

    // Delete user
    const deleteUser = (item) => {
        if (confirm('តើអ្នកប្រាកដថាចង់លុបអ្នកប្រើប្រាស់នេះ?')) {
            router.delete(route('dashboard.users.destroy', item.id), {
                preserveScroll: true
            })
        }
    }

    // Handle page change
    const handlePageChange = (page) => {
        router.reload({
            only: ['users'],
            data: {
                page: page,
                per_page: props.filters.per_page
            }
        })
    }

    // Handle per page change
    const handlePerPageChange = (perPage) => {
        router.reload({
            only: ['users'],
            data: {
                page: 1,
                per_page: perPage
            }
        })
    }
</script>
