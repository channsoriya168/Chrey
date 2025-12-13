<template>
    <div
        class="relative z-10 flex flex-col items-start justify-between gap-4 border-t border-gray-200 bg-gray-50/50 px-4 py-3 sm:flex-row sm:items-center"
    >
        <!-- Info Section -->
        <div class="text-sm font-medium text-gray-600">
            <slot name="info">
                <span v-if="total > 0">
                    Showing <span class="font-semibold text-gray-900">{{ from }}</span> to
                    <span class="font-semibold text-gray-900">{{ to }}</span> of
                    <span class="font-semibold text-gray-900">{{ total }}</span> results
                </span>
                <span v-else class="text-gray-500"> No results found </span>
            </slot>
        </div>

        <!-- Controls Section -->
        <div class="flex flex-wrap items-center gap-4 sm:gap-6">
            <!-- Rows per page selector -->
            <div class="flex items-center gap-2">
                <label for="rows-per-page" class="text-sm font-medium whitespace-nowrap text-gray-700">
                    Rows per page
                </label>
                <Select v-model="selectedPerPage">
                    <SelectTrigger
                        id="rows-per-page"
                        class="h-9 w-[75px] border-gray-300 transition-colors hover:border-gray-400 focus:ring-2 focus:ring-amber-500/20"
                    >
                        <SelectValue />
                    </SelectTrigger>
                    <SelectContent
                        side="top"
                        align="end"
                        :sideOffset="4"
                        class="z-[100] min-w-[75px] bg-white"
                        :avoidCollisions="true"
                        :collisionPadding="8"
                    >
                        <SelectItem
                            v-for="size in pageSizes"
                            :key="size"
                            :value="String(size)"
                            class="cursor-pointer hover:bg-amber-50 focus:bg-amber-50 focus:text-amber-900"
                        >
                            {{ size }}
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>

            <!-- Page info -->
            <div class="flex min-w-[120px] items-center justify-center text-sm font-medium text-gray-700">
                Page <span class="mx-1 font-semibold text-gray-900">{{ currentPage }}</span> of
                <span class="ml-1 font-semibold text-gray-900">{{ lastPage }}</span>
            </div>

            <!-- Navigation buttons -->
            <div class="flex items-center gap-1">
                <Button
                    variant="outline"
                    size="icon"
                    class="h-9 w-9 border-gray-300 transition-all duration-200 hover:border-amber-300 hover:bg-amber-50 hover:text-amber-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-gray-300 disabled:hover:bg-transparent"
                    :disabled="currentPage === 1"
                    @click="$emit('update:currentPage', 1)"
                    title="First page"
                >
                    <ChevronsLeft class="h-4 w-4" />
                </Button>

                <Button
                    variant="outline"
                    size="icon"
                    class="h-9 w-9 border-gray-300 transition-all duration-200 hover:border-amber-300 hover:bg-amber-50 hover:text-amber-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-gray-300 disabled:hover:bg-transparent"
                    :disabled="currentPage === 1"
                    @click="$emit('update:currentPage', currentPage - 1)"
                    title="Previous page"
                >
                    <ChevronLeft class="h-4 w-4" />
                </Button>

                <Button
                    variant="outline"
                    size="icon"
                    class="h-9 w-9 border-gray-300 transition-all duration-200 hover:border-amber-300 hover:bg-amber-50 hover:text-amber-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-gray-300 disabled:hover:bg-transparent"
                    :disabled="currentPage === lastPage"
                    @click="$emit('update:currentPage', currentPage + 1)"
                    title="Next page"
                >
                    <ChevronRight class="h-4 w-4" />
                </Button>

                <Button
                    variant="outline"
                    size="icon"
                    class="h-9 w-9 border-gray-300 transition-all duration-200 hover:border-amber-300 hover:bg-amber-50 hover:text-amber-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-gray-300 disabled:hover:bg-transparent"
                    :disabled="currentPage === lastPage"
                    @click="$emit('update:currentPage', lastPage)"
                    title="Last page"
                >
                    <ChevronsRight class="h-4 w-4" />
                </Button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, watch } from 'vue'
import { Button } from '@/components/ui/button'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
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

const emit = defineEmits(['update:currentPage', 'update:perPage'])

const selectedPerPage = computed({
    get: () => String(props.perPage),
    set: (value) => emit('update:perPage', parseInt(value))
})

const from = computed(() => {
    if (props.total === 0) return 0
    return (props.currentPage - 1) * props.perPage + 1
})

const to = computed(() => {
    if (props.total === 0) return 0
    return Math.min(props.currentPage * props.perPage, props.total)
})
</script>
