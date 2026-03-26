<div class="space-y-4">
    <div class="glass-card p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="muted-label">Operations</p>
                <h2 class="text-2xl font-bold text-slate-900">Inventory Management</h2>
                <p class="text-sm text-slate-600 mt-1">Track availability, reservations, and low-stock signals</p>
            </div>
            <div class="pill bg-slate-100 text-slate-700 border border-slate-200">
                {{ $inventory->total() }} lines
            </div>
        </div>

        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="sm:col-span-2">
                <label class="muted-label block mb-2">Search</label>
                <input type="text" wire:model.live="search" placeholder="Search products..."
                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
            </div>
            @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
            <div>
                <label class="muted-label block mb-2">Franchise</label>
                <select wire:model.live="franchiseId" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    <option value="">All Franchises</option>
                    @foreach($franchises as $franchise)
                    <option value="{{ $franchise->id }}">{{ $franchise->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="flex items-end">
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" wire:model.live="lowStockOnly" class="rounded border-slate-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    Low Stock Only
                </label>
            </div>
        </div>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/70 flex items-center justify-between">
            <div>
                <p class="muted-label">Stock table</p>
                <p class="text-slate-800 font-semibold">Real-time quantities</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-700">
                <thead class="text-xs uppercase text-slate-500 bg-slate-50">
                    <tr>
                        <th class="px-6 py-3">Product</th>
                        <th class="px-6 py-3">SKU</th>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <th class="px-6 py-3">Franchise</th>
                        @endif
                        <th class="px-6 py-3">Quantity</th>
                        <th class="px-6 py-3">Reserved</th>
                        <th class="px-6 py-3">Available</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($inventory as $item)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $item->product->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $item->product->sku }}</td>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <td class="px-6 py-4 text-slate-600">{{ $item->franchise->name }}</td>
                        @endif
                        <td class="px-6 py-4 text-slate-900">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $item->reserved_quantity }}</td>
                        <td class="px-6 py-4 text-slate-900">{{ $item->getAvailableQuantity() }}</td>
                        <td class="px-6 py-4">
                            @if($item->isLowStock())
                            <span class="pill bg-rose-50 text-rose-700 border border-rose-100">
                                Low Stock
                            </span>
                            @else
                            <span class="pill bg-emerald-50 text-emerald-700 border border-emerald-100">
                                In Stock
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-slate-500">No inventory items found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200/70 bg-slate-50/60">
            {{ $inventory->links() }}
        </div>
    </div>
</div>
