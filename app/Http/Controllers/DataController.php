<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function categories()
    {
        $categories = Category::all();
        return response()->json([
            'categories' => CategoryResource::collection($categories)
        ]);
    }
}
