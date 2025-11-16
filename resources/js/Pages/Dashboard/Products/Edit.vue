<template>
    <Head title="កែប្រែផលិតផល" />

    <div class="space-y-6 pb-32">
        <!-- Breadcrumb -->
        <Breadcrumb>
            <BreadcrumbList>
                <BreadcrumbItem>
                    <BreadcrumbLink :href="route('dashboard.index')">
                        <span class="khmer-text">ទំព័រដើម</span>
                    </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator />
                <BreadcrumbItem>
                    <BreadcrumbLink :href="route('dashboard.products.index')">
                        <span class="khmer-text">ផលិតផល</span>
                    </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator />
                <BreadcrumbItem>
                    <BreadcrumbPage class="khmer-text">កែប្រែ</BreadcrumbPage>
                </BreadcrumbItem>
            </BreadcrumbList>
        </Breadcrumb>

        <!-- Header -->
        <div>
            <h1 class="khmer-text text-2xl font-bold text-gray-900">កែប្រែផលិតផល</h1>
            <p class="khmer-text mt-1 text-sm text-gray-600">កែប្រែព័ត៌មានផលិតផល</p>
        </div>

        <!-- Form -->
        <ProductForm
            v-model:form="form"
            v-model:image-previews="imagePreviews"
            v-model:existing-image-urls="existingImageUrls"
            submit-text="រក្សាទុក"
            processing-text="កំពុងរក្សាទុក..."
            @submit="handleSubmit"
            @cancel="handleCancel"
        />
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { router, Head, useForm } from '@inertiajs/vue3'
import ProductForm from '@/Components/Dashboard/ProductForm.vue'
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator
} from '@/components/ui/breadcrumb'

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
        ? props.product.image_url.map(url => `/storage/${url}`)
        : []
)
const existingImageUrls = ref(
    Array.isArray(props.product?.image_url) ? [...props.product.image_url] : []
)

const handleSubmit = () => {
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
