<template>

    <Head title="Products" />
    <v-container>
        <v-btn @click="createCallBack" class="mb-3" color="primary">Create Product</v-btn>
    </v-container>

</template>

<script setup>
    import { Head } from '@inertiajs/vue3'
    import { visitModal } from '@inertiaui/modal-vue'

    const createCallBack = () => {
        visitModal(route('dashboard.products.create'))
    }
</script>