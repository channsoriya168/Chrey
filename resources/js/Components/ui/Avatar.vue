<template>
    <div
        :class="cn('relative flex shrink-0 overflow-hidden rounded-full', avatarVariants({ size }), $attrs.class)"
        v-bind="$attrs"
    >
        <slot />
    </div>
</template>

<script setup>
import { cn } from '@/lib/utils'
import { cva } from 'class-variance-authority'

const avatarVariants = cva('relative flex shrink-0 overflow-hidden rounded-full', {
    variants: {
        size: {
            sm: 'h-8 w-8',
            default: 'h-10 w-10',
            lg: 'h-12 w-12'
        }
    },
    defaultVariants: {
        size: 'default'
    }
})

defineProps({
    size: {
        type: String,
        default: 'default'
    }
})
</script>
