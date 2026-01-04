<?php

return [
    'auth' => [
        'registered' => 'Account created successfully! Welcome.',
        'welcome_back' => 'Welcome back, :name!',
        'logout' => 'You have logged out successfully. See you again!',
        'invalid_credentials' => 'Email or password is incorrect. Please try again.',
    ],

    'profile' => [
        'updated' => 'Profile updated successfully!',
        'password_updated' => 'Password updated successfully!',
    ],

    'cart' => [
        'added' => 'Product added to cart successfully!',
        'insufficient_stock' => 'Insufficient stock available',
        'stock_limit_reached' => 'Cannot add more items. Stock limit reached.',
        'empty' => 'Your cart is empty',
        'insufficient_stock_for' => 'Insufficient stock for :product',
    ],

    'order' => [
        'placed' => 'Order placed successfully!',
        'failed' => 'Failed to place order: :error',
        'status_updated' => 'Order status updated successfully!',
        'payment_updated' => 'Payment status updated successfully!',
        'deleted' => 'Order deleted successfully!',
    ],

    'payment' => [
        'invalid_method' => 'Invalid payment method',
        'qr_failed' => 'Failed to generate payment QR code. Please try again.',
    ],

    'product' => [
        'created' => 'Product created successfully.',
        'updated' => 'Product updated successfully.',
        'deleted' => 'Product deleted successfully.',
    ],

    'user' => [
        'created' => 'User created successfully.',
        'updated' => 'User updated successfully.',
        'deleted' => 'User deleted successfully.',
        'cannot_delete_self' => 'You cannot delete yourself.',
    ],

    'role' => [
        'created' => 'Role created successfully.',
        'updated' => 'Role updated successfully.',
        'deleted' => 'Role deleted successfully.',
        'cannot_delete_admin' => 'Cannot delete admin role.',
    ],
];