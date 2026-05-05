<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::withCount(['products' => function ($q) {
            $q->where('is_active', true);
        }])
            ->where('is_active', true)
            ->get();

        $latestProducts = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('featuredProducts', 'categories', 'latestProducts'));
    }
}
