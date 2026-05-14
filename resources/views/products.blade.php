@extends('layouts.app')

@section('title', 'Products')

@section('content')

    <!-- Hero Section -->
    <section class="bg-[#f5f3ef] py-16">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-10">
            <div class="text-center">
                <h1 class="font-serif-display text-[48px] sm:text-[60px] text-gray-900 mb-4">Products</h1>
                <p class="text-gray-600 text-[15px] max-w-2xl mx-auto">
                    Browse our collection of premium clothing and accessories.
                </p>
            </div>
        </div>
    </section>

    <!-- Search and Filter Section -->
    <section class="py-8 bg-white border-b border-[#e8e5e0]">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-10">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Search Bar -->
                <div class="flex-1 w-full md:w-auto">
                    <div class="relative">
                        <input type="text" 
                               id="search-input"
                               value="{{ request('search') }}"
                               placeholder="Search products..." 
                               class="w-full px-4 py-3 pl-12 border border-[#e8e5e0] bg-[#f5f3ef] text-[14px] text-gray-900 placeholder-gray-500 focus:outline-none focus:border-gray-900 transition-colors">
                        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="flex items-center gap-3">
                    <select id="category-filter" 
                            class="px-4 py-3 border border-[#e8e5e0] bg-[#f5f3ef] text-[14px] text-gray-900 focus:outline-none focus:border-gray-900 transition-colors cursor-pointer">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <button id="clear-filters" class="px-4 py-3 text-[14px] font-medium text-gray-700 hover:text-gray-900 transition-colors">
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="py-16">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-10">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white border border-[#e8e5e0] group hover:shadow-xl transition-all duration-300">
                            <!-- Product Image -->
                            <div class="aspect-[3/4] overflow-hidden bg-gray-100 relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <!-- Stock Badge -->
                                @if($product->stock == 0)
                                    <div class="absolute top-3 left-3 px-3 py-1 bg-red-600 text-white text-[11px] font-semibold uppercase tracking-wider rounded-full">
                                        Out of Stock
                                    </div>
                                @elseif($product->stock <= 10)
                                    <div class="absolute top-3 left-3 px-3 py-1 bg-orange-500 text-white text-[11px] font-semibold uppercase tracking-wider rounded-full">
                                        Low Stock
                                    </div>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="p-5">
                                <!-- Category -->
                                <span class="text-[11px] px-2 py-1 bg-[#f5f3ef] text-gray-700 rounded-full inline-block mb-3">
                                    {{ $product->category->name ?? 'General' }}
                                </span>

                                <!-- Product Name -->
                                <h3 class="text-[15px] font-medium text-gray-900 mb-2 line-clamp-2">
                                    {{ $product->name }}
                                </h3>

                                <!-- Description -->
                                <p class="text-[13px] text-gray-600 mb-4 line-clamp-2">
                                    {{ Str::limit($product->description, 80) }}
                                </p>

                                <!-- Price and Stock -->
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[18px] font-light text-gray-900">
                                        ₱{{ number_format($product->retail_price, 2) }}
                                    </span>
                                    <span class="text-[12px] {{ $product->stock > 0 ? 'text-green-700' : 'text-red-600' }}">
                                        {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}
                                    </span>
                                </div>

                                <!-- Quantity Selector and Actions -->
                                <div class="space-y-3">
                                    <!-- Quantity Selector -->
                                    <div class="flex items-center gap-2">
                                        <button onclick="decrementQuantity({{ $product->id }})" 
                                                class="w-8 h-8 flex items-center justify-center border border-[#e8e5e0] bg-[#f5f3ef] text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 12h-15" />
                                            </svg>
                                        </button>
                                        <input type="number" 
                                               id="quantity-{{ $product->id }}" 
                                               value="1" 
                                               min="1" 
                                               max="{{ $product->stock }}" 
                                               class="w-16 px-3 py-2 text-center border border-[#e8e5e0] bg-[#f5f3ef] text-[14px] text-gray-900 focus:outline-none focus:border-gray-900">
                                        <button onclick="incrementQuantity({{ $product->id }}, {{ $product->stock }})" 
                                                class="w-8 h-8 flex items-center justify-center border border-[#e8e5e0] bg-[#f5f3ef] text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-2">
                                        @auth
                                            @if($product->stock > 0)
                                                <button onclick="addToCart({{ $product->id }})" 
                                                        id="add-to-cart-{{ $product->id }}"
                                                        class="flex-1 py-2.5 px-4 bg-gray-900 text-white text-[12px] font-semibold uppercase tracking-wider hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                    </svg>
                                                    Add to Cart
                                                </button>
                                                <button onclick="buyNow({{ $product->id }})" 
                                                        class="flex-1 py-2.5 px-4 border-2 border-gray-900 text-gray-900 text-[12px] font-semibold uppercase tracking-wider hover:bg-gray-900 hover:text-white transition-colors">
                                                    Buy Now
                                                </button>
                                            @else
                                                <button disabled 
                                                        class="flex-1 py-2.5 px-4 bg-gray-300 text-gray-500 text-[12px] font-semibold uppercase tracking-wider cursor-not-allowed">
                                                    Out of Stock
                                                </button>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" 
                                               class="flex-1 py-2.5 px-4 bg-gray-900 text-white text-[12px] font-semibold uppercase tracking-wider hover:bg-gray-800 transition-colors text-center">
                                                Login to Buy
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <h3 class="text-[20px] font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-600 text-[14px] mb-6">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('products') }}" class="inline-block px-6 py-3 bg-gray-900 text-white text-[13px] font-semibold uppercase tracking-wider hover:bg-gray-800 transition-colors">
                        View All Products
                    </a>
                </div>
            @endif
        </div>
    </section>

