<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Review;
use App\Models\Wishlist;
use App\Services\DiscountEngine;
use App\Services\RecommendationEngine;
use App\Services\SearchService;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $products = SearchService::searchProducts($request->all())
            ->paginate(24);

        $categories = Category::all();
        $trending = RecommendationEngine::trending(6);

        return view('marketplace.index', compact('products', 'categories', 'trending'));
    }

    public function show(Product $product)
    {
        $product->load(['business.businessProfile', 'category', 'variants', 'discountTiers']);

        RecommendationEngine::recordView(
            $product->id,
            auth()->id(),
            session()->getId()
        );

        $reviews = Review::where('product_id', $product->id)
            ->where('status', 'approved')
            ->with('user')
            ->latest()
            ->paginate(10);

        $avgRating = Review::where('product_id', $product->id)
            ->where('status', 'approved')
            ->avg('rating') ?? 0;

        $alsoBought = RecommendationEngine::alsoBought($product->id, 6);
        $related = RecommendationEngine::related($product->id, 6);

        $isWishlisted = auth()->check()
            ? Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists()
            : false;

        return view('marketplace.show', compact(
            'product', 'reviews', 'avgRating', 'alsoBought', 'related', 'isWishlisted'
        ));
    }

    public function store(string $slug)
    {
        $business = User::where('role', User::ROLE_BUSINESS)
            ->whereHas('businessProfile', function ($q) use ($slug) {
                $q->whereRaw("LOWER(REPLACE(business_name, ' ', '-')) = ?", [strtolower($slug)]);
            })
            ->with('businessProfile')
            ->firstOrFail();

        $products = Product::where('business_id', $business->id)
            ->where('status', 'active')
            ->with('category')
            ->latest()
            ->paginate(24);

        $categories = Category::whereHas('products', function ($q) use ($business) {
            $q->where('business_id', $business->id);
        })->get();

        return view('marketplace.store', compact('business', 'products', 'categories'));
    }

    public function calculatePrice(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:retail,wholesale',
        ]);

        $quantity = (int) $request->quantity;
        $type = $request->type;

        if ($type === 'wholesale' && !$product->is_wholesale_enabled) {
            return response()->json(['error' => 'Wholesale not available for this product.'], 422);
        }

        if ($type === 'wholesale' && !DiscountEngine::validateMoq($product, $quantity, $type)) {
            return response()->json(['error' => 'Minimum order quantity not met. MOQ: ' . $product->moq], 422);
        }

        $calc = DiscountEngine::calculate($product, $quantity, $type);
        $shipping = $product->getShippingFee($product->weight ?? 0.5);

        return response()->json([
            'base_price' => $calc['base_price'],
            'unit_price' => $calc['unit_price'],
            'discount_rate' => $calc['discount_rate'],
            'discount_amount' => $calc['discount_amount'],
            'subtotal' => $calc['total'],
            'shipping' => $shipping,
            'total' => $calc['total'] + $shipping,
        ]);
    }

    public function toggleWishlist(Request $request, Product $product)
    {
        $user = auth()->user();

        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['wishlisted' => false]);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'variant_id' => $request->variant_id,
        ]);

        return response()->json(['wishlisted' => true]);
    }

    public function wishlist()
    {
        $items = Wishlist::where('user_id', auth()->id())
            ->with('product.business.businessProfile', 'product.category')
            ->latest()
            ->paginate(24);

        return view('marketplace.wishlist', compact('items'));
    }

    public function storeReview(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
            'images' => 'nullable|array',
            'images.*' => 'file|max:2048',
        ]);

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'images' => $request->hasFile('images')
                ? array_map(fn($file) => $file->store('reviews', 'public'), $request->file('images'))
                : null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Review submitted and pending approval.');
    }
}
