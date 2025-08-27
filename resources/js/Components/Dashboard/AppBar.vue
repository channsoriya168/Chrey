<template>
    <header class="flex items-center justify-between bg-teal-600 text-white p-4 shadow-sm">
        <Button variant="ghost" size="icon" @click="toggleDrawer" class="text-white hover:bg-teal-700">
            <Menu class="w-5 h-5" />
        </Button>

        <div class="flex items-center space-x-2">
            <!-- Settings button -->
            <Button variant="ghost" size="icon" class="text-white hover:bg-teal-700">
                <Settings class="w-4 h-4" />
            </Button>

            <!-- User menu -->
            <DropdownMenu>
                <template #trigger>
                    <User class="w-4 h-4 text-white" />
                </template>
                <DropdownMenuItem @click="logout">
                    <LogOut class="w-4 h-4 mr-2" />
                    ចាកចេញ
                </DropdownMenuItem>
            </DropdownMenu>

            <!-- Language selector -->
            <DropdownMenu>
                <template #trigger>
                    <Languages class="w-4 h-4 text-white" />
                </template>
                <DropdownMenuItem 
                    v-for="language in languages" 
                    :key="language.code" 
                    @click="changeLanguage(language.code)"
                    :class="{ 'bg-accent': currentLanguage === language.code }"
                >
                    <Flag class="w-4 h-4 mr-2" />
                    {{ language.name }}
                </DropdownMenuItem>
            </DropdownMenu>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue';
import Button from '@/components/ui/Button.vue';
import DropdownMenu from '@/components/ui/DropdownMenu.vue';
import DropdownMenuItem from '@/components/ui/DropdownMenuItem.vue';
import { Menu, Settings, User, LogOut, Languages, Flag } from 'lucide-vue-next';

const emit = defineEmits(['toggle-drawer']);

const currentLanguage = ref('en');

const languages = ref([
    { code: 'en', name: 'English' },
    { code: 'km', name: 'ខ្មែរ (Khmer)' },
]);

const toggleDrawer = () => {
    emit('toggle-drawer');
};

const changeLanguage = (languageCode) => {
    currentLanguage.value = languageCode;
};

const logout = () => {
    // Handle logout logic here
    console.log('Logging out...');
};
</script>
