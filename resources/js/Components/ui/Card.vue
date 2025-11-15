<template>
    <div :class="cn('bg-card text-card-foreground rounded-lg border shadow-sm', $attrs.class)" v-bind="$attrs">
        <slot />
    </div>
</template>

<script setup>
import { cn } from '@/lib/utils'
</script>
