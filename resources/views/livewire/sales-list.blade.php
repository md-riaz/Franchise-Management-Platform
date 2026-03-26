<div class="space-y-5">
    {{-- Page header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">Sales</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Filter revenue by franchise, status, and timeframe</p>
        </div>
        <x-ui.badge color="indigo" variant="outline">{{ $sales->total() }} records</x-ui.badge>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-neutral-200 p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wide">Search</label>
                <div class="relative">
                    <x-heroicon-m-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none" />
                    <input type="text" wire:model.live="search" placeholder="Search sales..."
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
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wide">Status</label>
                <select wire:model.live="status"
                    class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-xs transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">
                    <option value="">All Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wide">Date Range</label>
                <div class="flex gap-2">
                    <input type="date" wire:model.live="dateFrom"
                        class="flex-1 rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-900 shadow-xs transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">
                    <input type="date" wire:model.live="dateTo"
                        class="flex-1 rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-900 shadow-xs transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-neutral-200">
            <h2 class="text-sm font-semibold text-neutral-900">Sales Ledger</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Sale #</th>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Franchise</th>
                        @endif
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Date</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-neutral-500 uppercase tracking-wide">Subtotal</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-neutral-500 uppercase tracking-wide">Tax</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-neutral-500 uppercase tracking-wide">Total</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Payment</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-neutral-50 transition-colors">
                        <td class="px-5 py-3.5 font-medium text-neutral-900">{{ $sale->sale_number }}</td>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <td class="px-5 py-3.5 text-neutral-600">{{ $sale->franchise->name }}</td>
                        @endif
                        <td class="px-5 py-3.5 text-neutral-500 text-xs">{{ $sale->sale_date->format('M d, Y') }}</td>
                        <td class="px-5 py-3.5 text-right text-neutral-600">${{ number_format($sale->subtotal, 2) }}</td>
                        <td class="px-5 py-3.5 text-right text-neutral-500">${{ number_format($sale->tax, 2) }}</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-neutral-900">${{ number_format($sale->total, 2) }}</td>
                        <td class="px-5 py-3.5 text-neutral-500 capitalize">{{ $sale->payment_method }}</td>
                        <td class="px-5 py-3.5">
                            @if($sale->status === 'completed')
                                <x-ui.badge color="emerald">{{ ucfirst($sale->status) }}</x-ui.badge>
                            @elseif($sale->status === 'pending')
                                <x-ui.badge color="amber">{{ ucfirst($sale->status) }}</x-ui.badge>
                            @elseif($sale->status === 'refunded')
                                <x-ui.badge color="blue">{{ ucfirst($sale->status) }}</x-ui.badge>
                            @else
                                <x-ui.badge color="red">{{ ucfirst($sale->status) }}</x-ui.badge>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-10 text-center">
                            <x-heroicon-m-banknotes class="w-8 h-8 text-neutral-300 mx-auto mb-2" />
                            <p class="text-sm text-neutral-400">No sales found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-neutral-200 bg-neutral-50">
            {{ $sales->links() }}
        </div>
    </div>
</div>
