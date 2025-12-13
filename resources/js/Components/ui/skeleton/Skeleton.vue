<script setup>
import { cn } from '@/lib/utils'

const props = defineProps({
    class: { type: null, required: false }
})
</script>

<template>
    <div :class="cn('bg-muted animate-pulse rounded-md', props.class)" />
</template>
