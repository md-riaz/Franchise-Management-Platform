<div class="space-y-4">
    <div class="glass-card p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="muted-label">Revenue</p>
                <h2 class="text-2xl font-bold text-slate-900">Sales Tracking</h2>
                <p class="text-sm text-slate-600 mt-1">Filter revenue by franchise, status, and timeframe</p>
            </div>
            <div class="pill bg-slate-100 text-slate-700 border border-slate-200">
                {{ $sales->total() }} records
            </div>
        </div>

        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="muted-label block mb-2">Search</label>
                <input type="text" wire:model.live="search" placeholder="Search sales..."
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

            <div>
                <label class="muted-label block mb-2">Status</label>
                <select wire:model.live="status" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    <option value="">All Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>

            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="muted-label block mb-2">From</label>
                    <input type="date" wire:model.live="dateFrom"
                           class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="flex-1">
                    <label class="muted-label block mb-2">To</label>
                    <input type="date" wire:model.live="dateTo"
                           class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/70 flex items-center justify-between">
            <div>
                <p class="muted-label">Ledger</p>
                <p class="text-slate-800 font-semibold">Sales performance</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-700">
                <thead class="text-xs uppercase text-slate-500 bg-slate-50">
                    <tr>
                        <th class="px-6 py-3">Sale #</th>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <th class="px-6 py-3">Franchise</th>
                        @endif
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Subtotal</th>
                        <th class="px-6 py-3">Tax</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Payment</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $sale->sale_number }}</td>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <td class="px-6 py-4 text-slate-600">{{ $sale->franchise->name }}</td>
                        @endif
                        <td class="px-6 py-4 text-slate-600">{{ $sale->sale_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-slate-900">${{ number_format($sale->subtotal, 2) }}</td>
                        <td class="px-6 py-4 text-slate-600">${{ number_format($sale->tax, 2) }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-900">${{ number_format($sale->total, 2) }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ ucfirst($sale->payment_method) }}</td>
                        <td class="px-6 py-4">
                            <span class="pill 
                                @if($sale->status === 'completed') bg-emerald-50 text-emerald-700 border border-emerald-100
                                @elseif($sale->status === 'pending') bg-amber-50 text-amber-700 border border-amber-100
                                @elseif($sale->status === 'refunded') bg-blue-50 text-blue-700 border border-blue-100
                                @else bg-rose-50 text-rose-700 border border-rose-100
                                @endif">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-slate-500">No sales found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200/70 bg-slate-50/60">
            {{ $sales->links() }}
        </div>
    </div>
</div>
