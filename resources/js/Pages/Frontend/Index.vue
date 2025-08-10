<template>
    <v-container>
        <p v-for="category in categories" :key="category.id">{{ category.name }}</p>
    </v-container>
</template>

<script setup>
    import { ref } from 'vue';
    import axios from 'axios';
    const categories = ref([]);

    const fetchCategories = async () => {
        const response = await axios.get('/categories');
        categories.value = response.data.categories;
    };

    fetchCategories();
</script>