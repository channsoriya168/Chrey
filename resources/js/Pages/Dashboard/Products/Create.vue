<template>
    <Head title="បង្កើតផលិតផលថ្មី" />

    <div class="space-y-6 pb-32">
        <!-- Breadcrumb & Back Button -->
        <div class="flex items-center justify-between">
            <DashboardBreadcrumb
                :items="[
                    { label: 'ផ្ទាំងគ្រប់គ្រង', href: route('dashboard.index') },
                    { label: 'ផលិតផល', href: route('dashboard.products.index') },
                    { label: 'បង្កើតថ្មី' }
                ]"
            />
            <Button variant="outline" @click="handleCancel" class="khmer-text inline-flex items-center gap-2">
                <ChevronLeft class="mr-2 h-4 w-4" />
                ត្រឡប់ក្រោយ
            </Button>
        </div>

        <!-- Form Card -->
        <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="mb-6 border-b border-gray-200 pb-4">
                <h2 class="khmer-text mb-1 text-2xl font-bold text-gray-900">បង្កើតផលិតផលថ្មី</h2>
            </div>
            <vee-form
                :validation-schema="validationSchema"
                :initial-values="form"
                @submit="handleSubmit"
                v-slot="{ errors: veeErrors }"
            >
                <ProductForm
                    v-model:form="form"
                    v-model:image-previews="imagePreviews"
                    v-model:existing-image-urls="existingImageUrls"
                    :vee-errors="veeErrors"
                    submit-text="បង្កើត"
                    processing-text="កំពុងបង្កើត..."
                    @cancel="handleCancel"
                />
            </vee-form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { router, Head, useForm } from '@inertiajs/vue3'
import * as yup from 'yup'
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

// Validation Schema
const validationSchema = yup.object({
    code: yup.string().required('សូមបញ្ចូលលេខកូដផលិតផល').min(2, 'លេខកូដត្រូវតែមានយ៉ាងហោចណាស់ 2 តួអក្សរ'),
    name: yup.string().required('សូមបញ្ចូលឈ្មោះផលិតផល').min(3, 'ឈ្មោះត្រូវតែមានយ៉ាងហោចណាស់ 3 តួអក្សរ'),
    description: yup.string().nullable(),
    price: yup
        .number()
        .required('សូមបញ្ចូលតម្លៃ')
        .positive('តម្លៃត្រូវតែជាលេខវិជ្ជមាន')
        .typeError('សូមបញ្ចូលលេខត្រឹមត្រូវ'),
    discount_price_percent: yup
        .number()
        .nullable()
        .transform((value, originalValue) => (originalValue === '' ? null : value))
        .min(0, 'បញ្ចុះតម្លៃត្រូវតែធំជាង ឬស្មើ 0')
        .max(100, 'បញ្ចុះតម្លៃត្រូវតែតូចជាង ឬស្មើ 100'),
    stock: yup
        .number()
        .required('សូមបញ្ចូលចំនួនស្តុក')
        .integer('ចំនួនស្តុកត្រូវតែជាលេខគត់')
        .min(0, 'ចំនួនស្តុកត្រូវតែធំជាង ឬស្មើ 0')
        .typeError('សូមបញ្ចូលលេខត្រឹមត្រូវ'),
    size: yup.string().required('សូមជ្រើសរើសទំហំ').oneOf(['តូច', 'មធ្យម', 'ធំ'], 'សូមជ្រើសរើសទំហំត្រឹមត្រូវ')
})

const handleSubmit = (values) => {
    form.post(route('dashboard.products.store'))
}

const handleCancel = () => {
    router.visit(route('dashboard.products.index'))
}
</script>
