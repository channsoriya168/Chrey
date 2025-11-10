<template>
  <DropdownMenu>
    <template #trigger>
      <MoreHorizontal class="h-4 w-4" />
      <span class="sr-only">Open menu</span>
    </template>

    <slot>
      <DropdownMenuItem
        v-if="showView"
        @click="$emit('view', item)"
        class="cursor-pointer"
      >
        <Eye class="mr-2 h-4 w-4" />
        <span>{{ viewLabel }}</span>
      </DropdownMenuItem>

      <DropdownMenuItem
        v-if="showEdit"
        @click="$emit('edit', item)"
        class="cursor-pointer"
      >
        <Pencil class="mr-2 h-4 w-4" />
        <span>{{ editLabel }}</span>
      </DropdownMenuItem>

      <DropdownMenuItem
        v-if="showDelete"
        @click="$emit('delete', item)"
        class="cursor-pointer text-destructive focus:text-destructive"
      >
        <Trash2 class="mr-2 h-4 w-4" />
        <span>{{ deleteLabel }}</span>
      </DropdownMenuItem>
    </slot>
  </DropdownMenu>
</template>

<script setup>
import DropdownMenu from './DropdownMenu.vue'
import DropdownMenuItem from './DropdownMenuItem.vue'
import { MoreHorizontal, Eye, Pencil, Trash2 } from 'lucide-vue-next'

defineProps({
  /**
   * The item this action menu is for
   */
  item: {
    type: Object,
    required: true
  },

  /**
   * Show view action
   */
  showView: {
    type: Boolean,
    default: true
  },

  /**
   * Show edit action
   */
  showEdit: {
    type: Boolean,
    default: true
  },

  /**
   * Show delete action
   */
  showDelete: {
    type: Boolean,
    default: true
  },

  /**
   * Custom label for view action
   */
  viewLabel: {
    type: String,
    default: 'View'
  },

  /**
   * Custom label for edit action
   */
  editLabel: {
    type: String,
    default: 'Edit'
  },

  /**
   * Custom label for delete action
   */
  deleteLabel: {
    type: String,
    default: 'Delete'
  }
})

defineEmits(['view', 'edit', 'delete'])
</script>
