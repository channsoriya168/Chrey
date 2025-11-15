<template>
    <div class="space-y-4">
        <!-- Search and Filters Slot -->
        <div v-if="$slots.filters" class="flex items-center gap-4">
            <slot name="filters" />
        </div>

        <!-- Table Container -->
        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead v-for="column in columns" :key="column.key" :class="column.headerClass">
                            <slot :name="`header-${column.key}`" :column="column">
                                {{ column.label }}
                            </slot>
                        </TableHead>
                        <TableHead v-if="$slots.actions" class="text-right">
                            <slot name="header-actions">Actions</slot>
                        </TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <!-- Loading State -->
                    <TableRow v-if="loading">
                        <TableCell :colspan="columns.length + ($slots.actions ? 1 : 0)" class="h-24 text-center">
                            <div class="flex items-center justify-center">
                                <div
                                    class="border-primary h-6 w-6 animate-spin rounded-full border-2 border-t-transparent"
                                ></div>
                                <span class="text-muted-foreground ml-2">Loading...</span>
                            </div>
                        </TableCell>
                    </TableRow>

                    <!-- Empty State -->
                    <TableRow v-else-if="!data || data.length === 0">
                        <TableCell :colspan="columns.length + ($slots.actions ? 1 : 0)" class="h-24 text-center">
                            <slot name="empty">
                                <div class="text-muted-foreground">No results found.</div>
                            </slot>
                        </TableCell>
                    </TableRow>

                    <!-- Data Rows -->
                    <TableRow v-else v-for="(item, index) in data" :key="getRowKey(item, index)">
                        <TableCell v-for="column in columns" :key="column.key" :class="column.cellClass">
                            <slot :name="`cell-${column.key}`" :item="item" :value="item[column.key]" :index="index">
                                {{ item[column.key] }}
                            </slot>
                        </TableCell>

                        <!-- Actions Column -->
                        <TableCell v-if="$slots.actions" class="text-right">
                            <slot name="actions" :item="item" :index="index" />
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <!-- Pagination -->
        <Pagination
            v-if="pagination && !loading"
            :current-page="pagination.current_page"
            :last-page="pagination.last_page"
            :total="pagination.total"
            :per-page="pagination.per_page"
            :page-sizes="pageSizes"
            @update:current-page="handlePageChange"
            @update:per-page="handlePerPageChange"
        >
            <template #info>
                <slot name="pagination-info" :pagination="pagination">
                    Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
                </slot>
            </template>
        </Pagination>
    </div>
</template>

<script setup>
import Table from './Table.vue'
import TableHeader from './TableHeader.vue'
import TableBody from './TableBody.vue'
import TableRow from './TableRow.vue'
import TableHead from './TableHead.vue'
import TableCell from './TableCell.vue'
import Pagination from './Pagination.vue'

const props = defineProps({
    /**
     * Array of column definitions
     * Example: [{ key: 'name', label: 'Name', headerClass: '', cellClass: '' }]
     */
    columns: {
        type: Array,
        required: true,
        validator: (columns) => {
            return columns.every((col) => col.key && col.label)
        }
    },

    /**
     * Array of data items to display
     */
    data: {
        type: Array,
        default: () => []
    },

    /**
     * Loading state
     */
    loading: {
        type: Boolean,
        default: false
    },

    /**
     * Pagination object from Laravel
     * Should include: current_page, last_page, total, per_page, from, to
     */
    pagination: {
        type: Object,
        default: null
    },

    /**
     * Available page sizes for pagination
     */
    pageSizes: {
        type: Array,
        default: () => [10, 20, 30, 50, 100]
    },

    /**
     * Key to use for row identification (for :key binding)
     */
    rowKey: {
        type: String,
        default: 'id'
    }
})

const emit = defineEmits(['page-change', 'per-page-change'])

const getRowKey = (item, index) => {
    return item[props.rowKey] || index
}

const handlePageChange = (page) => {
    emit('page-change', page)
}

const handlePerPageChange = (perPage) => {
    emit('per-page-change', perPage)
}
</script>
