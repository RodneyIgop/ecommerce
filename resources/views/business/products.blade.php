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
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Your Products</h2>
                <div class="flex items-center gap-3">
                    <label class="text-[11px] text-gray-500 font-medium">Filter:</label>
                    <select id="categoryFilter" class="bg-white border border-[#e8e5e0] text-[12px] py-2 px-3 rounded focus:outline-none focus:border-black focus:ring-1 focus:ring-black">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    data-is-clothing="{{ str_contains(strtolower($category->name), 'clothing') || str_contains(strtolower($category->name), 'shirt') || str_contains(strtolower($category->name), 'pants') || str_contains(strtolower($category->name), 'dress') ? 'true' : 'false' }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <button id="clearFilter" class="text-[11px] text-gray-600 hover:text-black underline transition-colors {{ request('category') ? '' : 'hidden' }}">Clear</button>
                </div>
            </div>
        </div>
        <div class="p-6 overflow-x-hidden">
            <div class="w-full max-w-[1200px] mx-auto overflow-x-hidden">
                <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="bg-white border border-[#e8e5e0] rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Product Image -->
                    <div class="aspect-square bg-gray-100 relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-[14px]">No Image</div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex px-2 py-1 text-[10px] font-semibold tracking-wider uppercase rounded-full {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : ($product->status == 'flagged' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $product->status }}
                            </span>
                        </div>
                        
                        <!-- Stock Badge -->
                        @if($product->stock == 0)
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex px-2 py-1 text-[10px] font-semibold tracking-wider uppercase rounded-full bg-red-100 text-red-800">
                                Out of Stock
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-4">
                        <h3 class="font-semibold text-[15px] text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                        
                        <!-- Category & Gender -->
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-[12px] text-gray-600">{{ $product->category->name ?? '—' }}</span>
                            <span class="inline-flex px-2 py-0.5 text-[10px] font-semibold tracking-wider uppercase rounded-full {{ $product->gender == 'men' ? 'bg-blue-100 text-blue-800' : ($product->gender == 'women' ? 'bg-pink-100 text-pink-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($product->gender) }}
                            </span>
                        </div>
                        
                        <!-- Prices -->
                        <div class="flex items-center gap-3 mb-3">
                            <div>
                                <p class="text-[11px] text-gray-500">Retail</p>
                                <p class="text-[14px] font-semibold text-gray-900">₱{{ number_format($product->retail_price, 2) }}</p>
                            </div>
                            @if($product->wholesale_price)
                            <div>
                                <p class="text-[11px] text-gray-500">Wholesale</p>
                                <p class="text-[14px] font-semibold text-gray-700">₱{{ number_format($product->wholesale_price, 2) }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Stock -->
                        <div class="mb-3">
                            <p class="text-[11px] text-gray-500">Stock</p>
                            <p class="text-[14px] font-medium {{ $product->stock == 0 ? 'text-red-600' : 'text-gray-600' }}">{{ $product->stock }} units</p>
                        </div>
                        
                        <!-- Discount Tiers -->
                        @if(($product->discountTiers ?? collect())->count() > 0)
                        <div class="mb-4">
                            <p class="text-[11px] text-gray-500 mb-1">Bulk Discounts</p>
                            <div class="space-y-1">
                                @foreach($product->discountTiers->take(2) as $tier)
                                <div class="text-[11px] text-gray-600">
                                    {{ $tier->min_quantity }}{{ $tier->max_quantity ? '-'.$tier->max_quantity : '+' }} pcs
                                    <span class="text-green-600 font-medium">{{ $tier->discount_percent }}% off</span>
                                </div>
                                @endforeach
                                @if($product->discountTiers->count() > 2)
                                <p class="text-[10px] text-gray-400">+{{ $product->discountTiers->count() - 2 }} more tiers</p>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <!-- Actions -->
                        <div class="flex gap-2">
                            <button onclick="openEditModal({{ $product->id }})" class="flex-1 bg-blue-600 text-white text-[11px] font-semibold tracking-[0.1em] uppercase py-2 px-3 rounded hover:bg-blue-700 transition-colors">
                                Update
                            </button>
                            <button onclick="archiveProduct({{ $product->id }}, this)" class="flex-1 border border-red-600 text-red-600 text-[11px] font-semibold tracking-[0.1em] uppercase py-2 px-3 rounded hover:bg-red-50 transition-colors">
                                Archive
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <p class="text-[14px] text-gray-500">No products found. Add your first product above.</p>
                </div>
            @endforelse
                </div>
            </div>
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
<style>
/* Uniform card sizes for all layouts */
#productsGrid > div {
    min-height: 480px !important;
    max-height: 480px !important;
    display: flex !important;
    flex-direction: column !important;
}

#productsGrid .aspect-square {
    aspect-ratio: 1/1 !important;
    min-height: 160px !important;
    max-height: 160px !important;
    flex-shrink: 0 !important;
}

#productsGrid .p-4 {
    padding: 1rem !important;
    flex-grow: 1 !important;
    display: flex !important;
    flex-direction: column !important;
}

#productsGrid h3 {
    font-size: 15px !important;
    line-height: 1.4 !important;
    margin-bottom: 0.5rem !important;
    flex-shrink: 0 !important;
}

#productsGrid .flex.items-center.gap-2 {
    margin-bottom: 0.75rem !important;
    flex-shrink: 0 !important;
}

#productsGrid .flex.items-center.gap-3 {
    margin-bottom: 0.75rem !important;
    flex-shrink: 0 !important;
}

