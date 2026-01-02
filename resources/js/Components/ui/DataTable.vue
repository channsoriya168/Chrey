<template>
    <div class="overflow-hidden bg-slate-800/80 backdrop-blur-sm border border-slate-700/50 shadow-lg shadow-slate-900/50 rounded-lg">
        <!-- Table Container -->
        <div class="min-h-[200px] overflow-x-auto pb-2">
            <Table>
                <TableHeader>
                    <TableRow class="bg-purple-600/80 border-b border-purple-500/30">
                        <TableHead
                            v-for="(column, colIndex) in columns"
                            :key="column.key"
                            :class="[
                                column.headerClass,
                                colIndex === 0 ? 'rounded-l-lg' : '',
                                colIndex === columns.length - 1 && !($slots.actions || hasActionButtons)
                                    ? 'rounded-tr-lg'
                                    : ''
                            ]"
                        >
                            <slot :name="`header-${column.key}`" :column="column">
                                <span class="text-xs font-semibold tracking-wide text-white uppercase">
                                    {{ column.label }}
                                </span>
                            </slot>
                        </TableHead>
                        <TableHead v-if="$slots.actions || hasActionButtons" :class="['text-center', 'rounded-r-lg']">
                            <slot name="header-actions">
                                <span class="text-xs font-semibold tracking-wide text-white uppercase">សកម្មភាព</span>
                            </slot>
                        </TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <!-- Loading State -->
                    <TableRow v-if="loading">
                        <TableCell
                            :colspan="columns.length + ($slots.actions || hasActionButtons ? 1 : 0)"
                            class="h-24 text-center"
                        >
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
                        <TableCell
                            :colspan="columns.length + ($slots.actions || hasActionButtons ? 1 : 0)"
                            class="h-24 text-center"
                        >
                            <slot name="empty">
                                <div class="text-muted-foreground">No results found.</div>
                            </slot>
                        </TableCell>
                    </TableRow>

                    <!-- Data Rows -->
                    <TableRow
                        v-else
                        v-for="(item, index) in data"
                        :key="getRowKey(item, index)"
                        class="group transition-all duration-200 hover:bg-purple-600/20 border-b border-slate-700/30"
                    >
                        <TableCell
                            v-for="(column, colIndex) in columns"
                            :key="column.key"
                            :class="[
                                'relative py-4 transition-colors duration-200',
                                column.cellClass,
                                'group-hover:bg-purple-600/20',
                                colIndex === 0 ? 'group-hover:rounded-l-lg' : '',
                                colIndex === columns.length - 1 && !($slots.actions || hasActionButtons)
                                    ? 'group-hover:rounded-r-lg'
                                    : ''
                            ]"
                        >
                            <slot :name="`cell-${column.key}`" :item="item" :value="item[column.key]" :index="index">
                                <span class="text-sm text-gray-300">{{ item[column.key] }}</span>
                            </slot>
                        </TableCell>

                        <!-- Actions Column -->
                        <TableCell
                            v-if="$slots.actions || hasActionButtons"
                            class="relative py-4 text-center transition-colors duration-200 group-hover:rounded-r-lg group-hover:bg-purple-600/20"
                        >
                            <slot name="actions" :item="item" :index="index">
                                <!-- Default Action Buttons -->
                                <div v-if="hasActionButtons" class="inline-flex items-center justify-end gap-1.5">
                                    <button
                                        v-if="canView"
                                        @click="handleView(item)"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-md text-gray-400 transition-all duration-200 hover:bg-purple-600/30 hover:text-purple-300"
                                        :title="viewLabel"
                                    >
                                        <Eye class="h-4 w-4" />
                                    </button>
                                    <button
                                        v-if="canEdit"
                                        @click="handleEdit(item)"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-md text-purple-400 transition-all duration-200 hover:bg-purple-600/30 hover:text-purple-300"
                                        :title="editLabel"
                                    >
                                        <Pencil class="h-4 w-4" />
                                    </button>
                                    <button
                                        v-if="canDelete"
                                        @click="handleDelete(item)"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-md text-red-400 transition-all duration-200 hover:bg-red-600/30 hover:text-red-300"
                                        :title="deleteLabel"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </slot>
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
                    <span v-if="pagination.total > 0">
                        Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
                    </span>
                    <span v-else> Showing 0 results </span>
                </slot>
            </template>
        </Pagination>

        <!-- Delete Confirmation Dialog -->
        <DeleteDialog
            v-if="canDelete"
            v-model:open="isDeleteDialogOpen"
            :title="deleteDialogTitle"
            :description="deleteDialogDescription"
            :loading="deleteLoading"
            :confirm-text="deleteConfirmText"
            :cancel-text="deleteCancelText"
            :loading-text="deleteLoadingText"
            @confirm="confirmDelete"
        />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { Table, TableHeader, TableBody, TableRow, TableHead, TableCell } from '@/Components/ui/table'
