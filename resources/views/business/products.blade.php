@extends('business.layout')

@section('title', 'Products')
@section('nav-products', 'bg-[#f5f3ef] text-gray-900')

@section('content')

    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Products</h1>
        <p class="text-[14px] text-gray-600">Manage your product inventory.</p>
    </div>

    <!-- Add Product Form -->
    <div class="bg-white border border-[#e8e5e0] mb-10">
        <div class="px-6 py-4 border-b border-[#e8e5e0]">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Add New Product</h2>
        </div>
        <form method="POST" action="{{ route('business.products.store') }}" class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5" enctype="multipart/form-data">
            @csrf
            <div class="sm:col-span-2">
                <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Product Name</label>
                <input type="text" name="name" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Description</label>
                <textarea name="description" rows="3" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400"></textarea>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Product Image</label>
                <input type="file" name="image" accept="image/*" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
            </div>
            <div>
                <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Category</label>
                <select name="category_id" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Status</label>
                <select name="status" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="flagged">Flagged</option>
                </select>
            </div>
            <div>
                <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Gender</label>
                <select name="gender" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
                    <option value="men">Men</option>
                    <option value="women">Women</option>
                    <option value="unisex">Unisex</option>
                </select>
            </div>
            <div>
                <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Retail Price (₱)</label>
                <input type="number" name="retail_price" step="0.01" min="0" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
            </div>
            <div>
                <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Wholesale Price (₱)</label>
                <input type="number" name="wholesale_price" step="0.01" min="0" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Bulk Pricing Tiers</label>
                <div id="bulk-pricing-container" class="space-y-3">
                    <div class="bulk-pricing-row grid grid-cols-2 gap-3">
                        <input type="number" name="bulk_min_quantity[]" placeholder="Min Qty (100)" min="1" class="border border-[#e8e5e0] rounded px-3 py-2 text-[14px] focus:outline-none focus:border-gray-400">
                        <input type="number" name="bulk_max_quantity[]" placeholder="Max Qty (200)" min="1" class="border border-[#e8e5e0] rounded px-3 py-2 text-[14px] focus:outline-none focus:border-gray-400">
                    </div>
                </div>
                <button type="button" onclick="addBulkPricingRow()" class="mt-3 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">
                    + Add Bulk Tier
                </button>
            </div>
            <div>
                <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Stock</label>
                <input type="number" name="stock" min="0" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
            </div>
            <div class="sm:col-span-2">
                <button type="submit" class="px-6 py-2.5 bg-[#111] text-white text-[12px] font-semibold tracking-[0.1em] uppercase rounded hover:bg-gray-800 transition-colors">Add Product</button>
            </div>
        </form>
    </div>

    <!-- Products List -->
    <div class="bg-white border border-[#e8e5e0]">
        <div class="px-6 py-4 border-b border-[#e8e5e0]">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Your Products</h2>
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
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Bulk Tiers</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Stock</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Status</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
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
                            <td class="px-6 py-4">
                                @if($product->bulkPricing->count() > 0)
                                    <div class="text-[12px] space-y-0.5">
                                        @foreach($product->bulkPricing as $bulk)
                                            <div class="text-gray-600">
                                                {{ $bulk->min_quantity }}{{ $bulk->max_quantity ? '-'.$bulk->max_quantity : '+' }} pieces
                                                <br>
                                                <span class="text-green-600">
                                                    @if($bulk->min_quantity >= 100 && $bulk->max_quantity <= 200)
                                                        10% off
                                                    @elseif($bulk->min_quantity > 200)
                                                        15% off
                                                    @else
                                                        5% off
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 text-[12px]">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-[14px] {{ $product->stock == 0 ? 'text-red-600' : 'text-gray-600' }}">{{ $product->stock }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-0.5 text-[11px] font-semibold tracking-wider uppercase rounded-full {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : ($product->status == 'flagged' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">{{ $product->status }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button onclick="openEditModal({{ $product->id }})" class="text-[11px] font-semibold tracking-[0.1em] uppercase text-blue-600 hover:text-blue-800 transition-colors">
                                        Update
                                    </button>
                                    <button onclick="archiveProduct({{ $product->id }}, this)" class="text-[11px] font-semibold tracking-[0.1em] uppercase text-red-600 hover:text-red-800 transition-colors">
                                        Archive
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-10 text-center text-[14px] text-gray-500">
                                No products found. Add your first product above.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-[16px] font-semibold tracking-[0.1em] uppercase text-gray-700">Update Product</h3>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editProductId" name="product_id">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Product Name</label>
                        <input type="text" id="edit_name" name="name" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Description</label>
                        <textarea id="edit_description" name="description" rows="3" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400"></textarea>
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Category</label>
                        <select id="edit_category_id" name="category_id" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Status</label>
                        <select id="edit_status" name="status" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="flagged">Flagged</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Gender</label>
                        <select id="edit_gender" name="gender" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
                            <option value="men">Men</option>
                            <option value="women">Women</option>
                            <option value="unisex">Unisex</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Retail Price (₱)</label>
                        <input type="number" id="edit_retail_price" name="retail_price" step="0.01" min="0" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Wholesale Price (₱)</label>
                        <input type="number" id="edit_wholesale_price" name="wholesale_price" step="0.01" min="0" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Stock</label>
                        <input type="number" id="edit_stock" name="stock" min="0" required class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Product Image</label>
                        <input type="file" id="edit_image" name="image" accept="image/*" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400">
                        <p class="text-[11px] text-gray-500 mt-1">Leave empty to keep current image</p>
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="px-6 py-2.5 bg-[#111] text-white text-[12px] font-semibold tracking-[0.1em] uppercase rounded hover:bg-gray-800 transition-colors">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function addBulkPricingRow() {
    const container = document.getElementById('bulk-pricing-container');
    const newRow = document.createElement('div');
    newRow.className = 'bulk-pricing-row grid grid-cols-2 gap-3';
    newRow.innerHTML = `
        <input type="number" name="bulk_min_quantity[]" placeholder="Min Qty" min="1" class="border border-[#e8e5e0] rounded px-3 py-2 text-[14px] focus:outline-none focus:border-gray-400">
        <input type="number" name="bulk_max_quantity[]" placeholder="Max Qty" min="1" class="border border-[#e8e5e0] rounded px-3 py-2 text-[14px] focus:outline-none focus:border-gray-400">
    `;
    container.appendChild(newRow);
}

function openEditModal(productId) {
    console.log('Opening edit modal for product:', productId);
    
    // Fetch product data via AJAX
    fetch(`/business/products/${productId}/edit`)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Product data:', data);
            document.getElementById('editProductId').value = data.id;
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_description').value = data.description || '';
            document.getElementById('edit_category_id').value = data.category_id;
            document.getElementById('edit_status').value = data.status;
            document.getElementById('edit_gender').value = data.gender;
            document.getElementById('edit_retail_price').value = data.retail_price;
            document.getElementById('edit_wholesale_price').value = data.wholesale_price || '';
            document.getElementById('edit_stock').value = data.stock;
            document.getElementById('editForm').action = `/business/products/${data.id}`;
            
            document.getElementById('editModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading product data: ' + error.message);
        });
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function archiveProduct(productId, button) {
    if (!confirm('Are you sure you want to archive this product?')) return;

    const token = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = token ? token.content : '';

    fetch(`/business/products/${productId}/archive`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the row from the table
            const row = button.closest('tr');
            row.style.transition = 'opacity 0.3s';
            row.style.opacity = '0';
            setTimeout(() => row.remove(), 300);
        } else {
            alert('Error archiving product');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error archiving product');
    });
}
</script>
@endpush
