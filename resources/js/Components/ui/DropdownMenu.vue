<template>
  <div class="relative inline-block">
    <Button 
      ref="trigger"
      variant="ghost"
      size="icon"
      @click="toggleOpen"
      :class="$attrs.class"
    >
      <slot name="trigger" />
    </Button>
    
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div
        v-if="isOpen"
        ref="menu"
        class="absolute right-0 z-50 mt-2 w-56 origin-top-right divide-y divide-border rounded-md bg-popover shadow-lg ring-1 ring-border ring-opacity-5 focus:outline-none"
        role="menu"
        aria-orientation="vertical"
        tabindex="-1"
      >
        <div class="py-1" role="none">
          <slot />
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import Button from './Button.vue'

const isOpen = ref(false)
const trigger = ref(null)
const menu = ref(null)

const toggleOpen = () => {
  isOpen.value = !isOpen.value
}

const closeMenu = () => {
  isOpen.value = false
}

const handleClickOutside = (event) => {
  if (trigger.value && !trigger.value.$el.contains(event.target) && 
      menu.value && !menu.value.contains(event.target)) {
    closeMenu()
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})

defineExpose({ closeMenu })
</script>