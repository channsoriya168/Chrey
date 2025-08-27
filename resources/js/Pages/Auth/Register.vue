<template>
    <v-container>
        <v-card class="w-lg">
            <v-card-title class="text-center">
                Register
            </v-card-title>
            <v-card-text>
                <vee-form class="pa-4" :validation-schema="schema" @submit.prevent="register">
                    <vee-field name="name" v-slot="{ field, errors }">
                        <v-text-field v-bind="field" variant="outlined" label="Name" required name="name"
                            :error-messages="errors" v-model="item.name"></v-text-field>
                    </vee-field>
                    <vee-field name="email" v-slot="{ field, errors }">
                        <v-text-field v-bind="field" variant="outlined" label="Email" type="email" required name="email"
                            :error-messages="errors" v-model="item.email"></v-text-field>
                    </vee-field>
                    <vee-field name="password" v-slot="{ field, errors }">
                        <v-text-field v-bind="field" variant="outlined" label="Password" type="password" required
                            name="password" :error-messages="errors" v-model="item.password"></v-text-field>
                    </vee-field>
                    <vee-field name="password_confirmation" v-slot="{ field, errors }">
                        <v-text-field v-bind="field" variant="outlined" label="Confirm Password" type="password"
                            required name="password_confirmation" :error-messages="errors"
                            v-model="item.password_confirmation"></v-text-field>
                    </vee-field>
                    <v-btn color="primary" type="submit" class="w-100 mb-3">Register</v-btn>
                    <div class="text-center">
                        <v-btn variant="text" @click="$inertia.visit(route('login'))">
                            Already have an account? Login
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
    import { router } from '@inertiajs/vue3';

    const schema = yup.object().shape({
        name: yup.string().required(),
        email: yup.string().email().required(),
        password: yup.string().min(8).required(),
        password_confirmation: yup
            .string()
            .oneOf([yup.ref("password"), null])
            .required(),
    });

    const item = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });


    const register = () => {
        item.post(route('register.store'), {
            onSuccess: () => {
                console.log('Registration successful');
            },
            onError: (errors) => {
                // Handle registration errors
            }
        });
    };

</script>