@endsection

@push('scripts')
<script>
    let searchTimeout;
    let isLoading = false;
    let searchInput, categoryFilter, clearFiltersBtn, productsGrid;

    document.addEventListener('DOMContentLoaded', function() {
        searchInput = document.getElementById('search-input');
        categoryFilter = document.getElementById('category-filter');
        clearFiltersBtn = document.getElementById('clear-filters');
        productsGrid = document.querySelector('.grid');

        if (!searchInput || !categoryFilter || !clearFiltersBtn || !productsGrid) {
            console.error('Required DOM elements not found');
            return;
        }

        console.log('Filter elements initialized');

        // Live Search
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                filterProducts();
            }, 300);
        });

        // Category Filter
        categoryFilter.addEventListener('change', filterProducts);

        // Clear Filters
        clearFiltersBtn.addEventListener('click', () => {
            searchInput.value = '';
            categoryFilter.value = '';
            filterProducts();
        });
    });

    // Fetch Products
    async function filterProducts() {
        if (isLoading) return;

        const search = searchInput.value.trim();
        const category = categoryFilter.value;

        const params = new URLSearchParams();

        if (search) params.append('search', search);
        if (category) params.append('category', category);

        console.log('Filtering with params:', params.toString());

        // Update URL without page reload
        const newUrl = `${window.location.pathname}${params.toString() ? '?' + params.toString() : ''}`;
        window.history.replaceState({}, '', newUrl);

        isLoading = true;
        productsGrid.style.opacity = '0.5';

        try {
            const response = await fetch(`{{ route('products') }}?${params.toString()}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            console.log('Response status:', response.status);

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            console.log('Received products:', data.products?.length);

            productsGrid.innerHTML = data.products.length
                ? data.products.map(product => createProductCard(product)).join('')
                : emptyState();

        } catch (error) {
            console.error('Filter error:', error);
            showNotification('Failed to load products', 'error');
        } finally {
            isLoading = false;
            productsGrid.style.opacity = '1';
        }
    }

    // Product Card
    function createProductCard(product) {
        const image = product.image
            ? `<img src="/storage/${product.image}" alt="${product.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">`
            : `<div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>`;

        const badge =
            product.stock === 0
                ? `<div class="absolute top-3 left-3 px-3 py-1 bg-red-600 text-white text-[11px] font-semibold uppercase tracking-wider rounded-full">Out of Stock</div>`
                : product.stock <= 10
                    ? `<div class="absolute top-3 left-3 px-3 py-1 bg-orange-500 text-white text-[11px] font-semibold uppercase tracking-wider rounded-full">Low Stock</div>`
                    : '';

        const buttons = product.stock > 0
            ? `
                <button onclick="addToCart(${product.id})"
                    id="add-to-cart-${product.id}"
                    class="flex-1 py-2.5 px-4 bg-gray-900 text-white text-[12px] font-semibold uppercase tracking-wider hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    Add to Cart
                </button>
                <button onclick="buyNow(${product.id})"
                    class="flex-1 py-2.5 px-4 border-2 border-gray-900 text-gray-900 text-[12px] font-semibold uppercase tracking-wider hover:bg-gray-900 hover:text-white transition-colors">
                    Buy Now
                </button>
            `
            : `
                <button disabled
                    class="flex-1 py-2.5 px-4 bg-gray-300 text-gray-500 text-[12px] font-semibold uppercase tracking-wider cursor-not-allowed">
                    Out of Stock
                </button>
            `;

        return `
            <div class="bg-white border border-[#e8e5e0] group hover:shadow-xl transition-all duration-300">
                <div class="aspect-[3/4] overflow-hidden bg-gray-100 relative">
                    ${image}
                    ${badge}
                </div>
                <div class="p-5">
                    <span class="text-[11px] px-2 py-1 bg-[#f5f3ef] text-gray-700 rounded-full inline-block mb-3">
                        ${product.category_name || 'General'}
                    </span>
                    <h3 class="text-[15px] font-medium text-gray-900 mb-2 line-clamp-2">
                        ${product.name}
                    </h3>
                    <p class="text-[13px] text-gray-600 mb-4 line-clamp-2">
                        ${product.description || ''}
                    </p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[18px] font-light text-gray-900">
                            ₱${parseFloat(product.retail_price).toFixed(2)}
                        </span>
                        <span class="text-[12px] ${product.stock > 0 ? 'text-green-700' : 'text-red-600'}">
                            ${product.stock > 0 ? product.stock + ' in stock' : 'Out of stock'}
                        </span>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <button onclick="decrementQuantity(${product.id})"
                                class="w-8 h-8 flex items-center justify-center border border-[#e8e5e0] bg-[#f5f3ef] text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 12h-15" />
                                </svg>
                            </button>
                            <input type="number"
                                id="quantity-${product.id}"
                                value="1"
                                min="1"
                                max="${product.stock}"
                                class="w-16 px-3 py-2 text-center border border-[#e8e5e0] bg-[#f5f3ef] text-[14px] text-gray-900 focus:outline-none focus:border-gray-900">
                            <button onclick="incrementQuantity(${product.id}, ${product.stock})"
                                class="w-8 h-8 flex items-center justify-center border border-[#e8e5e0] bg-[#f5f3ef] text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex gap-2">
                            ${buttons}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Empty State
    function emptyState() {
        return `
            <div class="col-span-full text-center py-20">
                <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <h3 class="text-[20px] font-medium text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-600 text-[14px] mb-6">Try adjusting your search or filter criteria.</p>
                <button onclick="clearFiltersBtn.click()" class="inline-block px-6 py-3 bg-gray-900 text-white text-[13px] font-semibold uppercase tracking-wider hover:bg-gray-800 transition-colors">
                    View All Products
                </button>
            </div>
        `;
    }

    // Quantity Controls
    function incrementQuantity(id, stock) {
        const input = document.getElementById(`quantity-${id}`);

        if (parseInt(input.value) < stock) {
            input.value++;
        }
    }

    function decrementQuantity(id) {
        const input = document.getElementById(`quantity-${id}`);

        if (parseInt(input.value) > 1) {
            input.value--;
        }
    }

    // Add To Cart
    async function addToCart(productId) {

        const quantity = document.getElementById(`quantity-${productId}`).value;
        const button = document.getElementById(`add-to-cart-${productId}`);

        button.innerHTML = 'Adding...';
        button.disabled = true;

        try {

            const response = await fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity
                })
            });

            const data = await response.json();

            if (data.success) {

                updateCartCount(data.cart_count);
                showNotification('Added to cart', 'success');

            } else {

                showNotification(data.message || 'Failed to add', 'error');
            }

        } catch (error) {

            showNotification('Something went wrong', 'error');

        } finally {

            button.innerHTML = 'Add Cart';
            button.disabled = false;
        }
    }

    // Buy Now
    async function buyNow(productId) {

        const quantity = document.getElementById(`quantity-${productId}`).value;

        try {

            const response = await fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity
                })
            });

            const data = await response.json();

            if (data.success) {

                window.location.href = '{{ route('checkout.index') }}';

            } else {

                showNotification(data.message || 'Checkout failed', 'error');
            }

        } catch (error) {

            showNotification('Something went wrong', 'error');
        }
    }

    // Cart Count
    function updateCartCount(count) {

        const cartCount = document.getElementById('cart-count');

        if (!cartCount) return;

        cartCount.textContent = count;

        count > 0
            ? cartCount.classList.remove('hidden')
            : cartCount.classList.add('hidden');
    }

    // Notification
    function showNotification(message, type) {

        const notification = document.createElement('div');

        notification.className =
            `fixed top-5 right-5 px-5 py-3 rounded-lg shadow-xl z-50 text-white text-[14px]
            ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;

        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 2500);
    }
</script>
@endpush