#productsGrid .mb-3 {
    margin-bottom: 0.75rem !important;
    flex-shrink: 0 !important;
}

#productsGrid .mb-4 {
    margin-bottom: 1rem !important;
    flex-grow: 1 !important;
}

#productsGrid .flex.gap-2 {
    margin-top: auto !important;
    flex-shrink: 0 !important;
}

/* Consistent grid layout for all states - uniform across all categories */
#productsGrid {
    gap: 1rem !important;
    grid-template-columns: repeat(4, 1fr) !important;
    max-width: 100% !important;
    overflow-x: hidden !important;
}

#productsGrid > div {
    min-height: 480px !important;
    max-height: 480px !important;
    min-width: 220px !important;
    max-width: 300px !important;
    transform: none !important;
    margin: 0 !important;
    box-sizing: border-box !important;
}

/* Ensure buttons are always visible in clothing layout */
#productsGrid.grid-cols-2.md\:grid-cols-4.lg\:grid-cols-6.xl\:grid-cols-8 .flex.gap-2 {
    margin-top: auto !important;
    flex-shrink: 0 !important;
    padding-top: 0.5rem !important;
    display: flex !important;
    visibility: visible !important;
}

#productsGrid.grid-cols-2.md\:grid-cols-4.lg\:grid-cols-6.xl\:grid-cols-8 button {
    font-size: 11px !important;
    padding: 6px 8px !important;
    min-width: 60px !important;
    white-space: nowrap !important;
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

/* Make sure all button containers are visible */
#productsGrid .flex.gap-2 {
    display: flex !important;
    visibility: visible !important;
}

#productsGrid.grid-cols-2.md\:grid-cols-4.lg\:grid-cols-6.xl\:grid-cols-8 .mb-4 {
    margin-bottom: 0.5rem !important;
    flex-grow: 0 !important;
}

/* Adjust grid for wider cards on larger screens */
@media (min-width: 1280px) {
    #productsGrid.grid-cols-2.md\:grid-cols-4.lg\:grid-cols-6.xl\:grid-cols-8 {
        grid-template-columns: repeat(6, minmax(280px, 1fr)) !important;
    }
}

@media (min-width: 1536px) {
    #productsGrid.grid-cols-2.md\:grid-cols-4.lg\:grid-cols-6.xl\:grid-cols-8 {
        grid-template-columns: repeat(7, minmax(280px, 1fr)) !important;
    }
}
</style>
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
            // Remove the card from the grid
            const card = button.closest('.bg-white');
            card.style.transition = 'opacity 0.3s';
            card.style.opacity = '0';
            setTimeout(() => card.remove(), 300);
        } else {
            alert('Error archiving product');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error archiving product');
    });
}

// Function to update grid layout - uniform across all categories
function updateGridLayout(categoryId) {
    const productsGrid = document.getElementById('productsGrid');
    if (!productsGrid) return;
    
    // Keep uniform layout for all categories
    productsGrid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6';
}

// Category filter AJAX
document.getElementById('categoryFilter').addEventListener('change', function() {
    const categoryId = this.value;
    const clearBtn = document.getElementById('clearFilter');
    
    // Show/hide clear button
    if (categoryId) {
        clearBtn.classList.remove('hidden');
    } else {
        clearBtn.classList.add('hidden');
    }
    
    // Update grid layout immediately
    updateGridLayout(categoryId);
    
    // Show loading state
    const currentGrid = document.getElementById('productsGrid');
    if (currentGrid) {
        currentGrid.style.opacity = '0.5';
    }
    
    // Fetch filtered products
    fetch(`{{ route('business.products.filter') }}?category=${categoryId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(html => {
        // Create a temporary div to parse the response
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        
        // Extract the products grid from the response
        const newProductsGrid = tempDiv.querySelector('#productsGrid');
        
        if (newProductsGrid && currentGrid) {
            currentGrid.innerHTML = newProductsGrid.innerHTML;
            // Reapply the grid layout after content replacement
            updateGridLayout(categoryId);
            currentGrid.style.opacity = '1';
        } else {
            console.error('Could not find grid elements');
            if (currentGrid) currentGrid.style.opacity = '1';
        }
    })
    .catch(error => {
        console.error('Error filtering products:', error);
        if (currentGrid) currentGrid.style.opacity = '1';
        alert('Error filtering products. Please try again.');
    });
});

// Clear filter
document.getElementById('clearFilter').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('categoryFilter').value = '';
    this.classList.add('hidden');
    
    // Reset grid layout to normal
    updateGridLayout('');
    
    // Show loading state
    const currentGrid = document.getElementById('productsGrid');
    if (currentGrid) {
        currentGrid.style.opacity = '0.5';
    }
    
    // Fetch all products
    fetch(`{{ route('business.products.filter') }}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(html => {
        // Create a temporary div to parse the response
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        
        // Extract the products grid from the response
        const newProductsGrid = tempDiv.querySelector('#productsGrid');
        
        if (newProductsGrid && currentGrid) {
            currentGrid.innerHTML = newProductsGrid.innerHTML;
            // Reapply the grid layout after content replacement (normal layout)
            updateGridLayout('');
            currentGrid.style.opacity = '1';
        } else {
            console.error('Could not find grid elements');
            if (currentGrid) currentGrid.style.opacity = '1';
        }
    })
    .catch(error => {
        console.error('Error clearing filter:', error);
        if (currentGrid) currentGrid.style.opacity = '1';
        alert('Error clearing filter. Please try again.');
    });
});
</script>
@endpush
