<template>
    <div
        class="rounded-xl border border-slate-700/50 bg-slate-800/80 backdrop-blur-sm p-8 shadow-lg shadow-slate-900/50">
        <form @submit.prevent="$emit('submit')" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Name Field -->
                <div class="space-y-2">
                    <Label for="name" class="khmer-text text-sm font-bold text-slate-200">ឈ្មោះ <span
                            class="text-red-500">*</span></Label>
                    <Input id="name" v-model="form.name" type="text" required autofocus placeholder="បញ្ចូលឈ្មោះ"
                        class="h-11 border-2 !bg-transparent text-white placeholder:text-gray-500"
                        :class="form.errors.name ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-600 focus:border-blue-500 focus:ring-blue-500/20'" />
                    <p v-if="form.errors.name" class="text-xs text-red-400">{{ form.errors.name }}</p>
                </div>

                <!-- Email Field -->
                <div class="space-y-2">
                    <Label for="email" class="khmer-text text-sm font-bold text-slate-200">អ៊ីម៉ែល <span
                            class="text-red-500">*</span></Label>
                    <Input id="email" v-model="form.email" type="email" required placeholder="បញ្ចូលអ៊ីម៉ែល"
                        class="h-11 border-2 !bg-transparent text-white placeholder:text-gray-500"
                        :class="form.errors.email ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-600 focus:border-blue-500 focus:ring-blue-500/20'" />
                    <p v-if="form.errors.email" class="text-xs text-red-400">{{ form.errors.email }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Password Field -->
                <div class="space-y-2">
                    <Label for="password" class="khmer-text text-sm font-bold text-slate-200">
                        លេខសម្ងាត់{{ isEdit ? 'ថ្មី' : '' }} <span v-if="!isEdit" class="text-red-500">*</span>
                    </Label>
                    <Input id="password" v-model="form.password" type="password" :required="!isEdit"
                        :placeholder="isEdit ? 'ទុកទទេ ប្រសិនបើមិនចង់ប្តូរ' : 'បញ្ចូលលេខសម្ងាត់'"
                        class="h-11 border-2 !bg-transparent text-white placeholder:text-gray-500"
                        :class="form.errors.password ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-600 focus:border-blue-500 focus:ring-blue-500/20'" />
                    <p v-if="isEdit" class="khmer-text text-xs text-slate-400">ទុកចោល ប្រសិនបើមិនចង់ប្តូរលេខសម្ងាត់</p>
                    <p v-if="form.errors.password" class="text-xs text-red-400">{{ form.errors.password }}</p>
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <Label for="password_confirmation" class="khmer-text text-sm font-bold text-slate-200">
                        បញ្ជាក់លេខសម្ងាត់{{ isEdit ? 'ថ្មី' : '' }} <span v-if="!isEdit" class="text-red-500">*</span>
                    </Label>
                    <Input id="password_confirmation" v-model="form.password_confirmation" type="password"
                        :required="!isEdit" placeholder="បញ្ជាក់លេខសម្ងាត់"
                        class="h-11 border-2 border-gray-600 !bg-transparent text-white placeholder:text-gray-500 focus:border-blue-500 focus:ring-blue-500/20" />
                </div>
            </div>

            <!-- Roles Section -->
            <div class="space-y-3">
                <Label class="khmer-text text-sm font-bold text-slate-200">តួនាទី</Label>
                <div class="space-y-2 rounded-lg border border-slate-700/50 bg-slate-700/20 p-4">
                    <div v-for="role in roles" :key="role.id"
                        class="group flex items-center gap-3 rounded-md px-3 py-2.5 transition-colors hover:bg-slate-700/30">
                        <input :id="`role-${role.id}`" v-model="form.roles" type="checkbox" :value="role.name"
                            class="h-4 w-4 rounded border-gray-600 bg-slate-800 text-purple-600 transition-all focus:ring-2 focus:ring-purple-500/20 focus:ring-offset-0" />
                        <label :for="`role-${role.id}`"
                            class="flex-1 cursor-pointer text-sm font-medium text-gray-200 group-hover:text-white">
                            {{ role.name }}
                        </label>
                    </div>
                    <div v-if="roles.length === 0" class="khmer-text py-2 text-center text-sm text-gray-400">
                        គ្មានតួនាទីទេ</div>
                </div>
                <p v-if="form.errors.roles" class="text-xs text-red-400">{{ form.errors.roles }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between gap-4 border-t border-slate-700/50 pt-6">
                <p class="khmer-text text-sm text-slate-400">{{ isEdit ? 'សូមត្រួតពិនិត្យមុនពេលរក្សាទុក' :
                    'សូមត្រួតពិនិត្យមុនពេលបង្កើត' }}</p>
                <div class="flex gap-3">
                    <slot name="cancel-button">
                        <button type="button" @click="$emit('cancel')"
                            class="inline-flex items-center gap-2 rounded-lg border-2 border-gray-600 bg-transparent px-6 py-2.5 font-medium text-slate-200 transition-all hover:border-blue-400 hover:bg-blue-500/10 active:scale-95">
                            <X class="h-4 w-4" />
                            <span class="khmer-text">បោះបង់</span>
                        </button>
                    </slot>
                    <button type="submit" :disabled="form.processing"
                        class="inline-flex items-center gap-2 rounded-lg bg-purple-600 px-8 py-2.5 font-semibold text-white shadow-lg shadow-purple-500/20 transition-all hover:bg-purple-500 hover:shadow-purple-500/30 active:scale-95 disabled:cursor-not-allowed disabled:opacity-50">
                        <Save class="h-4 w-4" />
                        <span class="khmer-text">{{ submitText }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
    import { Input } from '@/Components/ui/input'
    import { Label } from '@/Components/ui/label'
    import { Save, X } from 'lucide-vue-next'

    defineProps({
        form: {
            type: Object,
            required: true
        },
        roles: {
            type: Array,
            required: true
        },
        isEdit: {
            type: Boolean,
            default: false
        },
        submitText: {
            type: String,
            required: true
        }
    })

    defineEmits(['submit', 'cancel'])
</script>
