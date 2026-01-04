<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get user statistics
        $stats = $this->getUserStatistics($user->id);

        return Inertia::render('Frontend/Profile/Index', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name')->toArray(),
                'created_at' => $user->created_at,
            ],
            'stats' => $stats
        ]);
    }

    /**
     * Get user statistics
     */
    private function getUserStatistics($userId)
    {
        // Get total orders count
        $totalOrders = Order::where('user_id', $userId)->count();

        // Get total spent (sum of all completed/paid orders)
        $totalSpent = Order::where('user_id', $userId)
            ->whereIn('status', ['completed', 'paid', 'processing', 'shipped'])
            ->sum('total_amount');

        return [
            'totalOrders' => $totalOrders,
            'totalSpent' => number_format($totalSpent, 2)
        ];
    }

    /**
     * Update the user's profile information
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $request->user()->update([
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password updated successfully!');
    }
}
