<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $countCategories = Category::count();
        return Inertia::render('Dashboard/Index', [
            'countCategories' => $countCategories
        ]);
    }
}
