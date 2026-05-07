@extends('business.layout')

@section('title', 'Archived Products')
@section('nav-archived', 'bg-[#f5f3ef] text-gray-900')

@section('content')

    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Archived Products</h1>
        <p class="text-[14px] text-gray-600">View and manage your archived products</p>
    </div>

    <!-- Archived Products List -->
    <div class="bg-white border border-[#e8e5e0]">
        <div class="px-6 py-4 border-b border-[#e8e5e0]">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Archived Products</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-[#e8e5e0] bg-[#faf9f7]">
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Image</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Name</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Category</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Gender</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Retail</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Wholesale</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Stock</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($archivedProducts as $product)
                        <tr class="border-b border-[#f0ede8] hover:bg-[#faf9f7] transition-colors">
                            <td class="px-6 py-4">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded border border-[#e8e5e0]">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded border border-[#e8e5e0] flex items-center justify-center text-gray-400 text-[10px]">No Image</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-[14px] font-medium">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-[14px] text-gray-600">{{ $product->category->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-0.5 text-[11px] font-semibold tracking-wider uppercase rounded-full {{ $product->gender == 'men' ? 'bg-blue-100 text-blue-800' : ($product->gender == 'women' ? 'bg-pink-100 text-pink-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($product->gender) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-[14px] text-gray-900">₱{{ number_format($product->retail_price, 2) }}</td>
                            <td class="px-6 py-4 text-[14px] text-gray-600">{{ $product->wholesale_price ? '₱'.number_format($product->wholesale_price, 2) : '—' }}</td>
                            <td class="px-6 py-4 text-[14px] {{ $product->stock == 0 ? 'text-red-600' : 'text-gray-600' }}">{{ $product->stock }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button onclick="restoreProduct({{ $product->id }}, this)" class="text-[11px] font-semibold tracking-[0.1em] uppercase text-green-600 hover:text-green-800 transition-colors">
                                        Restore
                                    </button>
                                    <button onclick="deleteProduct({{ $product->id }}, this)" class="text-[11px] font-semibold tracking-[0.1em] uppercase text-red-600 hover:text-red-800 transition-colors">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-[14px] text-gray-500">
                                No archived products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function getCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return token ? token.content : '';
}

function restoreProduct(productId, button) {
    if (!confirm('Are you sure you want to restore this product?')) return;

    fetch(`/business/products/${productId}/restore`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = button.closest('tr');
            row.style.transition = 'opacity 0.3s';
            row.style.opacity = '0';
            setTimeout(() => row.remove(), 300);
        } else {
            alert('Error restoring product');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error restoring product');
    });
}

function deleteProduct(productId, button) {
    if (!confirm('Are you sure you want to permanently delete this product? This action cannot be undone.')) return;

    fetch(`/business/products/${productId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = button.closest('tr');
            row.style.transition = 'opacity 0.3s';
            row.style.opacity = '0';
            setTimeout(() => row.remove(), 300);
        } else {
            alert('Error deleting product');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting product');
    });
}
</script>
@endpush
