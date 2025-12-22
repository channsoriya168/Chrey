<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic counts
        $users = User::count();
        $products = Product::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();

        // Revenue statistics
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        // Sales trend (last 7 days)
        $salesTrend = Order::where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => date('M d', strtotime($item->date)),
                    'orders' => $item->orders,
                    'revenue' => (float) $item->revenue,
                ];
            });

        // Fill missing dates with zero values
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateStr = $date->format('M d');
            $dateKey = $date->format('Y-m-d');

            $existingData = $salesTrend->firstWhere('date', $dateStr);

            $last7Days->push([
                'date' => $dateStr,
                'orders' => $existingData ? $existingData['orders'] : 0,
                'revenue' => $existingData ? $existingData['revenue'] : 0,
            ]);
        }

        // Order status distribution
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => ucfirst($item->status),
                    'value' => $item->count,
                ];
            });

        // Payment status distribution
        $ordersByPaymentStatus = Order::selectRaw('payment_status, COUNT(*) as count')
            ->groupBy('payment_status')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => ucfirst($item->payment_status),
                    'value' => $item->count,
                ];
            });

        // Top selling products (last 30 days)
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.created_at', '>=', now()->subDays(30))
            ->selectRaw('products.name, SUM(order_items.quantity) as total_sold')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'sales' => (int) $item->total_sold,
                ];
            });

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer' => $order->user->name ?? 'Guest',
                    'total' => $order->total_amount,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'created_at' => $order->created_at->format('M d, Y'),
                ];
            });

        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'users' => $users,
                'products' => $products,
                'totalOrders' => $totalOrders,
                'pendingOrders' => $pendingOrders,
                'totalRevenue' => $totalRevenue,
                'monthlyRevenue' => $monthlyRevenue,
            ],
            'charts' => [
                'salesTrend' => $last7Days,
                'ordersByStatus' => $ordersByStatus,
                'ordersByPaymentStatus' => $ordersByPaymentStatus,
                'topProducts' => $topProducts,
            ],
            'recentOrders' => $recentOrders,
        ]);
    }
}
