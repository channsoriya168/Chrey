<template>
  <DashboardLayout>
    <div class="p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Edit Role</h1>
      </div>

      <div class="bg-white rounded-lg shadow p-6 max-w-4xl">
        <form @submit.prevent="submit">
          <div class="mb-6">
            <Label for="name">Role Name</Label>
            <Input
              id="name"
              v-model="form.name"
              type="text"
              required
              autofocus
            />
            <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">
              {{ form.errors.name }}
            </div>
          </div>

          <div class="mb-6">
            <Label class="block mb-4">Permissions</Label>
            <div class="space-y-4">
              <div v-for="(groupPermissions, group) in permissions" :key="group">
                <h3 class="font-medium text-gray-900 mb-2 capitalize">{{ group }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 pl-4">
                  <div v-for="permission in groupPermissions" :key="permission.id" class="flex items-center">
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
            <div v-if="form.errors.permissions" class="text-red-600 text-sm mt-1">
              {{ form.errors.permissions }}
            </div>
          </div>

          <div class="flex gap-4">
            <button
              type="submit"
              :disabled="form.processing"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded disabled:opacity-50"
            >
              Update Role
            </button>
            <Link
              :href="route('dashboard.roles.index')"
              class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded"
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
import { Link, useForm } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Input from '@/Components/ui/Input.vue';
import Label from '@/Components/ui/Label.vue';

const props = defineProps({
  role: Object,
  permissions: Object,
  rolePermissions: Array
});

const form = useForm({
  name: props.role.name,
  permissions: props.rolePermissions
});

const submit = () => {
  form.put(route('dashboard.roles.update', props.role.id));
};
</script>
