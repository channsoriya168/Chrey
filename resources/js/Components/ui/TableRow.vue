<template>
    <tr
        :class="cn('hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors', $attrs.class)"
        v-bind="$attrs"
    >
        <slot />
    </tr>
</template>

<script setup>
import { cn } from '@/lib/utils'
</script>
