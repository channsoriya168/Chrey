<template>
    <Sheet v-model:open="isOpen">
        <SheetTrigger as-child>
            <Button variant="outline" class="relative" size="icon" aria-label="Shopping cart">
                <ShoppingCart class="h-5 w-5" />
                <Badge
                    v-if="cartItemCount > 0"
                    class="absolute -top-2 -right-2 h-5 w-5 rounded-full p-0 flex items-center justify-center"
                    variant="destructive"
                >
                    {{ cartItemCount }}
                </Badge>
            </Button>
        </SheetTrigger>
        <SheetContent side="right" class="w-full sm:max-w-lg bg-white flex flex-col p-0">
            <SheetHeader class="px-6 pt-6 pb-4 border-b">
                <SheetTitle>Shopping Cart</SheetTitle>
                <SheetDescription>
                    {{ cartItemCount }} {{ cartItemCount === 1 ? 'item' : 'items' }} in your cart
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
                            <Skeleton class="h-8 w-24 mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="flex-1 flex flex-col items-center justify-center px-6 py-12">
                <AlertCircle class="h-16 w-16 text-red-400 mb-4" />
                <p class="text-lg font-medium text-gray-900 mb-2">Failed to load cart</p>
                <p class="text-sm text-gray-500 mb-4">{{ error }}</p>
                <Button @click="fetchCartItems" variant="outline" size="sm">
                    <RefreshCw class="mr-2 h-4 w-4" />
                    Try Again
                </Button>
            </div>

            <!-- Cart Items List -->
            <div v-else-if="cartItems.length > 0" class="flex-1 overflow-y-auto px-6 py-4">
                <TransitionGroup name="cart-item" tag="div" class="space-y-4">
                    <div
                        v-for="item in cartItems"
                        :key="item.id"
                        class="flex gap-4 rounded-lg border p-4 transition-all hover:bg-gray-50"
                        :class="{ 'opacity-50': processingItems.has(item.id) }"
                    >
                        <!-- Product Image -->
                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border relative">
                            <img
                                :src="getProductImage(item.product)"
                                :alt="item.product.name"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            />
                            <div
                                v-if="processingItems.has(item.id)"
                                class="absolute inset-0 bg-white/50 flex items-center justify-center"
                            >
                                <Loader2 class="h-4 w-4 animate-spin text-pink-600" />
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="flex flex-1 flex-col">
                            <div class="flex justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-gray-900 line-clamp-2">
                                        {{ item.product.name }}
                                    </h4>
                                    <p class="mt-1 text-sm font-medium text-pink-600">
                                        ${{ Number(item.price).toFixed(2) }}
                                    </p>
                                </div>
                                <Button
                                    variant="ghost"
                                    size="icon"
                                    class="h-8 w-8 -mt-1 -mr-2"
                                    @click="removeItem(item.id)"
                                    :disabled="processingItems.has(item.id)"
                                    aria-label="Remove item"
                                >
                                    <Trash2 class="h-4 w-4 text-red-500" />
                                </Button>
                            </div>

                            <!-- Quantity Controls -->
                            <div class="mt-2 flex items-center gap-2">
                                <Button
                                    variant="outline"
                                    size="icon"
                                    class="h-8 w-8"
                                    @click="updateQuantity(item.id, item.quantity - 1)"
                                    :disabled="item.quantity <= 1 || processingItems.has(item.id)"
                                    aria-label="Decrease quantity"
                                >
                                    <Minus class="h-3 w-3" />
                                </Button>
                                <span class="w-8 text-center text-sm font-medium">{{ item.quantity }}</span>
                                <Button
                                    variant="outline"
                                    size="icon"
                                    class="h-8 w-8"
                                    @click="updateQuantity(item.id, item.quantity + 1)"
                                    :disabled="item.quantity >= item.product.stock || processingItems.has(item.id)"
                                    aria-label="Increase quantity"
                                >
                                    <Plus class="h-3 w-3" />
                                </Button>
                                <span v-if="item.quantity >= item.product.stock" class="text-xs text-red-500 ml-2">
                                    Max stock
                                </span>
                            </div>
                        </div>
                    </div>
                </TransitionGroup>
            </div>

            <!-- Empty Cart State -->
            <div v-else class="flex-1 flex flex-col items-center justify-center px-6 py-12">
                <ShoppingCart class="h-16 w-16 text-gray-300" />
                <p class="mt-4 text-lg font-medium text-gray-500">Your cart is empty</p>
                <p class="mt-1 text-sm text-gray-400">Add items to get started</p>
            </div>

            <!-- Cart Footer -->
            <div v-if="cartItems.length > 0" class="border-t px-6 py-4 bg-gray-50">
                <Separator class="mb-4 -mt-4" />

                <!-- Subtotal -->
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">${{ subtotal.toFixed(2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium text-green-600">Free</span>
                    </div>
                    <Separator />
                    <div class="flex justify-between text-base font-semibold">
                        <span>Total</span>
                        <span class="text-pink-600">${{ subtotal.toFixed(2) }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <SheetFooter class="flex-col gap-3">
                    <Button
                        class="w-full bg-pink-600 hover:bg-pink-700"
                        size="lg"
                        @click="checkout"
                        :disabled="isCheckingOut"
                    >
                        <Loader2 v-if="isCheckingOut" class="mr-2 h-4 w-4 animate-spin" />
                        <CreditCard v-else class="mr-2 h-4 w-4" />
                        {{ isCheckingOut ? 'Processing...' : 'Proceed to Checkout' }}
                    </Button>
                </SheetFooter>
            </div>
        </SheetContent>
    </Sheet>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted, TransitionGroup } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
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
import {
    ShoppingCart,
    Trash2,
    Minus,
    Plus,
    CreditCard,
    Loader2,
    AlertCircle,
    RefreshCw
} from 'lucide-vue-next'
import { toast } from 'vue-sonner'

