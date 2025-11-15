<template>
    <div class="flex items-center justify-between px-2">
        <div class="text-muted-foreground flex-1 text-sm">
            <slot name="info"> Showing {{ from }} to {{ to }} of {{ total }} results </slot>
        </div>

        <div class="flex items-center space-x-6 lg:space-x-8">
            <div class="flex items-center space-x-2">
                <p class="text-sm font-medium">Rows per page</p>
                <select
                    :value="perPage"
                    @change="$emit('update:perPage', parseInt($event.target.value))"
                    class="border-input focus:ring-ring h-8 w-[70px] rounded-md border bg-transparent px-2 py-1 text-sm focus:ring-2 focus:ring-offset-2 focus:outline-none"
                >
                    <option v-for="size in pageSizes" :key="size" :value="size">
                        {{ size }}
                    </option>
                </select>
            </div>

            <div class="flex w-[100px] items-center justify-center text-sm font-medium">
                Page {{ currentPage }} of {{ lastPage }}
            </div>

            <div class="flex items-center space-x-2">
                <Button
                    variant="outline"
                    size="sm"
                    :disabled="currentPage === 1"
                    @click="$emit('update:currentPage', 1)"
                >
                    <ChevronsLeft class="h-4 w-4" />
                </Button>

                <Button
                    variant="outline"
                    size="sm"
                    :disabled="currentPage === 1"
                    @click="$emit('update:currentPage', currentPage - 1)"
                >
                    <ChevronLeft class="h-4 w-4" />
                </Button>

                <Button
                    variant="outline"
                    size="sm"
                    :disabled="currentPage === lastPage"
                    @click="$emit('update:currentPage', currentPage + 1)"
                >
                    <ChevronRight class="h-4 w-4" />
                </Button>

                <Button
                    variant="outline"
                    size="sm"
                    :disabled="currentPage === lastPage"
                    @click="$emit('update:currentPage', lastPage)"
                >
                    <ChevronsRight class="h-4 w-4" />
                </Button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import Button from './Button.vue'
import { ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight } from 'lucide-vue-next'

const props = defineProps({
    currentPage: {
        type: Number,
        required: true
    },
    lastPage: {
        type: Number,
        required: true
    },
    total: {
        type: Number,
        required: true
    },
    perPage: {
        type: Number,
        default: 10
    },
    pageSizes: {
        type: Array,
        default: () => [10, 20, 30, 50, 100]
    }
})

defineEmits(['update:currentPage', 'update:perPage'])

const from = computed(() => {
    return (props.currentPage - 1) * props.perPage + 1
})

const to = computed(() => {
    return Math.min(props.currentPage * props.perPage, props.total)
})
</script>
