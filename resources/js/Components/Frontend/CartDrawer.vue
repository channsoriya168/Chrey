<template>
    <Sheet v-model:open="isOpen">
        <SheetTrigger as-child>
            <Button variant="outline" class="relative" size="icon" :aria-label="t('cart.title')">
                <ShoppingCart class="h-5 w-5" />
                <Badge
                    v-if="cartItemCount > 0"
                    class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full p-0"
                    variant="destructive"
                >
                    {{ cartItemCount }}
                </Badge>
            </Button>
        </SheetTrigger>
        <SheetContent side="right" class="flex w-full flex-col bg-white p-0 sm:max-w-lg">
            <SheetHeader class="border-b bg-gradient-to-r from-pink-50 to-purple-50 px-6 pt-6 pb-4">
                <SheetTitle
                    class="bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-xl font-bold text-transparent"
                >
                    {{ t('cart.title') }}
                </SheetTitle>
                <SheetDescription v-if="cartItemCount > 0" class="text-sm text-gray-600">
                    {{ t('cart.description', cartItemCount) }}
                </SheetDescription>
            </SheetHeader>

            <!-- Loading Skeleton -->
            <div v-if="isLoading && cartItems.length === 0" class="flex-1 overflow-y-auto px-6 py-4">
                <div class="space-y-4">
                    <div v-for="i in 3" :key="i" class="flex gap-4 rounded-lg border p-4">
                        <Skeleton class="h-20 w-20 rounded-md" />
                        <div class="flex-1 space-y-2">
                            <Skeleton class="h-4 w-3/4" />
                            <Skeleton class="h-3 w-1/2" />
                            <Skeleton class="mt-2 h-8 w-24" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="flex flex-1 flex-col items-center justify-center px-6 py-12">
                <div class="relative">
                    <div class="absolute inset-0 rounded-full bg-red-100 opacity-50 blur-xl"></div>
                    <AlertCircle class="relative mb-4 h-16 w-16 text-red-500" />
                </div>
                <p class="mb-2 text-lg font-semibold text-gray-900">{{ t('cart.error.title') }}</p>
                <p class="mb-4 text-sm text-gray-500">{{ error }}</p>
                <Button
                    @click="fetchCartItems"
                    variant="outline"
                    size="sm"
                    class="hover:border-pink-300 hover:bg-pink-50 hover:text-pink-700"
                >
                    <RefreshCw class="mr-2 h-4 w-4" />
                    {{ t('cart.error.retry') }}
                </Button>
            </div>

            <!-- Cart Items List -->
            <div v-else-if="cartItems.length > 0" class="flex-1 overflow-y-auto px-6 py-4">
                <TransitionGroup name="cart-item" tag="div" class="space-y-4">
                    <div
                        v-for="item in cartItems"
                        :key="item.id"
                        class="group flex gap-4 rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-pink-200 hover:shadow-md"
                        :class="{ 'opacity-50': processingItems.has(item.id) }"
                    >
                        <!-- Product Image -->
                        <div
                            class="relative h-24 w-24 flex-shrink-0 overflow-hidden rounded-lg border-2 border-gray-100 shadow-sm"
                        >
                            <img
                                :src="getProductImage(item.product)"
                                :alt="item.product.name"
                                class="h-full w-full object-cover transition-transform group-hover:scale-105"
                                loading="lazy"
                            />
                            <div
                                v-if="processingItems.has(item.id)"
                                class="absolute inset-0 flex items-center justify-center bg-white/70 backdrop-blur-sm"
                            >
                                <Loader2 class="h-5 w-5 animate-spin text-pink-600" />
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="flex flex-1 flex-col">
                            <div class="flex justify-between">
                                <div class="flex-1">
                                    <h4 class="mb-1 line-clamp-2 text-sm font-semibold text-gray-900">
                                        {{ item.product.name }}
                                    </h4>
                                    <p
                                        class="bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-base font-bold text-transparent"
                                    >
                                        ${{ Number(item.price).toFixed(2) }}
                                    </p>
                                </div>

                                <Button
                                    variant="ghost"
                                    size="icon"
                                    class="-mt-1 -mr-2 h-8 w-8 transition-colors hover:bg-red-50"
                                    @click="removeItem(item.id)"
                                    :disabled="processingItems.has(item.id)"
                                    :aria-label="t('cart.item.remove')"
                                >
                                    <Trash2 class="h-4 w-4 text-red-500 transition-transform group-hover:scale-110" />
                                </Button>
                            </div>

                            <!-- Quantity Controls -->
                            <div class="mt-3 flex items-center gap-2">
                                <Button
                                    variant="outline"
                                    size="icon"
                                    class="h-9 w-9 rounded-lg border-2 transition-all hover:border-pink-300 hover:bg-pink-50"
                                    @click="updateQuantity(item.id, item.quantity - 1)"
                                    :disabled="item.quantity <= 1 || processingItems.has(item.id)"
                                    :aria-label="t('cart.item.decrease')"
                                >
                                    <Minus class="h-4 w-4" />
                                </Button>
                                <span class="min-w-10 px-2 text-center text-sm font-bold">{{ item.quantity }}</span>
                                <Button
                                    variant="outline"
                                    size="icon"
                                    class="h-9 w-9 rounded-lg border-2 transition-all hover:border-pink-300 hover:bg-pink-50"
                                    @click="updateQuantity(item.id, item.quantity + 1)"
                                    :disabled="item.quantity >= item.product.stock || processingItems.has(item.id)"
                                    :aria-label="t('cart.item.increase')"
                                >
                                    <Plus class="h-4 w-4" />
                                </Button>
                                <span
                                    v-if="item.quantity >= item.product.stock"
                                    class="ml-2 rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-600"
                                >
                                    {{ t('cart.item.maxStock') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </TransitionGroup>
            </div>

            <!-- Empty Cart State -->
            <div v-else class="flex flex-1 flex-col items-center justify-center px-6 py-12">
                <div class="relative">
                    <div class="absolute inset-0 rounded-full bg-gray-100 opacity-50 blur-2xl"></div>
                    <ShoppingCart class="relative mb-4 h-20 w-20 text-gray-300" />
                </div>
                <p class="mt-4 text-lg font-semibold text-gray-600">{{ t('cart.empty.title') }}</p>
                <p class="mt-2 text-sm text-gray-400">{{ t('cart.empty.description') }}</p>
            </div>

            <!-- Cart Footer -->
            <div v-if="cartItems.length > 0" class="border-t bg-gradient-to-b from-gray-50 to-white px-6 py-5">
                <Separator class="-mt-5 mb-4" />

                <!-- Summary -->
                <div class="mb-5 space-y-3 rounded-lg border border-gray-100 bg-white p-4 shadow-sm">
                    <div class="flex justify-between text-sm">
                        <span class="font-medium text-gray-600">{{ t('cart.summary.subtotal') }}</span>
                        <span class="font-semibold text-gray-900">${{ subtotal.toFixed(2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="font-medium text-gray-600">{{ t('cart.summary.shipping') }}</span>
                        <span class="font-semibold text-green-600">{{ t('cart.summary.shippingFree') }}</span>
                    </div>
                    <Separator />
                    <div class="flex justify-between text-lg">
                        <span class="font-bold text-gray-900">{{ t('cart.summary.total') }}</span>
                        <span
                            class="bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text font-bold text-transparent"
                        >
                            ${{ total.toFixed(2) }}
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <SheetFooter class="flex-col gap-3">
                    <Button
                        class="w-full bg-gradient-to-r from-pink-600 to-purple-600 shadow-lg transition-all hover:from-pink-700 hover:to-purple-700 hover:shadow-xl"
                        size="lg"
                        @click="checkout"
                        :disabled="isCheckingOut"
                    >
                        <Loader2 v-if="isCheckingOut" class="mr-2 h-5 w-5 animate-spin" />
                        <CreditCard v-else class="mr-2 h-5 w-5" />
                        {{ isCheckingOut ? t('cart.checkout.processing') : t('cart.checkout.button') }}
                    </Button>
                </SheetFooter>
            </div>
        </SheetContent>
    </Sheet>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted, TransitionGroup } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger
} from '@/components/ui/sheet'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Separator } from '@/components/ui/separator'
import { Skeleton } from '@/components/ui/skeleton'
import { ShoppingCart, Trash2, Minus, Plus, CreditCard, Loader2, AlertCircle, RefreshCw } from 'lucide-vue-next'
import { toast } from 'vue-sonner'

const page = usePage()
const { t } = useI18n()
const isOpen = ref(false)
const data = ref({
    cartItems: [],
    subtotal: 0,
    total: 0,
    count: 0
})

const isLoading = ref(false)
const error = ref(null)
const processingItems = ref(new Set())
const isCheckingOut = ref(false)

// Check if user is authenticated
const isAuthenticated = computed(() => {
    return page.props.auth && page.props.auth.user
})

// Computed properties for easy access
const cartItems = computed(() => data.value.cartItems)
const subtotal = computed(() => data.value.subtotal)
const total = computed(() => data.value.total)
const cartItemCount = computed(() => data.value.count)

// Fetch cart items from API
const fetchCartItems = async () => {
    if (!isAuthenticated.value) {
        data.value = {
            cartItems: [],
            subtotal: 0,
            total: 0,
            count: 0
        }
        error.value = null
        return
    }

    isLoading.value = true
    error.value = null

    try {
        const response = await fetch('/api/cart/items', {
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })

        if (!response.ok) {
            throw new Error('Failed to fetch cart items')
        }

        const responseData = await response.json()

        // Assign API response to data
        data.value = {
            cartItems: responseData.cartItems || [],
            subtotal: responseData.subtotal || 0,
            total: responseData.total || 0,
            count: responseData.count || 0
        }
    } catch (err) {
        error.value = err.message || 'Something went wrong. Please try again.'
        toast.error(t('cart.notifications.loadFailed'), {
            description: error.value
        })
    } finally {
        isLoading.value = false
    }
}

const getProductImage = (product) => {
    if (product.image_url) {
        if (Array.isArray(product.image_url) && product.image_url.length > 0) {
            return `/storage/${product.image_url[0]}`
        }
        if (typeof product.image_url === 'string') {
            try {
                const parsed = JSON.parse(product.image_url)
                if (Array.isArray(parsed) && parsed.length > 0) {
                    return `/storage/${parsed[0]}`
                }
            } catch (e) {
                return `/storage/${product.image_url}`
            }
        }
    }
    return '/images/placeholder.png'
}

const updateQuantity = async (itemId, newQuantity) => {
    if (newQuantity < 1 || processingItems.value.has(itemId)) return

    // Find the item for optimistic update
    const item = cartItems.value.find((i) => i.id === itemId)
    if (!item) return

    const oldQuantity = item.quantity

    // Optimistic update
    item.quantity = newQuantity
    processingItems.value.add(itemId)

    router.put(
        `/cart/${itemId}`,
        { quantity: newQuantity },
        {
            preserveScroll: true,
            onSuccess: () => {
                processingItems.value.delete(itemId)
                toast.success(t('cart.notifications.updated'), {
                    description: t('cart.notifications.quantityUpdated')
                })
                fetchCartItems() // Refresh to ensure data consistency
            },
            onError: (errors) => {
                // Revert optimistic update on error
                item.quantity = oldQuantity
                processingItems.value.delete(itemId)

                const errorMessage = errors.quantity || 'Failed to update cart'
                toast.error(t('cart.notifications.updateFailed'), {
                    description: errorMessage
                })
            }
        }
    )
}

const removeItem = (itemId) => {
    if (processingItems.value.has(itemId)) return

    const item = cartItems.value.find((i) => i.id === itemId)
    if (!item) return

    processingItems.value.add(itemId)

    // Show confirmation toast with action
    toast.warning(t('cart.item.removeConfirm'), {
        description: t('cart.item.removeDescription', { name: item.product.name }),
        action: {
            label: t('cart.item.removeButton'),
            onClick: () => {
                router.delete(`/cart/${itemId}`, {
                    preserveScroll: true,
                    onSuccess: () => {
                        processingItems.value.delete(itemId)
                        toast.success(t('cart.notifications.itemRemoved'), {
                            description: t('cart.notifications.itemRemovedDescription')
                        })
                        fetchCartItems()
                    },
                    onError: () => {
                        processingItems.value.delete(itemId)
                        toast.error(t('cart.notifications.removeFailed'), {
                            description: t('cart.notifications.tryAgain')
                        })
                    }
                })
            }
        },
        cancel: {
            label: t('cart.item.cancel'),
            onClick: () => {
                processingItems.value.delete(itemId)
            }
        }
    })
}

const checkout = () => {
    if (isCheckingOut.value) return

    // Check if user is authenticated before checkout
    if (!isAuthenticated.value) {
        isOpen.value = false
        router.visit('/login')
        toast.info(t('cart.notifications.pleaseLogin'), {
            description: t('cart.notifications.loginForCheckout')
        })
        return
    }

    isCheckingOut.value = true

    router.post(
        '/checkout',
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                isCheckingOut.value = false
                isOpen.value = false
                toast.success(t('cart.notifications.orderPlaced'), {
                    description: t('cart.notifications.orderPlacedDescription')
                })
                fetchCartItems()
            },
            onError: (errors) => {
                isCheckingOut.value = false
                const errorMessage = Object.values(errors)[0] || 'Failed to process checkout'
                toast.error(t('cart.notifications.checkoutFailed'), {
                    description: errorMessage
                })
            }
        }
    )
}

