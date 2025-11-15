<template>
    <button
        :class="
            cn(
                'text-popover-foreground hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block w-full px-4 py-2 text-left text-sm focus:outline-none',
                $attrs.class
            )
        "
        role="menuitem"
        v-bind="$attrs"
        @click="$emit('click', $event)"
    >
        <slot />
    </button>
</template>

<script setup>
import { cn } from '@/lib/utils'

defineEmits(['click'])
</script>
