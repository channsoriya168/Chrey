<script setup>
    import { cn } from '@/lib/utils'
    import { useVModel } from '@vueuse/core'

    const props = defineProps({
        defaultValue: { type: [String, Number], required: false },
        modelValue: { type: [String, Number], required: false },
        class: { type: null, required: false }
    })

    const emits = defineEmits(['update:modelValue'])

    const modelValue = useVModel(props, 'modelValue', emits, {
        passive: true,
        defaultValue: props.defaultValue
    })
</script>

<template>
    <input v-model="modelValue" :class="cn(
        'ring-offset-background file:text-foreground placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
        '[&:-webkit-autofill]:transition-colors [&:-webkit-autofill]:duration-[5000s] [&:-webkit-autofill]:delay-[5000s]',
        props.class
    )
        " />
</template>
