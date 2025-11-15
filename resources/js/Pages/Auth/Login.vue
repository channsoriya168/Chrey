<template>
    <div class="khmer-text min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 p-4 relative overflow-hidden">
        <Head title="ចូលគណនី" />

        <div class="w-full max-w-md relative z-10">
            <!-- Flash Messages -->
            <FlashMessage />

            <!-- Login Card -->
            <div class="bg-white/90 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/20 shadow-2xl transform transition-all duration-500 hover:shadow-3xl animate-fade-in-up">
                <!-- Header Section -->
                <div class=" px-6 py-6 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white/20 via-transparent to-transparent"></div>
                    <h1 class="text-2xl font-bold text-black text-center relative z-10">ចូលគណនី</h1>
                </div>

                <!-- Form Section -->
                <div class="px-6 py-6">
                    <vee-form
                        @submit="handleLogin"
                        :validation-schema="validationSchema"
                        v-slot="{ errors: formErrors }"
                    >
                        <div class="space-y-4">
                            <!-- Email Field -->
                            <vee-field name="email" v-slot="{ field, errors, meta }">
                                <div class="space-y-1.5 group">
                                    <Label for="email" class="text-xs font-bold text-gray-800 tracking-wide flex items-center gap-1.5">
                                        <div class="w-1 h-3 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                                        អ៊ីម៉ែល
                                    </Label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                            <div class="p-1.5 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg transition-all duration-300 group-focus-within:from-indigo-200 group-focus-within:to-purple-200">
                                                <svg class="h-3.5 w-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <input
                                            v-model="form.email"
                                            v-bind="field"
                                            id="email"
                                            type="email"
                                            autocomplete="email"
                                            placeholder="សូមបញ្ចូលអ៊ីម៉ែល"
                                            :class="[
                                                'w-full h-12 pl-14 pr-12 text-sm rounded-lg border-2 transition-all duration-300 outline-none font-medium',
                                                'placeholder:text-gray-400 placeholder:font-normal',
                                                errors.length || form.errors.email
                                                    ? 'border-red-400 bg-red-50/70 focus:border-red-500 focus:ring-4 focus:ring-red-100/60 shadow-sm shadow-red-200/50'
                                                    : meta.valid && meta.touched
                                                        ? 'border-emerald-400 bg-emerald-50/70 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100/60 shadow-sm shadow-emerald-200/50'
                                                        : 'border-gray-300 bg-white hover:border-indigo-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/60 shadow-sm hover:shadow-md focus:shadow-lg'
                                            ]"
                                        />
                                        <!-- Success Icon -->
                                        <div v-if="meta.valid && meta.touched && !errors.length && !form.errors.email" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none animate-scale-in">
                                            <div class="bg-gradient-to-br from-emerald-500 to-green-500 rounded-full p-1 shadow-md shadow-emerald-300/50 ring-2 ring-emerald-100">
                                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Error Message -->
                                    <p v-if="errors.length" class="text-xs text-red-600 flex items-center gap-1.5 ml-1 animate-shake">
                                        <span class="font-medium">{{ errors[0] }}</span>
                                    </p>
                                </div>
                            </vee-field>

                            <!-- Password Field -->
                            <vee-field name="password" v-slot="{ field, errors, meta }">
                                <div class="space-y-1.5 group">
                                    <Label for="password" class="text-xs font-bold text-gray-800 tracking-wide flex items-center gap-1.5">
                                        <div class="w-1 h-3 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                                        លេខសម្ងាត់
                                    </Label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                            <div class="p-1.5 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg transition-all duration-300 group-focus-within:from-indigo-200 group-focus-within:to-purple-200">
                                                <svg class="h-3.5 w-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <input
                                            v-model="form.password"
                                            v-bind="field"
                                            id="password"
                                            :type="showPassword ? 'text' : 'password'"
                                            autocomplete="current-password"
                                            placeholder="សូមបញ្ជូលពាក្យសម្ងាត់"
                                            :class="[
                                                'w-full h-12 pl-14 pr-20 text-sm rounded-lg border-2 transition-all duration-300 outline-none font-medium',
                                                'placeholder:text-gray-400 placeholder:font-normal',
                                                errors.length || form.errors.password
                                                    ? 'border-red-400 bg-red-50/70 focus:border-red-500 focus:ring-4 focus:ring-red-100/60 shadow-sm shadow-red-200/50'
                                                    : meta.valid && meta.touched
                                                        ? 'border-emerald-400 bg-emerald-50/70 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100/60 shadow-sm shadow-emerald-200/50'
                                                        : 'border-gray-300 bg-white hover:border-indigo-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100/60 shadow-sm hover:shadow-md focus:shadow-lg'
                                            ]"
                                            :aria-invalid="!!errors.length || !!form.errors.password"
                                        />
                                        <!-- Toggle Password & Success Icon -->
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center gap-1.5 z-10">    
                                            <button
                                                type="button"
                                                @click="showPassword = !showPassword"
                                                class="p-1.5 rounded-lg hover:bg-indigo-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                                            >
                                                <svg v-if="showPassword" class="h-4 w-4 text-gray-500 hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg v-else class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Error Message -->
                                    <p v-if="errors.length" class="text-xs text-red-600 flex items-center gap-1.5 ml-1 animate-shake">
                                        <span class="font-medium">{{ errors[0] }}</span>
                                    </p>
                                </div>
                            </vee-field>

                            <!-- Remember Me -->
                            <div class="flex items-center pt-0.5">
                                <div class="relative flex items-center">
                                    <input
                                        id="remember"
                                        v-model="form.remember"
                                        type="checkbox"
                                        class="peer h-4 w-4 rounded border-2 border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-100 focus:ring-offset-0 cursor-pointer transition-all hover:border-indigo-400 checked:bg-gradient-to-br checked:from-indigo-600 checked:to-purple-600"
                                    />
                                    <Label for="remember" class="ml-2 text-xs text-gray-700 cursor-pointer font-semibold hover:text-indigo-600 transition-colors peer-checked:text-indigo-700">
                                        ចងចាំខ្ញុំ
                                    </Label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                :disabled="form.processing"
                                :class="[
                                    'w-full h-12 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600',
                                    'hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700',
                                    'text-white font-bold text-base rounded-lg',
                                    'transition-all duration-300 transform',
                                    'shadow-lg hover:shadow-xl shadow-indigo-300/50',
                                    'disabled:opacity-60 disabled:cursor-not-allowed',
                                    !form.processing && 'hover:scale-[1.01] active:scale-[0.99]',
                                    'relative overflow-hidden'
                                ]"
                            >
                                <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>
                                <span v-if="form.processing" class="flex items-center justify-center gap-2 relative z-10">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    កំពុងចូល...
                                </span>
                                <span v-else class="flex items-center justify-center gap-2 relative z-10">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    ចូលគណនី
                                </span>
                            </button>

                            <!-- General Error Message -->
                            <div v-if="form.errors && Object.keys(form.errors).length > 0 && !form.errors.email && !form.errors.password"
                                 class="p-3 rounded-lg bg-red-50/80 backdrop-blur border-2 border-red-300 shadow-md animate-shake">
                                <div class="flex items-start gap-2">
                                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-full p-1 flex-shrink-0 shadow-sm">
                                        <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-sm font-bold text-red-800 mb-1">មានកំហុសកើតឡើង</h3>
                                        <ul class="space-y-1">
                                            <li v-for="(error, key) in form.errors" :key="key" class="text-xs text-red-700 font-medium">
                                                • {{ error }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </vee-form>

                    <!-- Divider -->
                    <div class="relative my-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-3 bg-white/90 text-gray-500 font-semibold">ឬ</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            មិនមានគណនី?
                            <Link href="/register" class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-all underline decoration-2 underline-offset-2 decoration-indigo-400">
                                ចុះឈ្មោះឥឡូវនេះ
                            </Link>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    layout: null // Disable layout for login page
}
</script>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import * as yup from 'yup'
import { Label } from '@/components/ui/label'
import FlashMessage from '@/Components/FlashMessage.vue'

// Show password toggle
const showPassword = ref(false)

// Yup validation schema
const validationSchema = yup.object().shape({
    email: yup.string().required('អ៊ីម៉ែលត្រូវបានទាមទារ').email('អ៊ីម៉ែលមិនត្រឹមត្រូវ'),
    password: yup.string().required('លេខសម្ងាត់ត្រូវបានទាមទារ').min(6, 'លេខសម្ងាត់ត្រូវមានយ៉ាងហោចណាស់ 6 តួអក្សរ')
})

// Form data
const form = useForm({
    email: '',
    password: '',
    remember: false
})

// Handle login submission
const handleLogin = () => {
    form.post('/login', {
        preserveScroll: true
    })
}
</script>

<style scoped>

</style>