// Watch for drawer open state and fetch cart items when opened
watch(isOpen, (newValue) => {
    if (newValue) {
        // Redirect to login if not authenticated
        if (!isAuthenticated.value) {
            isOpen.value = false
            router.visit('/login')
            toast.info(t('cart.notifications.pleaseLogin'), {
                description: t('cart.notifications.loginRequired')
            })
            return
        }
        fetchCartItems()
    }
})

// Watch for authentication changes
watch(isAuthenticated, (newValue) => {
    if (newValue) {
        // User just logged in, fetch their cart
        fetchCartItems()
    } else {
        // User logged out, clear cart
        data.value = {
            cartItems: [],
            subtotal: 0,
            total: 0,
            count: 0
        }
    }
})

// Listen for cart-updated events and fetch initial cart data
onMounted(() => {
    window.addEventListener('cart-updated', fetchCartItems)
    // Fetch cart items on mount to show badge immediately
    if (isAuthenticated.value) {
        fetchCartItems()
    }
})

// Clean up event listener on unmount
onUnmounted(() => {
    window.removeEventListener('cart-updated', fetchCartItems)
})

// Expose the refresh function so parent components can trigger it
defineExpose({
    fetchCartItems
})
</script>

<style scoped>
/* Cart item transition animations */
.cart-item-enter-active {
    transition: all 0.3s ease-out;
}

.cart-item-leave-active {
    transition: all 0.2s ease-in;
}

.cart-item-enter-from {
    opacity: 0;
    transform: translateX(20px);
}

.cart-item-leave-to {
    opacity: 0;
    transform: translateX(-20px);
}

.cart-item-move {
    transition: transform 0.3s ease;
}
</style>
