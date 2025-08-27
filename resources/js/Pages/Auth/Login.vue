<template>
    <v-container>
        <v-card class="w-lg">
            <v-card-title class="text-center">
                Login
            </v-card-title>
            <v-card-text>
                <vee-form class="pa-4" :validation-schema="schema" @submit.prevent="login">
                    <vee-field name="email" v-slot="{ field, errors }">
                        <v-text-field v-bind="field" variant="outlined" label="Email" type="email" required name="email"
                            :error-messages="errors" v-model="item.email"></v-text-field>
                    </vee-field>
                    <vee-field name="password" v-slot="{ field, errors }">
                        <v-text-field v-bind="field" variant="outlined" label="Password" type="password" required
                            name="password" :error-messages="errors" v-model="item.password"></v-text-field>
                    </vee-field>
                    <v-btn color="primary" type="submit" class="w-100 mb-3">Login</v-btn>
                    <div class="text-center">
                        <v-btn variant="text" @click="$inertia.visit(route('register'))">
                            Don't have an account? Register
                        </v-btn>
                    </div>
                </vee-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import * as yup from 'yup';

    const schema = yup.object().shape({
        email: yup.string().email().required(),
        password: yup.string().required(),
    });

    const item = useForm({
        email: '',
        password: '',
    });

    const login = () => {
        item.post(route('login.store'), {
            onSuccess: () => {
                console.log('Login successful');
            },
            onError: (errors) => {
                console.log('Login errors:', errors);
            }
        });
    };
</script>