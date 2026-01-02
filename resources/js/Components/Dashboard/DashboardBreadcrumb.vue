<template>
    <nav aria-label="breadcrumb">
        <ol class="flex items-center gap-2 text-sm">
            <li v-for="(item, index) in items" :key="index" class="flex items-center gap-2">
                <a v-if="item.href" :href="item.href" class="khmer-text text-purple-400 hover:text-purple-300 transition-colors">
                    {{ item.label }}
                </a>
                <span v-else class="khmer-text text-gray-200 font-medium">
                    {{ item.label }}
                </span>

                <svg
                    v-if="index < items.length - 1"
                    class="h-4 w-4 text-gray-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </li>
        </ol>
    </nav>
</template>

<script setup>
defineProps({
    items: {
        type: Array,
        required: true
    }
})
</script>
