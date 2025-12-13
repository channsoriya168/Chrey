<template>
    <Head title="កែប្រែផលិតផល" />

    <div class="space-y-6 pb-32">
        <!-- Breadcrumb & Back Button -->
        <div class="flex items-center justify-between">
            <DashboardBreadcrumb
                :items="[
                    { label: 'ទំព័រដើម', href: route('dashboard.index') },
                    { label: 'ផលិតផល', href: route('dashboard.products.index') },
                    { label: 'កែប្រែ' }
                ]"
            />
            <Button variant="outline" @click="handleCancel" class="khmer-text">
                <ChevronLeft class="mr-2 h-4 w-4" />
                ត្រឡប់ក្រោយ
            </Button>
        </div>

        <!-- Form Card -->
        <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="mb-6 border-b border-gray-200 pb-4">
                <h2 class="khmer-text mb-1 text-2xl font-bold text-gray-900">កែប្រែផលិតផល</h2>
                <p class="text-gray-600">កែប្រែព័ត៍មានខាងក្រោមដើម្បីធ្វើបច្ចុប្បន្នភាពផលិតផល</p>
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
                    submit-text="រក្សាទុក"
                    processing-text="កំពុងរក្សាទុក..."
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

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
})

const form = useForm({
    name: props.product?.name || '',
    code: props.product?.code || '',
    description: props.product?.description || '',
    price: props.product?.price || '',
    discount_price_percent: props.product?.discount_price_percent || '',
    stock: props.product?.stock || '',
    size: props.product?.size || 'មធ្យម',
    images: [],
    existing_images: Array.isArray(props.product?.image_url) ? [...props.product.image_url] : []
})

const imagePreviews = ref(
    Array.isArray(props.product?.image_url) && props.product.image_url.length > 0
        ? props.product.image_url.map((url) => `/storage/${url}`)
        : []
)
const existingImageUrls = ref(Array.isArray(props.product?.image_url) ? [...props.product.image_url] : [])

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
    form.transform((data) => {
        const formData = new FormData()

        // Add all form fields
        formData.append('_method', 'PUT')
        formData.append('name', data.name || '')
        formData.append('code', data.code || '')
        formData.append('description', data.description || '')
        formData.append('price', data.price || '')
        formData.append('discount_price_percent', data.discount_price_percent || '')
        formData.append('stock', data.stock || '')
        formData.append('size', data.size || '')

        // Add existing images
        if (data.existing_images && Array.isArray(data.existing_images)) {
            data.existing_images.forEach((image, index) => {
                formData.append(`existing_images[${index}]`, image)
            })
        }

        // Add new images
        if (data.images && Array.isArray(data.images)) {
            data.images.forEach((image) => {
                formData.append('images[]', image)
            })
        }

        return formData
    }).post(route('dashboard.products.update', props.product.id), {
        preserveScroll: true,
        onError: (errors) => {
            console.log('Form errors:', errors)
        }
    })
}

const handleCancel = () => {
    router.visit(route('dashboard.products.index'))
}
</script>
