# Bakong KHQR Payment Integration

Complete documentation for integrating Bakong KHQR (Khmer QR) payment system into the Chrey e-commerce platform.

## Table of Contents

- [Overview](#overview)
- [Requirements](#requirements)
- [Configuration](#configuration)
- [Architecture](#architecture)
- [Usage](#usage)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)
- [Security](#security)

---

## Overview

The Bakong payment integration enables customers to pay using KHQR codes through Cambodia's national payment system. Customers scan QR codes with their banking apps (ABA, Wing, ACLEDA, etc.) to complete payments.

### Features

- ✅ Generate KHQR payment QR codes
- ✅ Real-time payment status verification
- ✅ Idempotent order creation (prevents duplicates)
- ✅ MD5 validation for secure transactions
- ✅ Test mode for development
- ✅ Automatic stock management
- ✅ Telegram notifications

---

## Requirements

### Dependencies

```json
{
  "khqr-gateway/bakong-khqr-php": "^1.0",
  "simplesoftwareio/simple-qrcode": "^4.0"
}
```

### Environment Variables

Add to `.env`:

```env
# Bakong API Configuration
BAKONG_API_KEY=your_api_key_here
BAKONG_MERCHANT_ID=merchant@bank
BAKONG_MERCHANT_NAME="Your Shop Name"
BAKONG_MERCHANT_CITY="PHNOM PENH"
BAKONG_TEST_MODE=true  # Set to false in production
```

### Configuration File

Create `config/services.php`:

```php
return [
    'bakong' => [
        'merchant_id' => env('BAKONG_MERCHANT_ID'),
        'merchant_name' => env('BAKONG_MERCHANT_NAME'),
        'merchant_city' => env('BAKONG_MERCHANT_CITY'),
    ],
];
```

---

## Architecture

### Payment Flow Diagram

```
┌─────────┐     ┌──────────┐     ┌─────────┐     ┌────────────┐
│ Customer│     │  Server  │     │ Bakong  │     │  Database  │
└────┬────┘     └────┬─────┘     └────┬────┘     └─────┬──────┘
     │               │                │                  │
     │ 1. Checkout   │                │                  │
     │──────────────>│                │                  │
     │               │                │                  │
     │               │ 2. Generate QR │                  │
     │               │───────────────>│                  │
     │               │                │                  │
     │               │ 3. QR + MD5    │                  │
     │               │<───────────────│                  │
     │               │                │                  │
     │               │ 4. Store MD5   │                  │
     │               │────────────────────────────────>│
     │               │                │                  │
     │ 5. Display QR │                │                  │
     │<──────────────│                │                  │
     │               │                │                  │
     │ 6. Scan & Pay │                │                  │
     │───────────────────────────────>│                  │
     │               │                │                  │
     │               │ 7. Poll Status │                  │
     │               │───────────────>│                  │
     │               │                │                  │
     │               │ 8. Status=Paid │                  │
     │               │<───────────────│                  │
     │               │                │                  │
     │               │ 9. Create Order│                  │
     │               │────────────────────────────────>│
     │               │                │                  │
     │ 10. Redirect  │                │                  │
     │<──────────────│                │                  │
```

### Key Components

1. **BakongService** (`app/Services/BakongService.php`)
   - Handles QR generation and payment verification

2. **OrderController** (`app/Http/Controllers/OrderController.php`)
   - Manages checkout flow and order creation

3. **Address.vue** (`resources/js/Pages/Frontend/Checkout/Address.vue`)
   - Frontend checkout interface with polling

---

## Usage

### 1. Generate Payment QR Code

```php
use App\Services\BakongService;

$bakongService = app(BakongService::class);

$payment = $bakongService->generateKHQR([
    'amount' => 25.50
]);

if ($payment) {
    // Display QR code
    echo $payment['qr']; // SVG QR code

    // Store MD5 for verification
    $md5 = $payment['md5'];

    // Store in cart
    $cart->update(['md5' => $md5]);
}
```

### 2. Check Payment Status

```php
$status = $bakongService->checkPaymentStatus($md5);

switch ($status['status']) {
    case 'success':
        // Payment confirmed
        $amount = $status['amount'];
        $transactionId = $status['transaction_id'];
        // Create order...
        break;

    case 'pending':
        // Still waiting
        break;

    case 'error':
        // Handle error
        $message = $status['message'];
        break;
}
```

### 3. Frontend Polling

The Vue component automatically polls for payment status:

```javascript
// Polls every 5 seconds
setInterval(() => {
    axios.get(`/payment/status/${cartId}?md5=${md5}`)
        .then(response => {
            if (response.data.status === 'paid') {
                // Payment successful
                window.location.href = '/orders';
            }
        });
}, 5000);
```

---

## Testing

### Test Mode

Enable test mode in `.env`:

```env
BAKONG_TEST_MODE=true
```

In test mode:
- All payments auto-approve immediately
- No real Bakong API calls made
- Perfect for development/testing

### Manual Testing

1. **Generate QR Code**
   ```bash
   php artisan tinker

   $service = app(\App\Services\BakongService::class);
   $payment = $service->generateKHQR(['amount' => 1.00]);
   dump($payment);
   ```

2. **Check Status (Test Mode)**
   ```bash
   $status = $service->checkPaymentStatus('any_md5_hash');
   dump($status); // Will return 'success'
   ```

3. **Real Payment Test**
   - Set `BAKONG_TEST_MODE=false`
   - Use small amount (e.g., $0.01)
   - Scan with real banking app
   - Verify payment completes

---

## Troubleshooting

### Issue: "Transaction not found"

**Cause:** Payment hasn't been completed or MD5 mismatch

**Solution:**
```php
// Verify MD5 in database
$cart = Cart::find($cartId);
echo "Cart MD5: " . $cart->md5;

// Check if transaction exists
$order = Order::where('bakong_transaction_id', $md5)->first();
```

### Issue: "Payment service not configured"

**Cause:** Missing `BAKONG_API_KEY`

**Solution:**
```bash
# Add to .env
BAKONG_API_KEY=your_key_here

# Clear config cache
php artisan config:clear
```

### Issue: Duplicate orders created

**Cause:** Idempotency check not working

**Solution:**
The system now checks:
1. If order exists with same `bakong_transaction_id`
2. If cart status is already `checked_out`

```php
// OrderController.php:298
$existingOrder = Order::where('bakong_transaction_id', $md5)->first();
if ($existingOrder) {
    return response()->json(['status' => 'paid', ...]);
}
```

### Issue: Polling continues after payment

**Cause:** Interval not cleared

**Solution:**
Already fixed in Address.vue:
```javascript
stopPaymentPolling() {
    if (pollingInterval.value) {
        clearInterval(pollingInterval.value);
        pollingInterval.value = null;
    }
}
```

---

## Security

### ✅ Implemented Security Measures

1. **MD5 Validation**
   - Verifies MD5 belongs to the cart before processing
   - Prevents unauthorized status checks

   ```php
   // OrderController.php:269
   if ($cart->md5 !== $md5) {
       return response()->json(['status' => 'error'], 400);
   }
   ```

2. **Idempotency Protection**
   - Prevents duplicate order creation
   - Checks `bakong_transaction_id` uniqueness

   ```php
   // OrderController.php:298
   $existingOrder = Order::where('bakong_transaction_id', $md5)->first();
   ```

3. **Cart Ownership Verification**
   - Ensures user can only check their own carts

   ```php
   // OrderController.php:491
   private function authorizeCartAccess(Cart $cart) {
       if ($cart->user_id !== auth()->id()) {
           abort(403);
       }
   }
   ```

4. **Database Transactions**
   - Uses DB::beginTransaction() for atomic operations
   - Rollback on any error

### 🔐 Additional Recommendations

1. **Rate Limiting**
   ```php
   // Add to routes/web.php
   Route::get('/payment/status/{cart}', [OrderController::class, 'checkPaymentStatus'])
       ->middleware('throttle:30,1'); // 30 requests per minute
   ```

2. **Unique Constraint**
   ```php
   // Migration
   $table->string('bakong_transaction_id')->unique();
   ```

3. **Audit Logging**
   ```php
   Log::channel('payments')->info('Payment verified', [
       'cart_id' => $cart->id,
       'md5' => $md5,
       'amount' => $amount,
       'user_id' => auth()->id()
   ]);
   ```

---

## API Reference

### BakongService Methods

#### `generateKHQR(array $data): ?array`

Generates a KHQR payment QR code.

**Parameters:**
- `amount` (float) - Payment amount in USD

**Returns:**
```php
[
    'qr' => '<svg>...</svg>',           // SVG QR code
    'khqr_string' => 'khqr...',         // Raw KHQR data
    'md5' => 'abc123...',               // Transaction identifier
    'transactionId' => 'KHQR-ABC123',   // Internal reference
    'id' => 'khqr-payment-1234567890',  // Session ID
    'status' => 'pending'               // Initial status
]
```

#### `checkPaymentStatus(string $md5): array`

Checks payment status by MD5 hash.

**Parameters:**
- `md5` (string) - Transaction identifier from generateKHQR()

**Returns:**
```php
[
    'status' => 'success',              // success|pending|error
    'transaction_id' => 'hash123...',   // Bakong transaction hash
    'amount' => 25.50,                  // Paid amount
    'currency' => 'USD',                // Currency code
    'message' => 'Optional message'     // Error or status message
]
```

---

## Changelog

### v1.0.0 (2026-01-08)

**Added:**
- Initial Bakong KHQR integration
- QR code generation
- Payment status verification
- Idempotency protection
- MD5 validation
- Test mode support
- Polling management
- Comprehensive documentation

**Fixed:**
- Environment variable mismatch (`BAKONG_TOKEN` → `BAKONG_API_KEY`)
- Cart status enum mismatch (`completed` → `checked_out`)
- Response structure handling for Bakong API
- Polling interval cleanup on modal close
- Duplicate order prevention

---

## Support

For issues or questions:
- Check logs: `storage/logs/laravel.log`
- Review Bakong docs: https://bakong.nbc.gov.kh/docs
- Contact: support@example.com

---

## License

Proprietary - Chrey E-commerce Platform