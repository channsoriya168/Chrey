<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <Card class="w-full max-w-md p-6 space-y-6">
            <CardHeader>
                <CardTitle class="text-center">Register</CardTitle>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="register" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium">Name</label>
                        <input id="name" type="text" v-model="item.name" required
                            class="input input-bordered w-full mt-1" :class="{ 'border-red-500': item.errors.name }"
                            autocomplete="name" />
                        <div v-if="item.errors.name" class="text-red-500 text-xs mt-1">{{ item.errors.name }}</div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input id="email" type="email" v-model="item.email" required
                            class="input input-bordered w-full mt-1" :class="{ 'border-red-500': item.errors.email }"
                            autocomplete="email" />
                        <div v-if="item.errors.email" class="text-red-500 text-xs mt-1">{{ item.errors.email }}</div>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium">Password</label>
                        <input id="password" type="password" v-model="item.password" required
                            class="input input-bordered w-full mt-1" :class="{ 'border-red-500': item.errors.password }"
                            autocomplete="new-password" />
                        <div v-if="item.errors.password" class="text-red-500 text-xs mt-1">{{ item.errors.password }}
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
                        <input id="password_confirmation" type="password" v-model="item.password_confirmation" required
                            class="input input-bordered w-full mt-1"
                            :class="{ 'border-red-500': item.errors.password_confirmation }"
                            autocomplete="new-password" />
                        <div v-if="item.errors.password_confirmation" class="text-red-500 text-xs mt-1">{{
                            item.errors.password_confirmation }}</div>
                    </div>
                    <Button type="submit" class="w-full">Register</Button>
                </form>
                <div class="text-center mt-4">
                    <Button variant="link" @click="$inertia.visit(route('login'))">
                        Already have an account? Login
                    </Button>
                </div>
            </CardContent>
        </Card>
    </div>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import Card from '@/components/ui/Card.vue';
    import CardHeader from '@/components/ui/CardHeader.vue';
    import CardTitle from '@/components/ui/CardTitle.vue';
    import CardContent from '@/components/ui/CardContent.vue';
    import Button from '@/components/ui/Button.vue';

    const item = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const register = () => {
        item.post(route('register.store'), {
            onSuccess: () => {
                // handle success
            },
            onError: (errors) => {
                // handle errors
            }
        });
    };
</script>
