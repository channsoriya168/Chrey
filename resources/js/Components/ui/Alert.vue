<template>
  <div
    :class="cn(alertVariants({ variant }), $attrs.class)"
    v-bind="$attrs"
    role="alert"
  >
    <slot />
  </div>
</template>

<script setup>
import { cn } from '@/lib/utils'
import { cva } from 'class-variance-authority'

const alertVariants = cva(
  'relative w-full rounded-lg border p-4',
  {
    variants: {
      variant: {
        default: 'bg-background text-foreground',
        destructive: 'border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive bg-red-50',
        success: 'border-green-500/50 text-green-900 dark:border-green-500 bg-green-50',
        warning: 'border-yellow-500/50 text-yellow-900 dark:border-yellow-500 bg-yellow-50',
      },
    },
    defaultVariants: {
      variant: 'default',
    },
  }
)

defineProps({
  variant: {
    type: String,
    default: 'default'
  }
})
</script>
