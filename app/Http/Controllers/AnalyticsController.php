<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;
use App\Models\PreorderQueue;
use App\Models\InventoryLog;
use App\Services\RecommendationEngine;

class AnalyticsController extends Controller
{
    public function businessDashboard()
    {
        $businessId = auth()->id();

        $totalSales = Order::where('business_id', $businessId)
            ->whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_COMPLETED])
            ->sum('total');

        $totalOrders = Order::where('business_id', $businessId)->count();
        $pendingOrders = Order::where('business_id', $businessId)
            ->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_PACKED])
            ->count();

        $salesData = Order::where('business_id', $businessId)
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total) as sales, COUNT(*) as orders')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProducts = Product::where('business_id', $businessId)
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->limit(10)
            ->get();

        $wholesaleOrders = Order::where('business_id', $businessId)
            ->where('type', 'b2b')
            ->count();

        $wholesaleRevenue = Order::where('business_id', $businessId)
            ->where('type', 'b2b')
            ->whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_COMPLETED])
            ->sum('total');

        $preorderStats = PreorderQueue::whereHas('product', function ($q) use ($businessId) {
            $q->where('business_id', $businessId);
        })
        ->selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status');

        $inventoryAlerts = Product::where('business_id', $businessId)
            ->whereRaw('stock - COALESCE(reserved_stock, 0) <= 10')
            ->where('status', 'active')
            ->get();

        $inventoryHistory = InventoryLog::whereHas('product', function ($q) use ($businessId) {
            $q->where('business_id', $businessId);
        })
        ->latest()
        ->limit(50)
        ->get();

        $customerStats = DB::table('orders')
            ->where('business_id', $businessId)
            ->selectRaw('
                COUNT(DISTINCT buyer_id) as total_customers,
                COUNT(DISTINCT CASE WHEN type = "retail" THEN buyer_id END) as retail_customers,
                COUNT(DISTINCT CASE WHEN type = "b2b" THEN buyer_id END) as wholesale_customers
            ')
            ->first();

        return view('business.analytics', compact(
            'totalSales', 'totalOrders', 'pendingOrders', 'salesData',
            'topProducts', 'wholesaleOrders', 'wholesaleRevenue',
            'preorderStats', 'inventoryAlerts', 'inventoryHistory', 'customerStats'
        ));
    }

    public function adminDashboard()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $totalSales = Order::whereIn('status', [Order::STATUS_DELIVERED, Order::STATUS_COMPLETED])
            ->sum('total');

        $totalCommission = Order::sum('commission') + Order::sum('platform_fee');
        $activeBusinesses = \App\Models\User::where('role', \App\Models\User::ROLE_BUSINESS)
            ->where('status', 'active')
            ->count();

        $pendingDisputes = \App\Models\Dispute::where('status', 'open')->count();

        $monthlyRevenue = Order::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total) as revenue, SUM(commission + platform_fee) as commission')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topCategories = RecommendationEngine::bestSellingCategories(10);

        return view('admin.analytics_advanced', compact(
            'totalSales', 'totalCommission', 'activeBusinesses',
            'pendingDisputes', 'monthlyRevenue', 'topCategories'
        ));
    }
}
