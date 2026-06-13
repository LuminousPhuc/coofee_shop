<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Topping;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Home page — shows banner + bestsellers only (max 5, with "Xem thêm" if more exist).
     */
    public function index()
    {
        $bestsellers = Product::with('category')
            ->where('is_active', 1)
            ->where('is_bestseller', 1)
            ->orderBy('id')
            ->get();

        $hasMore = $bestsellers->count() > 5;
        $displayBestsellers = $bestsellers->take(5);

        return view('front.home', compact('displayBestsellers', 'hasMore'));
    }

    /**
     * Full shop page — all products with search & category filter.
     */
    public function shop(Request $request)
    {
        $query = Product::with('category')->where('is_active', 1);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderBy('id')
            ->paginate(15)
            ->appends($request->only(['search', 'category_id']));

        $categories = Category::where('is_active', 1)->get();

        return view('front.shop', compact('products', 'categories'));
    }

    /**
     * Bestsellers page — all products with is_bestseller = 1.
     */
    public function bestsellers(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', 1)
            ->where('is_bestseller', 1);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderBy('id')
            ->paginate(15)
            ->appends($request->only(['category_id']));

        $categories = Category::where('is_active', 1)->get();

        return view('front.bestsellers', compact('products', 'categories'));
    }

    /**
     * Product detail page.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', 1)
            ->with(['optionGroups.optionValues', 'category'])
            ->firstOrFail();

        $toppings = Topping::where('is_available', 1)->get();

        return view('front.product_detail', compact('product', 'toppings'));
    }

    /**
     * About Us page.
     */
    public function about()
    {
        return view('front.about');
    }
}
