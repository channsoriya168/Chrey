<template>
    <Sheet v-model:open="isOpen">
        <SheetTrigger as-child>
            <Button variant="outline" class="relative" size="icon">
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
        <SheetContent side="right" class="w-full sm:max-w-lg bg-white">
            <SheetHeader class="animate-in fade-in-0 slide-in-from-top-2 duration-500 delay-100">
                <SheetTitle>Shopping Cart</SheetTitle>
                <SheetDescription>
                    {{ cartItemCount }} {{ cartItemCount === 1 ? 'item' : 'items' }} in your cart
                </SheetDescription>
            </SheetHeader>

            <div class="mt-8 flex h-[calc(100vh-200px)] flex-col animate-in fade-in-0 duration-700 delay-200">
                <!-- Cart Items List -->
                <div v-if="cartItems.length > 0" class="flex-1 overflow-y-auto pr-2 mb-4">
                    <TransitionGroup name="cart-item" tag="div" class="space-y-4">
                        <div
                            v-for="item in cartItems"
                            :key="item.id"
                            class="flex gap-4 rounded-lg border p-4 transition-all hover:bg-gray-50"
                        >
                            <!-- Product Image -->
                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border">
                                <img
                                    :src="getProductImage(item.product)"
                                    :alt="item.product.name"
                                    class="h-full w-full object-cover"
                                />
                            </div>

                            <!-- Product Details -->
                            <div class="flex flex-1 flex-col">
                                <div class="flex justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900">
                                            {{ item.product.name }}
                                        </h4>
                                        <p class="mt-1 text-sm font-medium text-pink-600">
                                            ${{ item.price }}
                                        </p>
                                    </div>
                                    <Button
                                        variant="ghost"
                                        size="icon"
                                        class="h-8 w-8"
                                        @click="removeItem(item.id)"
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
                                        :disabled="item.quantity <= 1"
                                    >
                                        <Minus class="h-3 w-3" />
                                    </Button>
                                    <span class="w-8 text-center text-sm font-medium">{{ item.quantity }}</span>
                                    <Button
                                        variant="outline"
                                        size="icon"
                                        class="h-8 w-8"
                                        @click="updateQuantity(item.id, item.quantity + 1)"
                                        :disabled="item.quantity >= item.product.stock"
                                    >
                                        <Plus class="h-3 w-3" />
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </TransitionGroup>
                </div>

                <!-- Empty Cart State -->
                <div v-else class="flex flex-1 flex-col items-center justify-center py-12">
                    <ShoppingCart class="h-16 w-16 text-gray-300" />
                    <p class="mt-4 text-lg font-medium text-gray-500">Your cart is empty</p>
                    <p class="mt-1 text-sm text-gray-400">Add items to get started</p>
                </div>

                <!-- Cart Footer -->
                <div v-if="cartItems.length > 0" class="border-t pt-4 mt-4">
                    <Separator class="mb-4" />

                    <!-- Subtotal -->
                    <div class="space-y-2">
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
                    <SheetFooter class="mt-6 flex-col gap-3">
                        <!-- <Button class="w-full" variant="outline" size="lg" @click="viewCart">
                            <ShoppingCart class="mr-2 h-4 w-4" />
                            View Full Cart
                        </Button> -->
                        <Button class="w-full bg-pink-600 hover:bg-pink-700" size="lg" @click="checkout">
                            <CreditCard class="mr-2 h-4 w-4" />
                            Proceed to Checkout
                        </Button>
                    </SheetFooter>
                </div>
            </div>
        </SheetContent>
    </Sheet>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, TransitionGroup } from 'vue'
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
import { ShoppingCart, Trash2, Minus, Plus, CreditCard } from 'lucide-vue-next'

const page = usePage()
const isOpen = ref(false)
const cartItems = ref([])
const isLoading = ref(false)

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
        return
    }

    isLoading.value = true
    try {
        const response = await fetch('/api/cart/items', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })

        if (response.ok) {
            const data = await response.json()
            cartItems.value = data.cartItems || []
        }
    } catch (error) {
        console.error('Failed to fetch cart items:', error)
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

const updateQuantity = (itemId, newQuantity) => {
    if (newQuantity < 1) return

    router.put(
        `/cart/${itemId}`,
        { quantity: newQuantity },
        {
            preserveScroll: true,
            onSuccess: () => {
                fetchCartItems()
            }
        }
    )
}

const removeItem = (itemId) => {
    if (confirm('Remove this item from cart?')) {
        router.delete(`/cart/${itemId}`, {
            preserveScroll: true,
            onSuccess: () => {
                fetchCartItems()
            }
        })
    }
}

const viewCart = () => {
    isOpen.value = false
    router.visit('/cart')
}

const checkout = () => {
    if (confirm('Proceed to checkout and place order?')) {
        isOpen.value = false
        router.post('/checkout', {}, {
            onSuccess: () => {
                fetchCartItems()
            }
        })
    }
}

// Fetch cart items on component mount
onMounted(() => {
    fetchCartItems()

    // Listen for cart-updated events
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

<style>
/* Book opening animation */
:global(body) {
    perspective: 2000px;
}

:global(.book-open) {
    transform-origin: right center;
    transform-style: preserve-3d;
}

:global(.book-open[data-state="closed"]) {
    animation: bookClose 0.5s cubic-bezier(0.4, 0.0, 0.2, 1) forwards;
}

:global(.book-open[data-state="open"]) {
    animation: bookOpen 0.7s cubic-bezier(0.4, 0.0, 0.2, 1) forwards;
}

@keyframes bookOpen {
    0% {
        transform: perspective(1500px) rotateY(95deg) translateX(20%);
        opacity: 0;
    }
    40% {
        opacity: 0.6;
    }
    100% {
        transform: perspective(1500px) rotateY(0deg) translateX(0);
        opacity: 1;
    }
}

@keyframes bookClose {
    0% {
        transform: perspective(1500px) rotateY(0deg) translateX(0);
        opacity: 1;
    }
    60% {
        opacity: 0.6;
    }
    100% {
        transform: perspective(1500px) rotateY(95deg) translateX(20%);
        opacity: 0;
    }
}
</style>

<style scoped>
/* Cart item transition animations */
.cart-item-enter-active {
    transition: all 0.5s ease-out;
}

.cart-item-leave-active {
    transition: all 0.4s ease-in;
}

.cart-item-enter-from {
    opacity: 0;
    transform: translateX(40px) scale(0.95);
}

.cart-item-leave-to {
    opacity: 0;
    transform: translateX(-40px) scale(0.95);
}

.cart-item-move {
    transition: transform 0.5s ease;
}
</style>
