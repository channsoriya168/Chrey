<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product'])
            ->latest();

        // Search filter
        if ($request->has('filter.search') && $request->input('filter.search')) {
            $search = $request->input('filter.search');
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->has('filter.status') && $request->input('filter.status')) {
            $query->where('status', $request->input('filter.status'));
        }

        // Payment status filter
        if ($request->has('filter.payment_status') && $request->input('filter.payment_status')) {
            $query->where('payment_status', $request->input('filter.payment_status'));
        }

        $perPage = $request->input('per_page', 10);
        $orders = $query->paginate($perPage);

        // Calculate total for each order
        $orders->getCollection()->transform(function ($order) {
            $order->calculated_total = $order->orderItems->sum(function ($item) {
                return $item->total;
            });
            $order->items_count = $order->orderItems->count();
            return $order;
        });

        return inertia('Dashboard/Orders/Index', [
            'orders' => $orders,
            'filters' => [
                'search' => $request->input('filter.search'),
                'status' => $request->input('filter.status'),
                'payment_status' => $request->input('filter.payment_status'),
                'per_page' => $perPage
            ]
        ]);
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);

        // Calculate totals
        $itemsSubtotal = $order->orderItems->sum(function ($item) {
            return $item->subtotal;
        });

        $itemsTotal = $order->orderItems->sum(function ($item) {
            return $item->total;
        });

        return inertia('Dashboard/Orders/Show', [
            'order' => $order,
            'itemsSubtotal' => $itemsSubtotal,
            'itemsTotal' => $itemsTotal
        ]);
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Update payment status.
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        $order->update([
            'payment_status' => $request->payment_status
        ]);

        return back()->with('success', 'Payment status updated successfully!');
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Order $order)
    {
        $order->orderItems()->delete();
        $order->delete();

        return redirect()->route('dashboard.orders.index')
            ->with('success', 'Order deleted successfully!');
    }
}