<template>
    <div
        class="khmer-text relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 p-4"
    >
        <Head title="បង្កើតគណនី" />

        <div class="relative z-10 w-full max-w-md">
            <!-- Flash Messages -->
            <FlashMessage />

            <!-- Register Card -->
            <div
                class="hover:shadow-3xl animate-fade-in-up transform overflow-hidden rounded-2xl border border-white/20 bg-white/90 shadow-2xl backdrop-blur-xl transition-all duration-500"
            >
                <!-- Header Section -->
                <div class="relative overflow-hidden px-6 py-6">
                    <div
                        class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white/20 via-transparent to-transparent"
                    ></div>
                    <h1 class="relative z-10 text-center text-2xl font-bold text-black">បង្កើតគណនី</h1>
                </div>

                <!-- Form Section -->
                <div class="px-6 py-6">
                    <vee-form
                        @submit="handleRegister"
                        :validation-schema="validationSchema"
                        v-slot="{ errors: formErrors }"
                    >
                        <div class="space-y-4">
                            <!-- Name Field -->
                            <vee-field name="name" v-slot="{ field, errors, meta }">
                                <div class="group space-y-1.5">
                                    <Label
                                        for="name"
                                        class="flex items-center gap-1.5 text-xs font-bold tracking-wide text-gray-800"
                                    >
                                        <div
                                            class="h-3 w-1 rounded-full bg-gradient-to-b from-indigo-500 to-purple-500"
                                        ></div>
                                        ឈ្មោះ
                                    </Label>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3"
                                        >
                                            <div
                                                class="rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100 p-1.5 transition-all duration-300 group-focus-within:from-indigo-200 group-focus-within:to-purple-200"
                                            >
                                                <svg
                                                    class="h-3.5 w-3.5 text-indigo-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                        <input
                                            v-model="form.name"
                                            v-bind="field"
                                            id="name"
                                            type="text"
                                            autocomplete="name"
                                            placeholder="សូមបញ្ចូលឈ្មោះ"
                                            :class="[
                                                'h-12 w-full rounded-lg border-2 pr-12 pl-14 text-sm font-medium transition-all duration-300 outline-none',
                                                'placeholder:font-normal placeholder:text-gray-400',
                                                errors.length || form.errors.name
                                                    ? 'border-red-400 bg-red-50/70 shadow-sm shadow-red-200/50 focus:border-red-500 focus:ring-4 focus:ring-red-100/60'
                                                    : meta.valid && meta.touched
                                                      ? 'border-emerald-400 bg-emerald-50/70 shadow-sm shadow-emerald-200/50 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100/60'
                                                      : 'border-gray-300 bg-white shadow-sm hover:border-indigo-300 hover:shadow-md focus:border-indigo-500 focus:shadow-lg focus:ring-4 focus:ring-indigo-100/60'
                                            ]"
                                        />
                                        <!-- Success Icon -->
                                        <div
                                            v-if="meta.valid && meta.touched && !errors.length && !form.errors.name"
                                            class="animate-scale-in pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
                                        >
                                            <div
                                                class="rounded-full bg-gradient-to-br from-emerald-500 to-green-500 p-1 shadow-md ring-2 shadow-emerald-300/50 ring-emerald-100"
                                            >
                                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Error Message -->
                                    <p
                                        v-if="errors.length"
                                        class="animate-shake ml-1 flex items-center gap-1.5 text-xs text-red-600"
                                    >
                                        <span class="font-medium">{{ errors[0] }}</span>
                                    </p>
                                </div>
                            </vee-field>

                            <!-- Email Field -->
                            <vee-field name="email" v-slot="{ field, errors, meta }">
                                <div class="group space-y-1.5">
                                    <Label
                                        for="email"
                                        class="flex items-center gap-1.5 text-xs font-bold tracking-wide text-gray-800"
                                    >
                                        <div
                                            class="h-3 w-1 rounded-full bg-gradient-to-b from-indigo-500 to-purple-500"
                                        ></div>
                                        អ៊ីម៉ែល
                                    </Label>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3"
                                        >
                                            <div
                                                class="rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100 p-1.5 transition-all duration-300 group-focus-within:from-indigo-200 group-focus-within:to-purple-200"
                                            >
                                                <svg
                                                    class="h-3.5 w-3.5 text-indigo-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                                    />
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
                                                'h-12 w-full rounded-lg border-2 pr-12 pl-14 text-sm font-medium transition-all duration-300 outline-none',
                                                'placeholder:font-normal placeholder:text-gray-400',
                                                errors.length || form.errors.email
                                                    ? 'border-red-400 bg-red-50/70 shadow-sm shadow-red-200/50 focus:border-red-500 focus:ring-4 focus:ring-red-100/60'
                                                    : meta.valid && meta.touched
                                                      ? 'border-emerald-400 bg-emerald-50/70 shadow-sm shadow-emerald-200/50 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100/60'
                                                      : 'border-gray-300 bg-white shadow-sm hover:border-indigo-300 hover:shadow-md focus:border-indigo-500 focus:shadow-lg focus:ring-4 focus:ring-indigo-100/60'
                                            ]"
                                        />
                                        <!-- Success Icon -->
                                        <div
                                            v-if="meta.valid && meta.touched && !errors.length && !form.errors.email"
                                            class="animate-scale-in pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
                                        >
                                            <div
                                                class="rounded-full bg-gradient-to-br from-emerald-500 to-green-500 p-1 shadow-md ring-2 shadow-emerald-300/50 ring-emerald-100"
                                            >
                                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Error Message -->
                                    <p
                                        v-if="errors.length"
                                        class="animate-shake ml-1 flex items-center gap-1.5 text-xs text-red-600"
                                    >
                                        <span class="font-medium">{{ errors[0] }}</span>
                                    </p>
                                </div>
                            </vee-field>

                            <!-- Password Field -->
                            <vee-field name="password" v-slot="{ field, errors, meta }">
                                <div class="group space-y-1.5">
                                    <Label
                                        for="password"
                                        class="flex items-center gap-1.5 text-xs font-bold tracking-wide text-gray-800"
                                    >
                                        <div
                                            class="h-3 w-1 rounded-full bg-gradient-to-b from-indigo-500 to-purple-500"
                                        ></div>
                                        លេខសម្ងាត់
                                    </Label>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3"
                                        >
                                            <div
                                                class="rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100 p-1.5 transition-all duration-300 group-focus-within:from-indigo-200 group-focus-within:to-purple-200"
                                            >
                                                <svg
                                                    class="h-3.5 w-3.5 text-indigo-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                        <input
                                            v-model="form.password"
                                            v-bind="field"
                                            id="password"
                                            :type="showPassword ? 'text' : 'password'"
                                            autocomplete="new-password"
                                            placeholder="សូមបញ្ជូលពាក្យសម្ងាត់"
                                            :class="[
                                                'h-12 w-full rounded-lg border-2 pr-20 pl-14 text-sm font-medium transition-all duration-300 outline-none',
                                                'placeholder:font-normal placeholder:text-gray-400',
                                                errors.length || form.errors.password
                                                    ? 'border-red-400 bg-red-50/70 shadow-sm shadow-red-200/50 focus:border-red-500 focus:ring-4 focus:ring-red-100/60'
                                                    : meta.valid && meta.touched
                                                      ? 'border-emerald-400 bg-emerald-50/70 shadow-sm shadow-emerald-200/50 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100/60'
                                                      : 'border-gray-300 bg-white shadow-sm hover:border-indigo-300 hover:shadow-md focus:border-indigo-500 focus:shadow-lg focus:ring-4 focus:ring-indigo-100/60'
                                            ]"
                                        />
                                        <!-- Toggle Password Button -->
                                        <div class="absolute inset-y-0 right-0 z-10 flex items-center gap-1.5 pr-3">
                                            <button
                                                type="button"
                                                @click="showPassword = !showPassword"
                                                class="rounded-lg p-1.5 transition-all duration-200 hover:bg-indigo-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 focus:outline-none"
                                            >
                                                <svg
                                                    v-if="showPassword"
                                                    class="h-4 w-4 text-gray-500 transition-colors hover:text-indigo-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                    />
                                                </svg>
                                                <svg
                                                    v-else
                                                    class="h-4 w-4 text-indigo-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Error Message -->
                                    <p
                                        v-if="errors.length"
                                        class="animate-shake ml-1 flex items-center gap-1.5 text-xs text-red-600"
                                    >
                                        <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span class="font-medium">{{ errors[0] }}</span>
                                    </p>
                                    <p
                                        v-else-if="form.errors.password"
                                        class="animate-shake ml-1 flex items-center gap-1.5 text-xs text-red-600"
                                    >
                                        <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span class="font-medium">{{ form.errors.password }}</span>
                                    </p>
                                </div>
                            </vee-field>

                            <!-- Password Confirmation Field -->
                            <vee-field name="password_confirmation" v-slot="{ field, errors, meta }">
                                <div class="group space-y-1.5">
                                    <Label
                                        for="password_confirmation"
                                        class="flex items-center gap-1.5 text-xs font-bold tracking-wide text-gray-800"
                                    >
                                        <div
                                            class="h-3 w-1 rounded-full bg-gradient-to-b from-indigo-500 to-purple-500"
                                        ></div>
                                        បញ្ជាក់លេខសម្ងាត់
                                    </Label>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3"
                                        >
                                            <div
                                                class="rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100 p-1.5 transition-all duration-300 group-focus-within:from-indigo-200 group-focus-within:to-purple-200"
                                            >
                                                <svg
                                                    class="h-3.5 w-3.5 text-indigo-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                        <input
                                            v-model="form.password_confirmation"
                                            v-bind="field"
                                            id="password_confirmation"
                                            :type="showPasswordConfirmation ? 'text' : 'password'"
                                            autocomplete="new-password"
                                            placeholder="សូមបញ្ជាក់ពាក្យសម្ងាត់"
                                            :class="[
                                                'h-12 w-full rounded-lg border-2 pr-20 pl-14 text-sm font-medium transition-all duration-300 outline-none',
                                                'placeholder:font-normal placeholder:text-gray-400',
                                                errors.length || form.errors.password_confirmation
                                                    ? 'border-red-400 bg-red-50/70 shadow-sm shadow-red-200/50 focus:border-red-500 focus:ring-4 focus:ring-red-100/60'
                                                    : meta.valid && meta.touched
                                                      ? 'border-emerald-400 bg-emerald-50/70 shadow-sm shadow-emerald-200/50 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100/60'
                                                      : 'border-gray-300 bg-white shadow-sm hover:border-indigo-300 hover:shadow-md focus:border-indigo-500 focus:shadow-lg focus:ring-4 focus:ring-indigo-100/60'
                                            ]"
                                        />
                                        <!-- Toggle Password Button -->
                                        <div class="absolute inset-y-0 right-0 z-10 flex items-center gap-1.5 pr-3">
                                            <button
                                                type="button"
                                                @click="showPasswordConfirmation = !showPasswordConfirmation"
                                                class="rounded-lg p-1.5 transition-all duration-200 hover:bg-indigo-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 focus:outline-none"
                                            >
                                                <svg
                                                    v-if="showPasswordConfirmation"
                                                    class="h-4 w-4 text-gray-500 transition-colors hover:text-indigo-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                    />
                                                </svg>
                                                <svg
                                                    v-else
                                                    class="h-4 w-4 text-indigo-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Error Message -->
                                    <p
                                        v-if="errors.length"
                                        class="animate-shake ml-1 flex items-center gap-1.5 text-xs text-red-600"
                                    >
                                        <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span class="font-medium">{{ errors[0] }}</span>
                                    </p>
                                    <p
                                        v-else-if="form.errors.password_confirmation"
                                        class="animate-shake ml-1 flex items-center gap-1.5 text-xs text-red-600"
                                    >
                                        <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span class="font-medium">{{ form.errors.password_confirmation }}</span>
                                    </p>
                                </div>
                            </vee-field>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                :disabled="form.processing"
                                :class="[
                                    'h-12 w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600',
                                    'hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700',
                                    'rounded-lg text-base font-bold text-white',
                                    'transform transition-all duration-300',
                                    'shadow-lg shadow-indigo-300/50 hover:shadow-xl',
                                    'disabled:cursor-not-allowed disabled:opacity-60',
                                    !form.processing && 'hover:scale-[1.01] active:scale-[0.99]',
                                    'relative overflow-hidden'
                                ]"
                            >
                                <span
                                    class="absolute inset-0 -translate-x-full -skew-x-12 transform bg-gradient-to-r from-white/0 via-white/20 to-white/0 transition-transform duration-1000 group-hover:translate-x-full"
                                ></span>
                                <span
                                    v-if="form.processing"
                                    class="relative z-10 flex items-center justify-center gap-2"
                                >
                                    <svg
                                        class="h-4 w-4 animate-spin"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                        ></circle>
                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        ></path>
                                    </svg>
                                    កំពុងបង្កើត...
                                </span>
                                <span v-else class="relative z-10 flex items-center justify-center gap-2">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                                        />
                                    </svg>
                                    បង្កើតគណនី
                                </span>
                            </button>

                            <!-- General Error Message -->
                            <div
                                v-if="
                                    form.errors &&
                                    Object.keys(form.errors).length > 0 &&
                                    !form.errors.name &&
                                    !form.errors.email &&
                                    !form.errors.password &&
                                    !form.errors.password_confirmation
                                "
                                class="animate-shake rounded-lg border-2 border-red-300 bg-red-50/80 p-3 shadow-md backdrop-blur"
                            >
                                <div class="flex items-start gap-2">
                                    <div
                                        class="flex-shrink-0 rounded-full bg-gradient-to-br from-red-500 to-red-600 p-1 shadow-sm"
                                    >
                                        <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="mb-1 text-sm font-bold text-red-800">មានកំហុសកើតឡើង</h3>
                                        <ul class="space-y-1">
                                            <li
                                                v-for="(error, key) in form.errors"
                                                :key="key"
                                                class="text-xs font-medium text-red-700"
                                            >
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
                            <span class="bg-white/90 px-3 font-semibold text-gray-500">ឬ</span>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            មានគណនីរួចហើយ?
                            <Link
                                href="/login"
                                class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text font-bold text-transparent underline decoration-indigo-400 decoration-2 underline-offset-2 transition-all hover:from-indigo-700 hover:to-purple-700"
                            >
                                ចូលគណនីឥឡូវនេះ
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
    layout: null // Disable layout for register page
}
</script>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import * as yup from 'yup'
import { Label } from '@/components/ui/label'
import FlashMessage from '@/Components/FlashMessage.vue'

// Show password toggles
const showPassword = ref(false)
const showPasswordConfirmation = ref(false)

// Yup validation schema
const validationSchema = yup.object().shape({
    name: yup.string().required('ឈ្មោះត្រូវបានទាមទារ').min(2, 'ឈ្មោះត្រូវមានយ៉ាងហោចណាស់ 2 តួអក្សរ'),
    email: yup.string().required('អ៊ីម៉ែលត្រូវបានទាមទារ').email('អ៊ីម៉ែលមិនត្រឹមត្រូវ'),
    password: yup.string().required('លេខសម្ងាត់ត្រូវបានទាមទារ').min(6, 'លេខសម្ងាត់ត្រូវមានយ៉ាងហោចណាស់ 6 តួអក្សរ'),
    password_confirmation: yup
        .string()
        .required('បញ្ជាក់លេខសម្ងាត់ត្រូវបានទាមទារ')
        .oneOf([yup.ref('password')], 'លេខសម្ងាត់មិនត្រូវគ្នា')
})

// Form data
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

// Handle registration submission
const handleRegister = () => {
    form.post('/register', {
        preserveScroll: true
    })
}
</script>

<style scoped></style>
