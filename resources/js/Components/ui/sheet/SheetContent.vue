<script setup>
import { reactiveOmit } from '@vueuse/core'
import { X } from 'lucide-vue-next'
import { DialogClose, DialogContent, DialogOverlay, DialogPortal, useForwardPropsEmits } from 'reka-ui'
import { cn } from '@/lib/utils'
import { sheetVariants } from '.'

defineOptions({
    inheritAttrs: false
})

const props = defineProps({
    class: { type: null, required: false },
    side: { type: null, required: false },
    forceMount: { type: Boolean, required: false },
    disableOutsidePointerEvents: { type: Boolean, required: false },
    asChild: { type: Boolean, required: false },
    as: { type: null, required: false }
})

const emits = defineEmits([
    'escapeKeyDown',
    'pointerDownOutside',
    'focusOutside',
    'interactOutside',
    'openAutoFocus',
    'closeAutoFocus'
])

const delegatedProps = reactiveOmit(props, 'class', 'side')

const forwarded = useForwardPropsEmits(delegatedProps, emits)
</script>

<template>
    <DialogPortal>
        <DialogOverlay
            class="data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-100 data-[state=open]:fade-in-0 fixed inset-0 z-50 bg-black/80 transition-all data-[state=closed]:duration-500 data-[state=open]:duration-700"
        />
        <DialogContent :class="cn(sheetVariants({ side }), props.class)" v-bind="{ ...forwarded, ...$attrs }">
            <slot />

            <DialogClose
                class="ring-offset-background focus:ring-ring data-[state=open]:bg-secondary absolute top-4 right-4 rounded-sm opacity-70 transition-opacity hover:opacity-100 focus:ring-2 focus:ring-offset-2 focus:outline-none disabled:pointer-events-none"
            >
                <X class="text-muted-foreground h-4 w-4" />
            </DialogClose>
        </DialogContent>
    </DialogPortal>
</template>
