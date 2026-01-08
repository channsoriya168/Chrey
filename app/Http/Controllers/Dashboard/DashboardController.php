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
        $pendingOrders = Order::where('status', 'paid')->count();

        // Revenue statistics - calculate from order_items using Eloquent
        $totalRevenue = Order::with('orderItems')
            ->get()
            ->sum(function ($order) {
                return $order->orderItems->sum('total');
            });

        $monthlyRevenue = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->with('orderItems')
            ->get()
            ->sum(function ($order) {
                return $order->orderItems->sum('total');
            });

        // Sales trend (last 7 days)
        $salesTrend = Order::where('created_at', '>=', now()->subDays(7))
            ->with('orderItems')
            ->get()
            ->groupBy(function ($order) {
                return $order->created_at->format('Y-m-d');
            })
            ->map(function ($orders, $date) {
                return [
                    'date' => date('M d', strtotime($date)),
                    'orders' => $orders->count(),
                    'revenue' => (float) $orders->sum(function ($order) {
                        return $order->orderItems->sum('total');
                    }),
                ];
            })
            ->sortBy('date')
            ->values();

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
        $recentOrders = Order::with(['user', 'orderItems'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer' => $order->user->name ?? 'Guest',
                    'total' => $order->orderItems->sum('total'),
                    'status' => $order->status,
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
                'topProducts' => $topProducts,
            ],
            'recentOrders' => $recentOrders,
        ]);
    }
}
