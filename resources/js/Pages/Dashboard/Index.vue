<template>

    <Head title="Dashboard" />
    <div>
        <div class="flex items-center mb-4">
            <h2 class="text-2xl font-medium">ស្ថិតិ</h2>
            <div class="flex-1"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-blue-600 text-white rounded-lg p-4">
                <div class="flex items-center">
                    <div class="text-4xl mr-3">👥</div>
                    <div>
                        <div class="text-4xl font-bold">{{ countCategories }}</div>
                        <div class="text-sm">ប្រភេទផលិតផល</div>
                    </div>
                </div>
            </div>

            <div class="bg-green-600 text-white rounded-lg p-4">
                <div class="flex items-center">
                    <div class="text-4xl mr-3">📦</div>
                    <div>
                        <div class="text-4xl font-bold">85</div>
                        <div class="text-sm">ផលិតផលសរុប</div>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-600 text-white rounded-lg p-4">
                <div class="flex items-center">
                    <div class="text-4xl mr-3">🏷️</div>
                    <div>
                        <div class="text-4xl font-bold">12</div>
                        <div class="text-sm">ប្រភេទសរុប</div>
                    </div>
                </div>
            </div>

            <div class="bg-red-600 text-white rounded-lg p-4">
                <div class="flex items-center">
                    <div class="text-4xl mr-3">🛒</div>
                    <div>
                        <div class="text-4xl font-bold">45</div>
                        <div class="text-sm">ការបញ្ជាទិញ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
    const props = defineProps({
        countCategories: Number
    });
</script>