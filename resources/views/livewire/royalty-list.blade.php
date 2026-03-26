<div class="space-y-4">
    <div class="glass-card p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="muted-label">Finance</p>
                <h2 class="text-2xl font-bold text-slate-900">Royalty Management</h2>
                <p class="text-sm text-slate-600 mt-1">Track royalty accruals, invoicing, and payments</p>
            </div>
            @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
            <button wire:click="calculateRoyalties" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Calculate Royalties
            </button>
            @endif
        </div>

        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                    <option value="pending">Pending</option>
                    <option value="calculated">Calculated</option>
                    <option value="invoiced">Invoiced</option>
                    <option value="paid">Paid</option>
                    <option value="overdue">Overdue</option>
                </select>
            </div>
        </div>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/70 flex items-center justify-between">
            <div>
                <p class="muted-label">Remittances</p>
                <p class="text-slate-800 font-semibold">Royalty ledger</p>
            </div>
            <div class="pill bg-slate-100 text-slate-700 border border-slate-200">{{ $royalties->total() }} entries</div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-700">
                <thead class="text-xs uppercase text-slate-500 bg-slate-50">
                    <tr>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <th class="px-6 py-3">Franchise</th>
                        @endif
                        <th class="px-6 py-3">Period</th>
                        <th class="px-6 py-3">Gross Sales</th>
                        <th class="px-6 py-3">Rate</th>
                        <th class="px-6 py-3">Royalty Amount</th>
                        <th class="px-6 py-3">Due Date</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($royalties as $royalty)
                    <tr class="hover:bg-slate-50/70">
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $royalty->franchise->name }}</td>
                        @endif
                        <td class="px-6 py-4 text-slate-800">
                            <div class="font-medium">{{ $royalty->period }}</div>
                            <div class="text-xs text-slate-500">
                                {{ $royalty->period_start->format('M d') }} - {{ $royalty->period_end->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-900">
                            ${{ number_format($royalty->gross_sales, 2) }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ number_format($royalty->royalty_percentage, 2) }}%
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-900">
                            ${{ number_format($royalty->royalty_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $royalty->due_date ? $royalty->due_date->format('M d, Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="pill 
                                @if($royalty->status === 'paid') bg-emerald-50 text-emerald-700 border border-emerald-100
                                @elseif($royalty->status === 'overdue') bg-rose-50 text-rose-700 border border-rose-100
                                @elseif($royalty->status === 'invoiced') bg-blue-50 text-blue-700 border border-blue-100
                                @else bg-amber-50 text-amber-700 border border-amber-100
                                @endif">
                                {{ ucfirst($royalty->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-slate-500">No royalty records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200/70 bg-slate-50/60">
            {{ $royalties->links() }}
        </div>
    </div>

    @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="glass-card p-5 flex gap-4 items-start">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 text-white flex items-center justify-center shadow-md">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="muted-label">Total Collected</p>
                <p class="text-2xl font-semibold text-slate-900">
                    ${{ number_format($royalties->where('status', 'paid')->sum('royalty_amount'), 2) }}
                </p>
                <p class="text-xs text-slate-500 mt-1">All paid remittances</p>
            </div>
        </div>

        <div class="glass-card p-5 flex gap-4 items-start">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center shadow-md">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="muted-label">Pending</p>
                <p class="text-2xl font-semibold text-slate-900">
                    ${{ number_format($royalties->whereIn('status', ['pending', 'calculated', 'invoiced'])->sum('royalty_amount'), 2) }}
                </p>
                <p class="text-xs text-slate-500 mt-1">Awaiting invoicing or payment</p>
            </div>
        </div>

        <div class="glass-card p-5 flex gap-4 items-start">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-rose-500 to-red-500 text-white flex items-center justify-center shadow-md">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="muted-label">Overdue</p>
                <p class="text-2xl font-semibold text-rose-600">
                    ${{ number_format($royalties->where('status', 'overdue')->sum('royalty_amount'), 2) }}
                </p>
                <p class="text-xs text-slate-500 mt-1">Requires immediate follow-up</p>
            </div>
        </div>
    </div>
    @endif
</div>
