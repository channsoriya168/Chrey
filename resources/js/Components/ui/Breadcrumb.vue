<template>
  <nav :class="cn('flex', $attrs.class)" aria-label="breadcrumb" v-bind="$attrs">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
      <li v-for="(item, index) in items" :key="index" class="inline-flex items-center">
        <template v-if="index === 0">
          <component :is="item.href ? 'a' : 'span'" 
                     :href="item.href" 
                     :class="cn('inline-flex items-center text-sm font-medium', 
                               item.disabled ? 'text-muted-foreground cursor-default' : 'text-primary hover:text-primary/80')">
            {{ item.title }}
          </component>
        </template>
        <template v-else>
          <ChevronRight class="w-4 h-4 text-muted-foreground mx-1" />
          <component :is="item.href && !item.disabled ? 'a' : 'span'" 
                     :href="item.href && !item.disabled ? item.href : undefined" 
                     :class="cn('ml-1 text-sm font-medium', 
                               item.disabled ? 'text-muted-foreground cursor-default' : 'text-primary hover:text-primary/80')">
            {{ item.title }}
          </component>
        </template>
      </li>
    </ol>
  </nav>
</template>

<script setup>
import { cn } from '@/lib/utils'
import { ChevronRight } from 'lucide-vue-next'

defineProps({
  items: {
    type: Array,
    default: () => []
  }
})
</script>