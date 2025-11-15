<template>
    <div class="khmer-text flex min-h-screen items-center justify-center bg-gray-50 px-4 py-12 sm:px-6 lg:px-8">
        <Head title="បង្កើតគណនី" />

        <div class="w-full max-w-md space-y-8">
            <!-- Header -->
            <div>
                <h2 class="khmer-text mt-6 text-center text-3xl font-extrabold text-gray-900">បង្កើតគណនី</h2>
                <p class="khmer-text mt-2 text-center text-sm text-gray-600">
                    ឬ
                    <Link href="/login" class="font-medium text-blue-600 hover:text-blue-500"> ចូលគណនី </Link>
                </p>
            </div>

            <!-- Flash Messages -->
            <FlashMessage />

            <!-- Register Form -->
            <Card>
                <CardContent class="pt-6">
                    <form @submit.prevent="register" class="space-y-4">
                        <div>
                            <Label for="name">ឈ្មោះ</Label>
                            <Input
                                id="name"
                                type="text"
                                v-model="item.name"
                                :class="{ 'border-red-500': item.errors.name }"
                                class="mt-1"
                                autocomplete="name"
                            />
                            <p v-if="item.errors.name" class="mt-1 text-sm text-red-500">{{ item.errors.name }}</p>
                        </div>
                        <div>
                            <Label for="email">អ៊ីម៉ែល</Label>
                            <Input
                                id="email"
                                type="email"
                                v-model="item.email"
                                :class="{ 'border-red-500': item.errors.email }"
                                class="mt-1"
                                autocomplete="email"
                            />
                            <p v-if="item.errors.email" class="mt-1 text-sm text-red-500">{{ item.errors.email }}</p>
                        </div>
                        <div>
                            <Label for="password">លេខសម្ងាត់</Label>
                            <Input
                                id="password"
                                type="password"
                                v-model="item.password"
                                :class="{ 'border-red-500': item.errors.password }"
                                class="mt-1"
                                autocomplete="new-password"
                            />
                            <p v-if="item.errors.password" class="mt-1 text-sm text-red-500">
                                {{ item.errors.password }}
                            </p>
                        </div>
                        <div>
                            <Label for="password_confirmation">បញ្ជាក់លេខសម្ងាត់</Label>
                            <Input
                                id="password_confirmation"
                                type="password"
                                v-model="item.password_confirmation"
                                :class="{ 'border-red-500': item.errors.password_confirmation }"
                                class="mt-1"
                                autocomplete="new-password"
                            />
                            <p v-if="item.errors.password_confirmation" class="mt-1 text-sm text-red-500">
                                {{ item.errors.password_confirmation }}
                            </p>
                        </div>
                        <Button type="submit" class="w-full bg-blue-600 hover:bg-blue-700" :disabled="item.processing">
                            {{ item.processing ? 'កំពុងបង្កើត...' : 'បង្កើតគណនី' }}
                        </Button>
                    </form>
                </CardContent>
            </Card>
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
import Card from '@/Components/ui/Card.vue'
import CardContent from '@/Components/ui/CardContent.vue'
import Input from '@/Components/ui/Input.vue'
import Label from '@/Components/ui/Label.vue'
import Button from '@/Components/ui/Button.vue'
import FlashMessage from '@/Components/FlashMessage.vue'

const item = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const register = () => {
    item.post('/register', {
        onSuccess: () => {
            // handle success
        },
        onError: (errors) => {
            // handle errors
        }
    })
}
</script>
