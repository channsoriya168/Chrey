<script setup>
import { reactiveOmit } from '@vueuse/core'
import { DialogTitle } from 'reka-ui'
import { cn } from '@/lib/utils'

const props = defineProps({
    asChild: { type: Boolean, required: false },
    as: { type: null, required: false },
    class: { type: null, required: false }
})

const delegatedProps = reactiveOmit(props, 'class')
</script>

<template>
    <DialogTitle :class="cn('text-foreground text-lg font-semibold', props.class)" v-bind="delegatedProps">
        <slot />
    </DialogTitle>
</template>
