<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\BulkPricing;

class BusinessController extends Controller
{
    public function index()
    {
        $business = auth()->user()->businessProfile;
        $businessId = auth()->id();

        $totalProducts = Product::where('business_id', $businessId)->count();
        $activeProducts = Product::where('business_id', $businessId)->where('status', 'active')->count();
        $outOfStock = Product::where('business_id', $businessId)->where('stock', 0)->count();

        $retailOrders = Order::where('business_id', $businessId)->where('type', 'retail')->count();
        $b2bOrders = Order::where('business_id', $businessId)->where('type', 'b2b')->count();
        $incomingRetail = Order::where('business_id', $businessId)->where('type', 'retail')->whereIn('status', ['pending', 'processing'])->count();
        $bulkRequests = Order::where('business_id', $businessId)->where('type', 'b2b')->whereIn('status', ['pending', 'processing'])->count();
        $toShip = Order::where('business_id', $businessId)->whereIn('status', ['processing', 'shipped'])->count();
        $shipped = Order::where('business_id', $businessId)->where('status', 'shipped')->count();

        $totalEarnings = Order::where('business_id', $businessId)->where('status', 'delivered')->sum('total');
        $retailSales = Order::where('business_id', $businessId)->where('type', 'retail')->where('status', 'delivered')->count();
        $b2bSales = Order::where('business_id', $businessId)->where('type', 'b2b')->where('status', 'delivered')->count();
        $pendingCommission = Order::where('business_id', $businessId)->where('status', 'delivered')->sum('commission');
        $availableEarnings = $totalEarnings - $pendingCommission;

        $bestSellingProduct = Product::where('business_id', $businessId)
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->first();

        $soloBuyerCustomers = Order::where('business_id', $businessId)
            ->whereHas('buyer', function ($q) {
                $q->where('role', 'buyer');
            })
            ->distinct('buyer_id')
            ->count();

        $businessCustomers = Order::where('business_id', $businessId)
            ->whereHas('buyer', function ($q) {
                $q->where('role', 'business');
            })
            ->distinct('buyer_id')
            ->count();

        $wholesaleListings = Product::where('business_id', $businessId)->where('wholesale_price', '>', 0)->count();

        return view('business.dashboard', compact(
            'business',
            'totalProducts',
            'activeProducts',
            'outOfStock',
            'retailOrders',
            'b2bOrders',
            'incomingRetail',
            'bulkRequests',
            'toShip',
            'shipped',
            'totalEarnings',
            'retailSales',
            'b2bSales',
            'pendingCommission',
            'availableEarnings',
            'bestSellingProduct',
            'soloBuyerCustomers',
            'businessCustomers',
            'wholesaleListings'
        ));
    }

    public function products()
    {
        $businessId = auth()->id();
        $products = Product::where('business_id', $businessId)
            ->whereIn('status', ['active', 'flagged'])
            ->with('category')
            ->latest()
            ->get();
        $categories = Category::all();
        return view('business.products', compact('products', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'retail_price' => 'required|numeric|min:0',
            'wholesale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive,flagged',
            'gender' => 'required|in:men,women,unisex',
            'image' => 'nullable|file|max:10240',
            'bulk_min_quantity' => 'array',
            'bulk_min_quantity.*' => 'nullable|integer|min:1',
            'bulk_max_quantity' => 'array',
            'bulk_max_quantity.*' => 'nullable|integer|min:1',
        ]);

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'business_id' => auth()->id(),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'category_id' => $validated['category_id'],
            'retail_price' => $validated['retail_price'],
            'wholesale_price' => $validated['wholesale_price'] ?? null,
            'stock' => $validated['stock'],
            'status' => $validated['status'],
            'gender' => $validated['gender'],
            'image' => $imagePath,
        ]);

        // Save bulk pricing tiers
        if ($request->has('bulk_min_quantity')) {
            foreach ($request->bulk_min_quantity as $key => $minQty) {
                if (!empty($minQty)) {
                    BulkPricing::create([
                        'product_id' => $product->id,
                        'min_quantity' => $minQty,
                        'max_quantity' => $request->bulk_max_quantity[$key] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('business.products')->with('success', 'Product created successfully.');
    }

    public function editProduct(Product $product)
    {
        if ($product->business_id !== auth()->id()) {
            abort(403);
        }

        return response()->json($product);
    }

    public function updateProduct(Request $request, Product $product)
    {
        if ($product->business_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'retail_price' => 'required|numeric|min:0',
            'wholesale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive,flagged',
            'gender' => 'required|in:men,women,unisex',
            'image' => 'nullable|file|max:10240',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'category_id' => $validated['category_id'],
            'retail_price' => $validated['retail_price'],
            'wholesale_price' => $validated['wholesale_price'] ?? null,
            'stock' => $validated['stock'],
            'status' => $validated['status'],
            'gender' => $validated['gender'],
        ];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('products', 'public');
            $updateData['image'] = $imagePath;
        }

        $product->update($updateData);

        return redirect()->route('business.products')->with('success', 'Product updated successfully.');
    }

    public function archiveProduct(Request $request, Product $product)
    {
        if ($product->business_id !== auth()->id()) {
            abort(403);
        }

        $product->status = 'inactive';
        $product->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Product archived successfully']);
        }

        return redirect()->route('business.products')->with('success', 'Product archived successfully.');
    }

    public function archivedProducts()
    {
        $businessId = auth()->id();
        $archivedProducts = Product::where('business_id', $businessId)
            ->where('status', 'inactive')
            ->with('category')
            ->latest()
            ->get();

        return view('business.archived', compact('archivedProducts'));
    }

    public function restoreProduct(Request $request, Product $product)
    {
        if ($product->business_id !== auth()->id()) {
            abort(403);
        }

        $product->status = 'active';
        $product->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Product restored successfully']);
        }

        return redirect()->route('business.products.archived')->with('success', 'Product restored successfully.');
    }

    public function deleteProduct(Request $request, Product $product)
    {
        if ($product->business_id !== auth()->id()) {
            abort(403);
        }

        $product->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
        }

        return redirect()->route('business.products.archived')->with('success', 'Product deleted successfully.');
    }

    public function orders()
    {
        $retailOrders = collect();
        $b2bOrders = collect();
        return view('business.orders', compact('retailOrders', 'b2bOrders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        if ($order->business_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('business.orders')->with('success', 'Order status updated successfully.');
    }

    public function sales()
    {
        $orders = collect();
        $totalRevenue = 0;
        $totalCommission = 0;
        $netEarnings = 0;

        return view('business.sales', compact('orders', 'totalRevenue', 'totalCommission', 'netEarnings'));
    }
}
