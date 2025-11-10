<template>
  <DashboardLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Role Management</h1>
        <Link
          v-if="$page.props.auth.user.permissions.includes('create roles')"
          :href="route('dashboard.roles.create')"
          class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
        >
          Create Role
        </Link>
      </div>

      <FlashMessage />

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="role in roles" :key="role.id" class="bg-white rounded-lg shadow p-6">
          <div class="flex justify-between items-start mb-4">
            <h3 class="text-xl font-semibold capitalize">{{ role.name }}</h3>
            <div class="flex gap-2">
              <Link
                v-if="$page.props.auth.user.permissions.includes('edit roles')"
                :href="route('dashboard.roles.edit', role.id)"
                class="text-blue-600 hover:text-blue-900 text-sm"
              >
                Edit
              </Link>
              <button
                v-if="$page.props.auth.user.permissions.includes('delete roles') && role.name !== 'admin'"
                @click="deleteRole(role.id)"
                class="text-red-600 hover:text-red-900 text-sm"
              >
                Delete
              </button>
            </div>
          </div>

          <div class="border-t pt-4">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Permissions ({{ role.permissions.length }})</h4>
            <div class="flex flex-wrap gap-1">
              <span
                v-for="permission in role.permissions.slice(0, 6)"
                :key="permission.id"
                class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700"
              >
                {{ permission.name }}
              </span>
              <span
                v-if="role.permissions.length > 6"
                class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700"
              >
                +{{ role.permissions.length - 6 }} more
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

defineProps({
  roles: Array
});

const deleteRole = (id) => {
  if (confirm('Are you sure you want to delete this role?')) {
    router.delete(route('dashboard.roles.destroy', id));
  }
};
</script>