const page = usePage()
const isOpen = ref(false)
const cartItems = ref([])
const isLoading = ref(false)
const error = ref(null)
const processingItems = ref(new Set())
const isCheckingOut = ref(false)

// Check if user is authenticated
const isAuthenticated = computed(() => {
    return page.props.auth && page.props.auth.user
})

const cartItemCount = computed(() => {
    return cartItems.value.reduce((total, item) => total + item.quantity, 0)
})

const subtotal = computed(() => {
    return cartItems.value.reduce((total, item) => total + item.price * item.quantity, 0)
})

// Fetch cart items from API
const fetchCartItems = async () => {
    if (!isAuthenticated.value) {
        cartItems.value = []
        error.value = null
        return
    }

    isLoading.value = true
    error.value = null

    try {
        const response = await fetch('/api/cart/items', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })

        if (!response.ok) {
            throw new Error('Failed to fetch cart items')
        }

        const data = await response.json()
        cartItems.value = data.cartItems || []
    } catch (err) {
        error.value = err.message || 'Something went wrong. Please try again.'
        toast.error('Failed to load cart', {
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
    const item = cartItems.value.find(i => i.id === itemId)
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
                toast.success('Cart updated', {
                    description: 'Quantity has been updated successfully'
                })
                fetchCartItems() // Refresh to ensure data consistency
            },
            onError: (errors) => {
                // Revert optimistic update on error
                item.quantity = oldQuantity
                processingItems.value.delete(itemId)

                const errorMessage = errors.quantity || 'Failed to update cart'
                toast.error('Update failed', {
                    description: errorMessage
                })
            }
        }
    )
}

const removeItem = (itemId) => {
    if (processingItems.value.has(itemId)) return

    const item = cartItems.value.find(i => i.id === itemId)
    if (!item) return

    processingItems.value.add(itemId)

    // Show confirmation toast with action
    toast.warning('Remove item from cart?', {
        description: `${item.product.name} will be removed from your cart`,
        action: {
            label: 'Remove',
            onClick: () => {
                router.delete(`/cart/${itemId}`, {
                    preserveScroll: true,
                    onSuccess: () => {
                        processingItems.value.delete(itemId)
                        toast.success('Item removed', {
                            description: 'Item has been removed from your cart'
                        })
                        fetchCartItems()
                    },
                    onError: () => {
                        processingItems.value.delete(itemId)
                        toast.error('Failed to remove item', {
                            description: 'Please try again'
                        })
                    }
                })
            }
        },
        cancel: {
            label: 'Cancel',
            onClick: () => {
                processingItems.value.delete(itemId)
            }
        }
    })
}

const checkout = () => {
    if (isCheckingOut.value) return

    isCheckingOut.value = true

    router.post('/checkout', {}, {
        preserveScroll: true,
        onSuccess: () => {
            isCheckingOut.value = false
            isOpen.value = false
            toast.success('Order placed!', {
                description: 'Your order has been placed successfully'
            })
            fetchCartItems()
        },
        onError: (errors) => {
            isCheckingOut.value = false
            const errorMessage = Object.values(errors)[0] || 'Failed to process checkout'
            toast.error('Checkout failed', {
                description: errorMessage
            })
        }
    })
}

// Watch for drawer open state and fetch cart items when opened
watch(isOpen, (newValue) => {
    if (newValue) {
        fetchCartItems()
    }
})

// Listen for cart-updated events
onMounted(() => {
    window.addEventListener('cart-updated', fetchCartItems)
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