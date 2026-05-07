<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function index()
    {
        $recentlyViewed = \App\Services\RecommendationEngine::recentlyViewed(
            auth()->id(),
            session()->getId(),
            8
        );

        $trending = \App\Services\RecommendationEngine::trending(8);

        $orders = \App\Models\Order::where('buyer_id', auth()->id())
            ->with('business.businessProfile')
            ->latest()
            ->limit(5)
            ->get();

        $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();

        return view('buyer.dashboard', compact('recentlyViewed', 'trending', 'orders', 'wishlistCount'));
    }

    public function orders()
    {
        $orders = \App\Models\Order::where('buyer_id', auth()->id())
            ->with('business.businessProfile', 'items.product')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('buyer.orders', compact('orders'));
    }

    public function wishlist()
    {
        $items = \App\Models\Wishlist::where('user_id', auth()->id())
            ->with('product.business.businessProfile', 'product.category')
            ->latest()
            ->paginate(24);

        return view('buyer.wishlist', compact('items'));
    }

    public function notifications()
    {
        $notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('buyer.notifications', compact('notifications'));
    }
}
