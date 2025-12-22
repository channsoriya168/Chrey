<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\BakongService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $bakongService;

    public function __construct(BakongService $bakongService)
    {
        $this->bakongService = $bakongService;
    }

    /**
     * Show KHQR payment page
     */
    public function showKhqrPayment(Order $order)
    {
        // Verify the order belongs to the user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Verify payment method is KHQR
        if ($order->payment_method !== 'khqr') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Invalid payment method');
        }

        // Generate KHQR if not already generated
        if (!$order->bakong_qr_data) {
            $khqrData = $this->bakongService->generateKHQR([
                'amount' => $order->total_amount,
                'currency' => 'USD',
                'description' => 'Order ' . $order->order_number,
                'order_id' => $order->id,
            ]);

            if ($khqrData) {
                $order->update([
                    'bakong_qr_data' => $khqrData['qr'] ?? json_encode($khqrData),
                    'bakong_transaction_id' => $khqrData['transactionId'] ?? $khqrData['id'] ?? null,
                ]);
            } else {
                return redirect()->route('orders.show', $order->id)
                    ->with('error', 'Failed to generate payment QR code. Please try again.');
            }
        }

        $order->load(['orderItems.product']);

        return inertia('Payment/Khqr', [
            'order' => $order,
            'qrData' => $order->bakong_qr_data,
        ]);
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(Order $order)
    {
        // Verify the order belongs to the user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$order->bakong_transaction_id) {
            return response()->json([
                'status' => 'pending',
                'message' => 'Transaction ID not found'
            ]);
        }

        $paymentStatus = $this->bakongService->checkPaymentStatus($order->bakong_transaction_id);

        if ($paymentStatus) {
            $status = $paymentStatus['status'] ?? 'pending';

            if ($status === 'completed' || $status === 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                ]);

                return response()->json([
                    'status' => 'paid',
                    'message' => 'Payment successful',
                    'redirect' => route('orders.show', $order->id)
                ]);
            }
        }

        return response()->json([
            'status' => $order->payment_status,
            'message' => 'Payment pending'
        ]);
    }

    /**
     * Handle Bakong webhook
     */
    public function handleWebhook(Request $request)
    {
        $signature = $request->header('X-Bakong-Signature');
        $payload = $request->all();

        // Verify webhook signature
        if (!$this->bakongService->verifyWebhookSignature($payload, $signature)) {
            Log::warning('Invalid Bakong webhook signature');
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        // Find order by transaction ID
        $order = Order::where('bakong_transaction_id', $payload['transactionId'] ?? null)->first();

        if (!$order) {
            Log::warning('Order not found for Bakong webhook', ['payload' => $payload]);
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Update order status based on payment status
        if (($payload['status'] ?? '') === 'completed' || ($payload['status'] ?? '') === 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);

            Log::info('Bakong payment completed', ['order_id' => $order->id]);
        }

        return response()->json(['success' => true]);
    }
}
