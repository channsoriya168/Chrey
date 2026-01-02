<template>
    <div class="group space-y-2">
        <!-- Label -->
        <Label v-if="label" :for="id" class="khmer-text flex items-center gap-2 text-sm font-bold text-slate-200">
            {{ label }}
            <span v-if="required" class="text-base text-red-500">*</span>
        </Label>

        <!-- Input Field -->
        <Input v-if="type !== 'textarea' && type !== 'select'" :id="id" :type="type" :placeholder="placeholder"
            :modelValue="modelValue" @update:modelValue="$emit('update:modelValue', $event)" :class="inputClasses"
            v-bind="$attrs" />

        <!-- Textarea Field -->
        <Textarea v-else-if="type === 'textarea'" :id="id" :placeholder="placeholder" :modelValue="modelValue"
            @update:modelValue="$emit('update:modelValue', $event)" :class="textareaClasses" v-bind="$attrs" />

        <!-- Select Field -->
        <Select v-else-if="type === 'select'" :modelValue="modelValue"
            @update:modelValue="$emit('update:modelValue', $event)">
            <SelectTrigger :id="id" :class="selectClasses">
                <SelectValue :placeholder="placeholder" />
            </SelectTrigger>
            <SelectContent>
                <SelectItem v-for="option in options" :key="option.value" :value="option.value"
                    :class="option.className || ''">
                    {{ option.label }}
                </SelectItem>
            </SelectContent>
        </Select>

        <!-- Error Message -->
        <p v-if="error" class="animate-shake ml-1 flex items-center gap-1.5 text-xs text-red-600">
            <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <span class="font-medium">{{ error }}</span>
        </p>

        <!-- Help Text -->
        <p v-if="helpText && !error" class="ml-1 text-xs text-gray-500">
            {{ helpText }}
        </p>
    </div>
</template>

<script setup>
    import { Input } from '@/Components/ui/input'
    import { Label } from '@/Components/ui/label'
    import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select'
    import { Textarea } from '@/Components/ui/textarea'
    import { computed } from 'vue'

    const props = defineProps({
        id: {
            type: String,
            required: true
        },
        label: {
            type: String,
            default: ''
        },
        type: {
            type: String,
            default: 'text'
        },
        placeholder: {
            type: String,
            default: ''
        },
        modelValue: {
            type: [String, Number],
            default: ''
        },
        error: {
            type: String,
            default: ''
        },
        required: {
            type: Boolean,
            default: false
        },
        helpText: {
            type: String,
            default: ''
        },
        options: {
            type: Array,
            default: () => []
        }
    })

    defineEmits(['update:modelValue'])

    const baseInputClasses =
        'h-11 text-sm rounded-lg border-2 transition-all duration-300 font-medium placeholder:text-gray-400 placeholder:font-normal text-white bg-transparent'

    const inputClasses = computed(() => {
        return [
            baseInputClasses,
            props.error
                ? 'border-red-400 shadow-sm shadow-red-500/20 focus:border-red-500 focus:ring-4 focus:ring-red-500/20'
                : 'border-gray-600 hover:border-blue-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 shadow-sm hover:shadow-md focus:shadow-lg'
        ]
    })

    const textareaClasses = computed(() => {
        return [
            'min-h-[80px] text-sm rounded-lg border-2 transition-all duration-300 font-medium resize-none placeholder:text-gray-400 placeholder:font-normal text-white bg-transparent',
            props.error
                ? 'border-red-400 shadow-sm shadow-red-500/20 focus:border-red-500 focus:ring-4 focus:ring-red-500/20'
                : 'border-gray-600 hover:border-blue-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 shadow-sm hover:shadow-md focus:shadow-lg'
        ]
    })

    const selectClasses = computed(() => {
        return [
            baseInputClasses,
            props.error
                ? 'border-red-400 shadow-sm shadow-red-500/20 focus:border-red-500 focus:ring-4 focus:ring-red-500/20'
                : 'border-gray-600 hover:border-blue-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 shadow-sm hover:shadow-md focus:shadow-lg'
        ]
    })
</script>
