<template>
    <Head title="បង្កើតផលិតផលថ្មី" />

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
                    <BreadcrumbPage class="khmer-text">បង្កើតថ្មី</BreadcrumbPage>
                </BreadcrumbItem>
            </BreadcrumbList>
        </Breadcrumb>

        <!-- Header -->
        <div>
            <h1 class="khmer-text text-2xl font-bold text-gray-900">បង្កើតផលិតផលថ្មី</h1>
            <p class="khmer-text mt-1 text-sm text-gray-600">បំពេញព័ត៌មានដើម្បីបង្កើតផលិតផលថ្មី</p>
        </div>

        <!-- Form -->
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
