<template>
  <DashboardLayout>
    <Head title="គ្រប់គ្រងអ្នកប្រើប្រាស់" />

    <div class="space-y-6">
      <!-- Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-gray-900 khmer-text">គ្រប់គ្រងអ្នកប្រើប្រាស់</h1>
          <p class="text-sm text-gray-600 mt-1 khmer-text">គ្រប់គ្រង និងកែប្រែអ្នកប្រើប្រាស់ក្នុងប្រព័ន្ធ</p>
        </div>
        <Link
          v-if="$page.props.auth.user.permissions.includes('create users')"
          :href="route('dashboard.users.create')"
          class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2.5 rounded-lg transition-colors"
        >
          <UserPlus class="w-4 h-4" />
          <span class="khmer-text">បង្កើតអ្នកប្រើថ្មី</span>
        </Link>
      </div>

      <!-- Table Card -->
      <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text">
                  ឈ្មោះ
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text">
                  អ៊ីម៉ែល
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text">
                  តួនាទី
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider khmer-text">
                  សកម្មភាព
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-if="users.data.length === 0">
                <td colspan="4" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center justify-center text-gray-500">
                    <Users class="w-12 h-12 mb-2" />
                    <p class="khmer-text">គ្មានអ្នកប្រើប្រាស់</p>
                  </div>
                </td>
              </tr>
              <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center">
                      <span class="text-white font-semibold text-sm">{{ user.name.charAt(0).toUpperCase() }}</span>
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
                      class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800"
                    >
                      {{ role.name }}
                    </span>
                    <span v-if="user.roles.length === 0" class="text-xs text-gray-400 khmer-text">គ្មានតួនាទី</span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex justify-end gap-2">
                    <Link
                      v-if="$page.props.auth.user.permissions.includes('edit users')"
                      :href="route('dashboard.users.edit', user.id)"
                      class="inline-flex items-center gap-1 text-gray-700 hover:text-gray-900 hover:bg-gray-100 px-3 py-1.5 rounded transition-colors"
                    >
                      <Edit class="w-4 h-4" />
                      <span class="khmer-text">កែសម្រួល</span>
                    </Link>
                    <button
                      v-if="$page.props.auth.user.permissions.includes('delete users') && user.id !== $page.props.auth.user.id"
                      @click="deleteUser(user.id)"
                      class="inline-flex items-center gap-1 text-gray-700 hover:text-gray-900 hover:bg-gray-100 px-3 py-1.5 rounded transition-colors"
                    >
                      <Trash2 class="w-4 h-4" />
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
            'px-4 py-2 border rounded-lg text-sm font-medium transition-colors',
            link.active ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50',
            !link.url ? 'opacity-50 cursor-not-allowed' : ''
          ]"
          :disabled="!link.url"
          v-html="link.label"
        />
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup>
import { Link, router, Head } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { UserPlus, Users, Edit, Trash2 } from 'lucide-vue-next';

defineProps({
  users: Object
});

const deleteUser = (id) => {
  if (confirm('តើអ្នកប្រាកដថាចង់លុបអ្នកប្រើប្រាស់នេះ?')) {
    router.delete(route('dashboard.users.destroy', id));
  }
};
</script>
