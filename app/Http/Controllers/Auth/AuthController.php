<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * Transfer guest cart to authenticated user
     */
    private function transferGuestCartToUser($oldSessionId = null)
    {
        $sessionId = $oldSessionId ?? session()->getId();
        $guestCart = Cart::with(['cartItems'])
            ->where('session_id', $sessionId)
            ->where('status', 'active')
            ->first();

        if (!$guestCart || $guestCart->cartItems->isEmpty()) {
            return;
        }

        // Find or create user cart
        $userCart = Cart::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'status' => 'active'
            ]
        );

        // Transfer/merge cart items
        foreach ($guestCart->cartItems as $guestItem) {
            $existingItem = $userCart->cartItems()
                ->where('product_id', $guestItem->product_id)
                ->first();

            if ($existingItem) {
                // Merge quantities
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $guestItem->quantity,
                    'price' => $guestItem->price
                ]);
            } else {
                // Move item to user cart
                $guestItem->update(['cart_id' => $userCart->id]);
            }
        }

        // Delete guest cart
        $guestCart->cartItems()->delete();
        $guestCart->delete();
    }

    // Show login page
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    // Show register page
    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    // Handle registration
    public function storeRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Save old session ID before login
        $oldSessionId = session()->getId();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Log the user in
        Auth::login($user);

        // Transfer guest cart to user using old session ID
        $this->transferGuestCartToUser($oldSessionId);

        return redirect()->route('home')
            ->with('success', 'គណនីបានបង្កើតដោយជោគជ័យ! សូមស្វាគមន៍។');
    }

    // Handle login
    public function storeLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Save old session ID before login
        $oldSessionId = session()->getId();

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Transfer guest cart to user using old session ID
            $this->transferGuestCartToUser($oldSessionId);

            // Get user name
            $userName = auth()->user()->name;

            if (auth()->user()->hasRole('admin')) {
                return redirect()->route('dashboard.index')
                    ->with('success', "សូមស្វាគមន៍មកវិញ, {$userName}!");
            }

            return redirect()->route('home')
                ->with('success', "សូមស្វាគមន៍មកវិញ, {$userName}!");
        }

        return back()
            ->withErrors([
                'email' => 'អ៊ីម៉ែល ឬលេខសម្ងាត់មិនត្រឹមត្រូវ។',
            ])
            ->with('error', 'អ៊ីម៉ែល ឬលេខសម្ងាត់មិនត្រឹមត្រូវ។ សូមពិនិត្យម្តងទៀត។');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'អ្នកបានចាកចេញដោយជោគជ័យ។ សូមជួបគ្នាម្តងទៀត!');
    }
}
