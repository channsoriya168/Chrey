<template>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-4">
        <div class="relative">
            <!-- Carousel Container -->
            <div class="overflow-hidden rounded-3xl shadow-2xl shadow-fuchsia-500/10 border border-fuchsia-500/20">
                <div
                    class="relative h-[240px] sm:h-[320px] md:h-[500px] bg-gradient-to-br from-slate-800/60 via-purple-900/40 to-slate-900/60 backdrop-blur-sm">
                    <!-- Slide 1 -->
                    <div :class="[
                        'absolute inset-0 transition-opacity duration-700 ease-in-out',
                        currentSlide === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'
                    ]">
                        <div
                            class="grid h-full grid-cols-2 items-center gap-4 px-6 py-4 sm:gap-6 sm:px-8 sm:py-8 md:gap-12 md:px-16 md:py-0">
                            <div class="space-y-3 sm:space-y-4 md:space-y-6">
                                <h1
                                    class="text-lg leading-tight font-bold text-white sm:text-3xl md:text-5xl lg:text-6xl drop-shadow-2xl">
                                    {{ $t('home.hero.slide1.title') }}<br />
                                    {{ $t('home.hero.slide1.subtitle').replace('100%', '') }}
                                    <span
                                        class="text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-400 to-pink-400">100%</span>
                                </h1>
                            </div>
                            <div class="flex items-center justify-center">
                                <img :src="firstImage" alt="Fashion products"
                                    class="h-auto max-h-[200px] w-full rounded-2xl object-cover shadow-2xl shadow-fuchsia-500/20 ring-2 ring-fuchsia-500/30 sm:max-h-[280px] md:max-h-96" />
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div :class="[
                        'absolute inset-0 transition-opacity duration-700 ease-in-out',
                        currentSlide === 1 ? 'opacity-100 z-10' : 'opacity-0 z-0'
                    ]">
                        <div
                            class="grid h-full grid-cols-2 items-center gap-4 px-6 py-4 sm:gap-6 sm:px-8 sm:py-8 md:gap-12 md:px-16 md:py-0">
                            <div class="space-y-3 sm:space-y-4 md:space-y-6">
                                <h1
                                    class="text-lg leading-tight font-bold text-white sm:text-3xl md:text-5xl lg:text-6xl drop-shadow-2xl">
                                    {{ $t('home.hero.slide2.title') }}<br />
                                    <span
                                        class="text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-400 to-pink-400">{{
                                            $t('home.hero.slide2.subtitle') }}</span>
                                </h1>
                                <p class="hidden text-sm text-white/90 sm:block sm:text-base md:text-lg drop-shadow-lg">
                                    {{ $t('home.hero.slide2.description') }}
                                </p>
                            </div>
                            <div class="flex items-center justify-center">
                                <img :src="secondImage" alt="Best sellers"
                                    class="h-auto max-h-[200px] w-full rounded-2xl object-cover shadow-2xl shadow-fuchsia-500/20 ring-2 ring-fuchsia-500/30 sm:max-h-[280px] md:max-h-96" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Indicators -->
                <div
                    class="absolute bottom-3 left-1/2 z-10 flex -translate-x-1/2 transform space-x-2 sm:bottom-5 md:bottom-8 md:space-x-3">
                    <button v-for="index in 2" :key="index" @click="currentSlide = index - 1" :class="[
                        'h-2 w-2 rounded-full transition-all duration-300 shadow-md md:h-2.5 md:w-2.5',
                        currentSlide === index - 1 ? 'w-8 bg-gradient-to-r from-fuchsia-400 to-pink-400 md:w-12' : 'bg-white/80 hover:bg-white'
                    ]" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import firstImage from '@/../images/01.png'
    import secondImage from '@/../images/image1.png'
    import { onMounted, onUnmounted, ref } from 'vue'

    const currentSlide = ref(0)
    let slideInterval = null

    // Auto-rotate carousel
    onMounted(() => {
        slideInterval = setInterval(() => {
            currentSlide.value = (currentSlide.value + 1) % 2
        }, 5000)
    })

    onUnmounted(() => {
        if (slideInterval) {
            clearInterval(slideInterval)
        }
    })
</script>

<style scoped>
    /* Carousel styles are handled by Tailwind classes */
</style>