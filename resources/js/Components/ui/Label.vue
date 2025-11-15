<template>
    <label
        :class="
            cn(
                'text-sm leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70',
                $attrs.class
            )
        "
        v-bind="$attrs"
    >
        <slot />
    </label>
</template>

<script setup>
import { cn } from '@/lib/utils'
</script>
