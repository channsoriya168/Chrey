<template>
    <th
        :class="
            cn(
                'text-muted-foreground h-12 px-4 text-left align-middle font-medium [&:has([role=checkbox])]:pr-0',
                $attrs.class
            )
        "
        v-bind="$attrs"
    >
        <slot />
    </th>
</template>

<script setup>
import { cn } from '@/lib/utils'
</script>
