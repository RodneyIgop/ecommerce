@extends('business.layout')

@section('title', 'Shipping Rules')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[1000px] mx-auto px-6 lg:px-10">
        <h1 class="font-serif-display text-[32px] text-gray-900 mb-8">Shipping Rules</h1>

        <div class="bg-white border border-[#e8e5e0] p-6 mb-8">
            <h2 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mb-4">New Rule</h2>
            <form action="{{ route('business.shipping_rules.store') }}" method="post" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Rule Name" required class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                <select name="type" class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                    <option value="local">Local</option>
                    <option value="national">National</option>
                    <option value="international">International</option>
                </select>
                <input type="number" name="base_rate" placeholder="Base Rate" step="0.01" required class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                <input type="number" name="weight_rate" placeholder="Weight Rate" step="0.01" required class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                <input type="number" name="distance_rate" placeholder="Distance Rate" step="0.01" required class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                <input type="number" name="handling_fee" placeholder="Handling Fee" step="0.01" required class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                <button type="submit" class="sm:col-span-2 bg-[#111] text-white text-[11px] font-semibold tracking-[0.12em] uppercase py-3 hover:bg-gray-800 transition-colors">Create Rule</button>
            </form>
        </div>

        @if($rules->count())
        <div class="bg-white border border-[#e8e5e0]">
            @foreach($rules as $rule)
            <div class="p-6 border-b border-[#e8e5e0] last:border-b-0">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-[14px] font-medium">{{ $rule->name }}</h3>
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-semibold tracking-[0.1em] uppercase px-2 py-1 border {{ $rule->is_active ? 'border-green-600 text-green-700' : 'border-gray-400 text-gray-500' }}">
                            {{ $rule->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <form action="{{ route('business.shipping_rules.toggle', $rule) }}" method="post">
                            @csrf
                            @method('patch')
                            <button type="submit" class="text-[11px] text-gray-600 hover:text-black underline">Toggle</button>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-[12px] text-gray-600">
                    <div>Base: ${{ number_format($rule->base_rate, 2) }}</div>
                    <div>Weight: ${{ number_format($rule->weight_rate, 2) }}</div>
                    <div>Distance: ${{ number_format($rule->distance_rate, 2) }}</div>
                    <div>Handling: ${{ number_format($rule->handling_fee, 2) }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white border border-[#e8e5e0] p-12 text-center">
            <p class="text-[13px] text-gray-600">No shipping rules configured.</p>
        </div>
        @endif
    </div>
</section>
@endsection
