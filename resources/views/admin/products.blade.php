@extends('admin.layout')
@section('title', 'Product Oversight')
@section('nav-products', 'bg-[#f5f3ef] text-gray-900')
@section('content')
<div class="mb-8"><h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Product Oversight</h1><p class="text-[14px] text-gray-600">Review, approve, and flag products across the platform.</p></div>
<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total Products</p><p class="text-[28px] font-light text-gray-900">{{ $products->count() }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Active</p><p class="text-[28px] font-light text-gray-900">{{ $products->where('status','active')->count() }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Flagged</p><p class="text-[28px] font-light text-gray-900">{{ $products->where('status','flagged')->count() }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Out of Stock</p><p class="text-[28px] font-light text-gray-900">{{ $products->where('stock',0)->count() }}</p></div>
</div>
<div class="bg-white border border-[#e8e5e0]">
    <div class="px-6 py-4 border-b border-[#e8e5e0]"><h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">All Products</h2></div>
    <div class="overflow-x-auto">
        <table class="w-full text-left"><thead><tr class="border-b border-[#e8e5e0] bg-[#faf9f7]">
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Product</th>
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Business</th>
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Category</th>
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Retail</th>
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Wholesale</th>
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Stock</th>
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Status</th>
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Action</th>
        </tr></thead><tbody>
        @forelse($products as $p)
        <tr class="border-b border-[#f0ede8] hover:bg-[#faf9f7]">
            <td class="px-6 py-4 text-[14px] font-medium">{{ $p->name }}</td>
            <td class="px-6 py-4 text-[14px] text-gray-600">{{ $p->business->name ?? '—' }}</td>
            <td class="px-6 py-4 text-[14px] text-gray-600">{{ $p->category->name ?? '—' }}</td>
            <td class="px-6 py-4 text-[14px] text-gray-900">₱{{ number_format($p->retail_price,2) }}</td>
            <td class="px-6 py-4 text-[14px] text-gray-600">{{ $p->wholesale_price ? '₱'.number_format($p->wholesale_price,2) : '—' }}</td>
            <td class="px-6 py-4 text-[14px] {{ $p->stock==0?'text-red-600':'text-gray-600' }}">{{ $p->stock }}</td>
            <td class="px-6 py-4"><span class="inline-flex px-2 py-0.5 text-[11px] font-semibold tracking-wider uppercase rounded-full {{ $p->status=='active'?'bg-green-100 text-green-800':($p->status=='flagged'?'bg-red-100 text-red-800':'bg-gray-100 text-gray-800') }}">{{ $p->status }}</span></td>
            <td class="px-6 py-4">
                <form method="POST" action="{{ route('admin.products.status', $p) }}" class="inline">@csrf @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="text-[12px] border border-[#e8e5e0] rounded px-2 py-1 bg-white cursor-pointer">
                        <option value="active" {{ $p->status=='active'?'selected':'' }}>Active</option>
                        <option value="inactive" {{ $p->status=='inactive'?'selected':'' }}>Inactive</option>
                        <option value="flagged" {{ $p->status=='flagged'?'selected':'' }}>Flagged</option>
                    </select>
                </form>
            </td>
        </tr>
        @empty<tr><td colspan="8" class="px-6 py-10 text-center text-[14px] text-gray-500">No products found.</td></tr>@endforelse
        </tbody></table>
    </div>
</div>
@endsection
