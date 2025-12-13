<script setup>
import { reactiveOmit } from '@vueuse/core'
import { Separator } from 'reka-ui'
import { cn } from '@/lib/utils'

const props = defineProps({
    orientation: { type: String, required: false, default: 'horizontal' },
    decorative: { type: Boolean, required: false, default: true },
    asChild: { type: Boolean, required: false },
    as: { type: null, required: false },
    class: { type: null, required: false }
})

const delegatedProps = reactiveOmit(props, 'class')
</script>

<template>
    <Separator
        v-bind="delegatedProps"
        :class="
            cn('bg-border shrink-0', props.orientation === 'horizontal' ? 'h-px w-full' : 'h-full w-px', props.class)
        "
    />
</template>
