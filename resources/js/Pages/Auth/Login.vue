<template>
    <div
        class="khmer-text relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-purple-900 via-slate-900 to-slate-950 p-4">

        <Head title="ចូលគណនី" />

        <div class="relative z-10 w-full max-w-md">
            <!-- Flash Messages -->
            <FlashMessage />

            <!-- Login Card -->
            <div
                class="hover:shadow-3xl animate-fade-in-up transform overflow-hidden rounded-2xl border border-blue-500/20 bg-slate-800/40 shadow-2xl shadow-blue-500/20 backdrop-blur-xl transition-all duration-500">
                <!-- Header Section -->
                <div class="relative overflow-hidden px-6 py-6">
                    <div
                        class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-500/10 via-transparent to-transparent">
                    </div>
                    <h1 class="relative z-10 text-center text-2xl font-bold text-white">ចូលគណនី</h1>
                </div>

                <!-- Form Section -->
                <div class="px-6 py-6">
                    <vee-form @submit="handleLogin" :validation-schema="validationSchema"
                        v-slot="{ errors: formErrors }">
                        <div class="space-y-4">
                            <!-- Email Field -->
                            <vee-field name="email" v-slot="{ field, errors, meta }">
                                <div class="group space-y-1.5">
                                    <Label for="email"
                                        class="flex items-center gap-1.5 text-xs font-bold tracking-wide text-gray-200">
                                        <div class="h-3 w-1 rounded-full bg-gradient-to-b from-blue-500 to-cyan-500">
                                        </div>
                                        អ៊ីម៉ែល
                                    </Label>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3">
                                            <div
                                                class="rounded-lg bg-gradient-to-br from-blue-500/20 to-cyan-500/20 p-1.5 transition-all duration-300 group-focus-within:from-blue-500/30 group-focus-within:to-cyan-500/30">
                                                <svg class="h-3.5 w-3.5 text-blue-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <Input v-model="form.email" v-bind="field" id="email" type="email"
                                            autocomplete="email" placeholder="សូមបញ្ចូលអ៊ីម៉ែល" :class="[
                                                'h-12 w-full rounded-lg border-2 pr-12 pl-14 text-sm font-medium transition-all duration-300 outline-none text-white bg-transparent',
                                                errors.length || form.errors.email
                                                    ? 'border-red-500 focus:border-red-500 focus:ring-2 focus:ring-red-500/50'
                                                    : 'border-white focus:border-white focus:ring-2 focus:ring-white/50'
                                            ]" />
                                    </div>
                                    <!-- Error Message -->
                                    <p v-if="errors.length"
                                        class="animate-shake ml-1 flex items-center gap-1.5 text-xs text-red-600">
                                        <span class="font-medium">{{ errors[0] }}</span>
                                    </p>
                                </div>
                            </vee-field>

                            <!-- Password Field -->
                            <vee-field name="password" v-slot="{ field, errors, meta }">
                                <div class="group space-y-1.5">
                                    <Label for="password"
                                        class="flex items-center gap-1.5 text-xs font-bold tracking-wide text-gray-200">
                                        <div class="h-3 w-1 rounded-full bg-gradient-to-b from-blue-500 to-cyan-500">
                                        </div>
                                        លេខសម្ងាត់
                                    </Label>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3">
                                            <div
                                                class="rounded-lg bg-gradient-to-br from-blue-500/20 to-cyan-500/20 p-1.5 transition-all duration-300 group-focus-within:from-blue-500/30 group-focus-within:to-cyan-500/30">
                                                <svg class="h-3.5 w-3.5 text-blue-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <Input v-model="form.password" v-bind="field" id="password"
                                            :type="showPassword ? 'text' : 'password'" autocomplete="current-password"
                                            placeholder="សូមបញ្ជូលពាក្យសម្ងាត់" :class="[
                                                'h-12 w-full rounded-lg border-2 pr-20 pl-14 text-sm font-medium transition-all duration-300 outline-none text-white bg-transparent',
                                                errors.length || form.errors.password
                                                    ? 'border-red-500 focus:border-red-500 focus:ring-2 focus:ring-red-500/50'
                                                    : 'border-white focus:border-white focus:ring-2 focus:ring-white/50'
                                            ]" :aria-invalid="!!errors.length || !!form.errors.password" />
                                        <!-- Toggle Password & Success Icon -->
                                        <div class="absolute inset-y-0 right-0 z-10 flex items-center gap-1.5 pr-3">
                                            <button type="button" @click="showPassword = !showPassword"
                                                class="rounded-lg p-1.5 transition-all duration-200 hover:bg-blue-500/10 focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-1 focus:outline-none">
                                                <svg v-if="showPassword"
                                                    class="h-4 w-4 text-gray-400 transition-colors hover:text-blue-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg v-else class="h-4 w-4 text-blue-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Error Message -->
                                    <p v-if="errors.length"
                                        class="animate-shake ml-1 flex items-center gap-1.5 text-xs text-red-600">
                                        <span class="font-medium">{{ errors[0] }}</span>
                                    </p>
                                </div>
                            </vee-field>

                            <!-- Remember Me -->
                            <div class="flex items-center pt-0.5">
                                <div class="relative flex items-center">
                                    <input id="remember" v-model="form.remember" type="checkbox"
                                        class="peer h-4 w-4 cursor-pointer rounded border-2 border-gray-600 bg-slate-700/50 text-fuchsia-600 transition-all checked:bg-gradient-to-br checked:from-fuchsia-600 checked:to-pink-600 hover:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-500/20 focus:ring-offset-0" />
                                    <Label for="remember"
                                        class="ml-2 cursor-pointer text-xs font-semibold text-gray-300 transition-colors peer-checked:text-fuchsia-400 hover:text-fuchsia-300">
                                        ចងចាំខ្ញុំ
                                    </Label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" :disabled="form.processing" :class="[
                                'h-12 w-full bg-pink-500',
                                'hover:bg-pink-700',
                                'rounded-lg text-base font-bold text-white',
                                'transform transition-all duration-300',
                                'disabled:cursor-not-allowed disabled:opacity-60',
                                !form.processing && 'hover:scale-[1.01] active:scale-[0.99]',
                                'relative overflow-hidden'
                            ]">
                                <span
                                    class="absolute inset-0 -translate-x-full -skew-x-12 transform bg-gradient-to-r from-white/0 via-white/20 to-white/0 transition-transform duration-1000 group-hover:translate-x-full"></span>
                                <span v-if="form.processing"
                                    class="relative z-10 flex items-center justify-center gap-2">
                                    <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    កំពុងចូល...
                                </span>
                                <span v-else class="relative z-10 flex items-center justify-center gap-2">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    ចូលគណនី
                                </span>
                            </button>

                            <!-- General Error Message -->
                            <div v-if="
                                form.errors &&
                                Object.keys(form.errors).length > 0 &&
                                !form.errors.email &&
                                !form.errors.password
                            "
                                class="animate-shake rounded-lg border-2 border-red-300 bg-red-50/80 p-3 shadow-md backdrop-blur">
                                <div class="flex items-start gap-2">
                                    <div
                                        class="flex-shrink-0 rounded-full bg-gradient-to-br from-red-500 to-red-600 p-1 shadow-sm">
                                        <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="mb-1 text-sm font-bold text-red-800">មានកំហុសកើតឡើង</h3>
                                        <ul class="space-y-1">
                                            <li v-for="(error, key) in form.errors" :key="key"
                                                class="text-xs font-medium text-red-700">
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
                            <div class="w-full border-t border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="bg-slate-800/40 px-3 font-semibold text-gray-400">ឬ</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-300">
                            មិនមានគណនី?
                            <Link href="/register"
                                class="bg-gradient-to-r from-fuchsia-400 to-pink-400 bg-clip-text font-bold text-transparent underline decoration-fuchsia-400 decoration-2 underline-offset-2 transition-all hover:from-fuchsia-300 hover:to-pink-300">
                                ចុះឈ្មោះឥឡូវនេះ
                            </Link>
                        </p>
                    </div>
                    <div class="text-center mt-3">
                        <p class="text-sm text-gray-300">
                            <Link href="/"
                                class="bg-white bg-clip-text  text-transparent decoration-fuchsia-400 decoration-2 transition-all hover:bg-pink-300">
                                ត្រលប់ទៅទំព័រដើម
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
    import FlashMessage from '@/Components/FlashMessage.vue'
    import { Input } from '@/Components/ui/input'
    import { Label } from '@/Components/ui/label'
    import { Head, Link, useForm } from '@inertiajs/vue3'
    import { ref } from 'vue'
    import * as yup from 'yup'

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

<style scoped></style>
