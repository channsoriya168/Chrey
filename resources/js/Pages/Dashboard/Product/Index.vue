<template>
    <div class="space-y-4">
        <Breadcrumb 
            class="bg-primary text-white px-4 py-2 rounded-md border" 
            :items="breadcrumbsItems" 
        />
        
        <Card class="flex items-center justify-between p-6">
            <CardTitle class="khmer-text">បង្កើតផលិតផលថ្មី</CardTitle>
            <Button @click="createProductCallback()" class="khmer-text">
                បង្កើតផលិតផល
            </Button>
        </Card>
        
        <CardContent class="p-0">
            <!-- Form for creating a new product will go here -->
        </CardContent>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Card from '@/components/ui/Card.vue';
import CardTitle from '@/components/ui/CardTitle.vue';
import CardContent from '@/components/ui/CardContent.vue';
import Button from '@/components/ui/Button.vue';
import Breadcrumb from '@/components/ui/Breadcrumb.vue';

const breadcrumbsItems = ref([
    {
        title: 'ផលិតផល',
        disabled: true,
        href: '/dashboard/products'
    }
]);

const createProductCallback = () => {
    router.visit(route('dashboard.products.create'));
};
</script>
