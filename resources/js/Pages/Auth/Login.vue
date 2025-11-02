<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 khmer-text">

        <Head title="ចូលគណនី" />

        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 khmer-text">
                    ចូលគណនី
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 khmer-text">
                    ឬ
                    <Link href="/register" class="font-medium text-blue-600 hover:text-blue-500">
                    បង្កើតគណនីថ្មី
                    </Link>
                </p>
            </div>

            <!-- Flash Messages -->
            <FlashMessage />

            <!-- Login Form -->
            <Card>
                <CardContent class="pt-6">
                    <vee-form @submit="handleLogin" :validation-schema="validationSchema"
                        v-slot="{ errors: formErrors }">
                        <div class="space-y-4">
                            <!-- Email Field -->
                            <vee-field name="email" v-slot="{ field, errors }">
                                <div>
                                    <Label for="email">អ៊ីម៉ែល</Label>
                                    <Input v-bind="field" v-model="form.email" id="email" type="email"
                                        placeholder="name@example.com" :class="{ 'border-red-500': errors.length }"
                                        class="mt-1" />
                                    <p v-if="errors.length" class="mt-1 text-sm text-red-500">
                                        {{ errors[0] }}
                                    </p>
                                </div>
                            </vee-field>

                            <!-- Password Field -->
                            <vee-field name="password" v-slot="{ field, errors }">
                                <div>
                                    <Label for="password">លេខសម្ងាត់</Label>
                                    <Input v-bind="field" v-model="form.password" id="password" type="password"
                                        placeholder="••••••••" :class="{ 'border-red-500': errors.length }"
                                        class="mt-1" />
                                    <p v-if="errors.length" class="mt-1 text-sm text-red-500">
                                        {{ errors[0] }}
                                    </p>
                                </div>
                            </vee-field>

                            <!-- Remember Me -->
                            <div class="flex items-center">
                                <input id="remember" v-model="form.remember" type="checkbox"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                                <Label for="remember" class="ml-2 block text-sm text-gray-900">
                                    ចងចាំខ្ញុំ
                                </Label>
                            </div>

                            <!-- Submit Button -->
                            <Button type="submit" class="w-full bg-blue-600 hover:bg-blue-700"
                                :disabled="form.processing">
                                {{ form.processing ? 'កំពុងចូល...' : 'ចូលគណនី' }}
                            </Button>
                        </div>
                    </vee-form>
                </CardContent>
            </Card>
        </div>
    </div>
</template>

<script>
    export default {
        layout: null, // Disable layout for login page
    }
</script>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import { Head, Link } from '@inertiajs/vue3';
    import * as yup from 'yup';
    import Card from '@/Components/ui/Card.vue';
    import CardContent from '@/Components/ui/CardContent.vue';
    import Input from '@/Components/ui/Input.vue';
    import Label from '@/Components/ui/Label.vue';
    import Button from '@/Components/ui/Button.vue';
    import FlashMessage from '@/Components/FlashMessage.vue';

    // Yup validation schema
    const validationSchema = yup.object().shape({
        email: yup
            .string()
            .required('អ៊ីម៉ែលត្រូវបានទាមទារ')
            .email('អ៊ីម៉ែលមិនត្រឹមត្រូវ'),
        password: yup
            .string()
            .required('លេខសម្ងាត់ត្រូវបានទាមទារ')
            .min(6, 'លេខសម្ងាត់ត្រូវមានយ៉ាងហោចណាស់ 6 តួអក្សរ'),
    });

    // Form data
    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    // Handle login submission
    const handleLogin = () => {
        form.post('/login', {
            preserveScroll: true,
        });
    };
</script>

<style scoped>
    /* Override layout if needed */
</style>
