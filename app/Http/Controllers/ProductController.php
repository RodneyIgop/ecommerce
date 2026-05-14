<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', 'active');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category filtering
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->get();
        $categories = Category::all();
        $selectedCategory = $request->category;

        // Return JSON for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'products' => $products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'retail_price' => $product->retail_price,
                        'wholesale_price' => $product->wholesale_price,
                        'moq' => $product->moq,
                        'is_wholesale_enabled' => $product->is_wholesale_enabled,
                        'stock' => $product->stock,
                        'image' => $product->image,
                        'category_name' => $product->category ? $product->category->name : 'General',
                    ];
                })
            ]);
        }

        return view('products', compact('products', 'categories', 'selectedCategory'));
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('product-detail', compact('product'));
    }
}
