<template>
  <DashboardLayout>
    <Head title="បង្កើតអ្នកប្រើប្រាស់ថ្មី" />

    <div class="space-y-6 max-w-3xl">
      <!-- Header -->
      <div>
        <h1 class="text-2xl font-bold text-gray-900 khmer-text">បង្កើតអ្នកប្រើប្រាស់ថ្មី</h1>
        <p class="text-sm text-gray-600 mt-1 khmer-text">បំពេញព័ត៌មានដើម្បីបង្កើតអ្នកប្រើប្រាស់ថ្មី</p>
      </div>

      <!-- Form Card -->
      <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
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
            <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">
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
            <div v-if="form.errors.email" class="text-red-600 text-sm mt-1">
              {{ form.errors.email }}
            </div>
          </div>

          <!-- Password Field -->
          <div>
            <Label for="password" class="khmer-text">លេខសម្ងាត់</Label>
            <Input
              id="password"
              v-model="form.password"
              type="password"
              required
              class="mt-1"
              :class="{ 'border-red-500': form.errors.password }"
            />
            <div v-if="form.errors.password" class="text-red-600 text-sm mt-1">
              {{ form.errors.password }}
            </div>
          </div>

          <!-- Confirm Password Field -->
          <div>
            <Label for="password_confirmation" class="khmer-text">បញ្ជាក់លេខសម្ងាត់</Label>
            <Input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              required
              class="mt-1"
            />
          </div>

          <!-- Roles Section -->
          <div>
            <Label class="khmer-text mb-3 block">តួនាទី</Label>
            <div class="space-y-3 bg-gray-50 rounded-lg p-4 border border-gray-200">
              <div v-for="role in roles" :key="role.id" class="flex items-center">
                <input
                  :id="`role-${role.id}`"
                  v-model="form.roles"
                  type="checkbox"
                  :value="role.name"
                  class="w-4 h-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                />
                <label :for="`role-${role.id}`" class="ml-3 text-sm text-gray-700 font-medium">
                  {{ role.name }}
                </label>
              </div>
              <div v-if="roles.length === 0" class="text-sm text-gray-500 khmer-text">
                គ្មានតួនាទីទេ
              </div>
            </div>
            <div v-if="form.errors.roles" class="text-red-600 text-sm mt-1">
              {{ form.errors.roles }}
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-3 pt-4 border-t border-gray-200">
            <button
              type="submit"
              :disabled="form.processing"
              class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-6 py-2.5 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <Save class="w-4 h-4" />
              <span class="khmer-text">បង្កើត</span>
            </button>
            <Link
              :href="route('dashboard.users.index')"
              class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-6 py-2.5 rounded-lg transition-colors"
            >
              <X class="w-4 h-4" />
              <span class="khmer-text">បោះបង់</span>
            </Link>
          </div>
        </form>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup>
import { Link, useForm, Head } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Input from '@/Components/ui/Input.vue';
import Label from '@/Components/ui/Label.vue';
import { Save, X } from 'lucide-vue-next';

const props = defineProps({
  roles: Array
});

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  roles: []
});

const submit = () => {
  form.post(route('dashboard.users.store'));
};
</script>
