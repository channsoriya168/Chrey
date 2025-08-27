<template>
  <thead :class="cn('[&_tr]:border-b', $attrs.class)" v-bind="$attrs">
    <slot />
  </thead>
</template>

<script setup>
import { cn } from '@/lib/utils'
</script>