import Pagination from './Pagination.vue'
import DeleteDialog from './DeleteDialog.vue'
import { Eye, Pencil, Trash2 } from 'lucide-vue-next'

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
    },

    /**
     * Show view button in actions column
     */
    canView: {
        type: Boolean,
        default: false
    },

    /**
     * Show edit button in actions column
     */
    canEdit: {
        type: Boolean,
        default: false
    },

    /**
     * Show delete button in actions column
     */
    canDelete: {
        type: Boolean,
        default: false
    },

    /**
     * Label for view button
     */
    viewLabel: {
        type: String,
        default: 'View'
    },

    /**
     * Label for edit button
     */
    editLabel: {
        type: String,
        default: 'Edit'
    },

    /**
     * Label for delete button
     */
    deleteLabel: {
        type: String,
        default: 'Delete'
    },

    /**
     * Delete endpoint URL pattern (use {id} as placeholder)
     * Example: '/dashboard/products/{id}'
     */
    deleteUrl: {
        type: String,
        default: null
    },

    /**
     * Property name to use for item display in delete confirmation
     */
    deleteItemNameKey: {
        type: String,
        default: 'name'
    },

    /**
     * Delete dialog confirm button text
     */
    deleteConfirmText: {
        type: String,
        default: 'លុប'
    },

    /**
     * Delete dialog cancel button text
     */
    deleteCancelText: {
        type: String,
        default: 'បោះបង់'
    },

    /**
     * Delete dialog loading text
     */
    deleteLoadingText: {
        type: String,
        default: 'កំពុងលុប...'
    }
})

const emit = defineEmits(['page-change', 'per-page-change', 'view', 'edit', 'delete', 'delete-success', 'delete-error'])

// Delete dialog state
const isDeleteDialogOpen = ref(false)
const deleteLoading = ref(false)
const itemToDelete = ref(null)

// Computed property to check if any action button is enabled
const hasActionButtons = computed(() => {
    return props.canView || props.canEdit || props.canDelete
})

// Computed properties for delete dialog
const deleteDialogTitle = computed(() => {
    const itemName = itemToDelete.value?.[props.deleteItemNameKey]
    return `លុប ${itemName || 'ធាតុនេះ'}?`
})

const deleteDialogDescription = computed(() => {
    const itemName = itemToDelete.value?.[props.deleteItemNameKey]
    if (!itemName) {
        return 'សកម្មភាពនេះមិនអាចត្រឡប់វិញបានទេ។ វានឹងលុបទិន្នន័យនេះជាអចិន្ត្រៃយ៍។'
    }
    return `តើអ្នកប្រាកដទេថាចង់លុប "${itemName}"? សកម្មភាពនេះមិនអាចត្រឡប់វិញបានទេ។`
})

const getRowKey = (item, index) => {
    return item[props.rowKey] || index
}

const handlePageChange = (page) => {
    emit('page-change', page)
}

const handlePerPageChange = (perPage) => {
    emit('per-page-change', perPage)
}

// Action handlers
const handleView = (item) => {
    emit('view', item)
}

const handleEdit = (item) => {
    emit('edit', item)
}

const handleDelete = (item) => {
    // If deleteUrl is provided, use internal delete dialog
    if (props.deleteUrl) {
        itemToDelete.value = item
        isDeleteDialogOpen.value = true
    } else {
        // Otherwise, emit delete event for custom handling
        emit('delete', item)
    }
}

const confirmDelete = () => {
    if (!itemToDelete.value) return

    deleteLoading.value = true

    // Build the delete URL by replacing {id} with actual item ID
    const url = props.deleteUrl.replace('{id}', itemToDelete.value.id)

    router.delete(url, {
        preserveScroll: true,
        onSuccess: () => {
            isDeleteDialogOpen.value = false
            itemToDelete.value = null
            emit('delete-success')
        },
        onError: (errors) => {
            emit('delete-error', errors)
        },
        onFinish: () => {
            deleteLoading.value = false
        }
    })
}
</script>
