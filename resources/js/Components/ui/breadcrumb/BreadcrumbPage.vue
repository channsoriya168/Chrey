<script setup>
import { cn } from '@/lib/utils'

const props = defineProps({
    class: { type: null, required: false }
})
</script>

<template>
    <span role="link" aria-disabled="true" aria-current="page" :class="cn('text-foreground font-normal', props.class)">
        <slot />
    </span>
</template>
