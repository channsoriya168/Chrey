<template>
    <Head title="បង្កើតផលិតផលថ្មី" />

    <div class="space-y-6 pb-32">
        <!-- Breadcrumb & Back Button -->
        <div class="flex items-center justify-between">
            <DashboardBreadcrumb
                :items="[
                    { label: 'ទំព័រដើម', href: route('dashboard.index') },
                    { label: 'ផលិតផល', href: route('dashboard.products.index') },
                    { label: 'បង្កើតថ្មី' }
                ]"
            />
            <Button variant="outline" @click="handleCancel" class="khmer-text">
                <ChevronLeft class="mr-2 h-4 w-4" />
                ត្រឡប់ក្រោយ
            </Button>
        </div>

        <!-- Header Card -->
        <div class="rounded-xl border border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 p-6 shadow-sm">
            <h1 class="khmer-text text-3xl font-bold text-gray-900">បង្កើតផលិតផលថ្មី</h1>
            <p class="khmer-text mt-2 text-sm text-gray-600">បំពេញព័ត៌មានដើម្បីបង្កើតផលិតផលថ្មី</p>
        </div>

        <!-- Form Card -->
        <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
            <ProductForm
                v-model:form="form"
                v-model:image-previews="imagePreviews"
                v-model:existing-image-urls="existingImageUrls"
                submit-text="បង្កើត"
                processing-text="កំពុងបង្កើត..."
                @submit="handleSubmit"
                @cancel="handleCancel"
            />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { router, Head, useForm } from '@inertiajs/vue3'
import ProductForm from '@/Components/Dashboard/ProductForm.vue'
import DashboardBreadcrumb from '@/Components/Dashboard/DashboardBreadcrumb.vue'
import { Button } from '@/Components/ui/button'
import { ChevronLeft } from 'lucide-vue-next'

const form = useForm({
    name: '',
    code: '',
    description: '',
    price: '',
    discount_price_percent: '',
    stock: '',
    size: 'មធ្យម',
    images: [],
    existing_images: []
})

const imagePreviews = ref([])
const existingImageUrls = ref([])

const handleSubmit = () => {
    form.post(route('dashboard.products.store'))
}

const handleCancel = () => {
    router.visit(route('dashboard.products.index'))
}
</script>
