<div class="space-y-5">
    {{-- Page header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">Inventory</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Track availability, reservations, and low-stock signals</p>
        </div>
        <x-ui.badge color="indigo" variant="outline">{{ $inventory->total() }} lines</x-ui.badge>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-neutral-200 p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="sm:col-span-2 space-y-1.5">
                <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wide">Search</label>
                <div class="relative">
                    <x-heroicon-m-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none" />
                    <input type="text" wire:model.live="search" placeholder="Search products..."
                        class="w-full rounded-lg border border-neutral-300 bg-white pl-9 pr-3 py-2.5 text-sm text-neutral-900 placeholder-neutral-400 shadow-xs transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">
                </div>
            </div>
            @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wide">Franchise</label>
                <select wire:model.live="franchiseId"
                    class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-xs transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">
                    <option value="">All Franchises</option>
                    @foreach($franchises as $franchise)
                    <option value="{{ $franchise->id }}">{{ $franchise->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="flex items-end">
                <label class="flex items-center gap-2 cursor-pointer text-sm text-neutral-700">
                    <input type="checkbox" wire:model.live="lowStockOnly"
                        class="h-4 w-4 rounded border-neutral-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Low Stock Only</span>
                </label>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-neutral-200">
            <h2 class="text-sm font-semibold text-neutral-900">Stock Levels</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Product</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">SKU</th>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Franchise</th>
                        @endif
                        <th class="px-5 py-3 text-right text-xs font-semibold text-neutral-500 uppercase tracking-wide">Qty</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-neutral-500 uppercase tracking-wide">Reserved</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-neutral-500 uppercase tracking-wide">Available</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($inventory as $item)
                    <tr class="hover:bg-neutral-50 transition-colors {{ $item->isLowStock() ? 'bg-red-50/40' : '' }}">
                        <td class="px-5 py-3.5 font-medium text-neutral-900">{{ $item->product->name }}</td>
                        <td class="px-5 py-3.5">
                            <span class="font-mono text-xs text-neutral-500">{{ $item->product->sku }}</span>
                        </td>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <td class="px-5 py-3.5 text-neutral-500">{{ $item->franchise->name }}</td>
                        @endif
                        <td class="px-5 py-3.5 text-right font-medium text-neutral-900">{{ $item->quantity }}</td>
                        <td class="px-5 py-3.5 text-right text-neutral-500">{{ $item->reserved_quantity }}</td>
                        <td class="px-5 py-3.5 text-right font-semibold {{ $item->isLowStock() ? 'text-red-600' : 'text-emerald-600' }}">
                            {{ $item->getAvailableQuantity() }}
                        </td>
                        <td class="px-5 py-3.5">
                            @if($item->isLowStock())
                                <x-ui.badge color="red">Low Stock</x-ui.badge>
                            @else
                                <x-ui.badge color="emerald">In Stock</x-ui.badge>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center">
                            <x-heroicon-m-cube class="w-8 h-8 text-neutral-300 mx-auto mb-2" />
                            <p class="text-sm text-neutral-400">No inventory items found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-neutral-200 bg-neutral-50">
            {{ $inventory->links() }}
        </div>
    </div>
</div>
