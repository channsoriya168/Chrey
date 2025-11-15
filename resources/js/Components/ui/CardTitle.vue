<template>
    <h3 :class="cn('text-2xl leading-none font-semibold tracking-tight', $attrs.class)" v-bind="$attrs">
        <slot />
    </h3>
</template>

<script setup>
import { cn } from '@/lib/utils'
</script>
