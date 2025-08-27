<template>
  <tr :class="cn('border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted', $attrs.class)" v-bind="$attrs">
    <slot />
  </tr>
</template>

<script setup>
import { cn } from '@/lib/utils'
</script>