<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">Royalties</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Track royalty accruals, invoicing, and payments</p>
        </div>
        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
        <button wire:click="calculateRoyalties" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 px-4 py-2 text-sm font-semibold text-white shadow-xs transition-colors">
            <x-heroicon-m-calculator class="w-4 h-4" />
            Calculate Royalties
        </button>
        @endif
    </div>

    <div class="bg-white rounded-xl border border-neutral-200 p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
            <div class="space-y-1.5">
                <x-ui.label>Franchise</x-ui.label>
                <x-ui.select wire:model.live="franchiseId" placeholder="All Franchises">
                    <x-ui.select.option value="">All Franchises</x-ui.select.option>
                    @foreach($franchises as $franchise)
                    <x-ui.select.option value="{{ $franchise->id }}">{{ $franchise->name }}</x-ui.select.option>
                    @endforeach
                </x-ui.select>
            </div>
            @endif
            <div class="space-y-1.5">
                <x-ui.label>Status</x-ui.label>
                <x-ui.select wire:model.live="status" placeholder="All Status">
                    <x-ui.select.option value="">All Status</x-ui.select.option>
                    <x-ui.select.option value="pending">Pending</x-ui.select.option>
                    <x-ui.select.option value="calculated">Calculated</x-ui.select.option>
                    <x-ui.select.option value="invoiced">Invoiced</x-ui.select.option>
                    <x-ui.select.option value="paid">Paid</x-ui.select.option>
                    <x-ui.select.option value="overdue">Overdue</x-ui.select.option>
                </x-ui.select>
            </div>
        </div>
    </div>

    @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-neutral-200 p-5 flex gap-4">
            <div class="flex items-center justify-center w-11 h-11 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                <x-heroicon-m-check-circle class="w-5 h-5" />
            </div>
            <div>
                <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wide">Total Collected</p>
                <p class="text-2xl font-bold text-neutral-900 mt-0.5">${{ number_format($royalties->where('status', 'paid')->sum('royalty_amount'), 0) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-neutral-200 p-5 flex gap-4">
            <div class="flex items-center justify-center w-11 h-11 rounded-lg bg-amber-50 text-amber-600 shrink-0">
                <x-heroicon-m-clock class="w-5 h-5" />
            </div>
            <div>
                <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wide">Pending</p>
                <p class="text-2xl font-bold text-neutral-900 mt-0.5">${{ number_format($royalties->whereIn('status', ['pending','calculated','invoiced'])->sum('royalty_amount'), 0) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-neutral-200 p-5 flex gap-4">
            <div class="flex items-center justify-center w-11 h-11 rounded-lg bg-red-50 text-red-600 shrink-0">
                <x-heroicon-m-exclamation-triangle class="w-5 h-5" />
            </div>
            <div>
                <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wide">Overdue</p>
                <p class="text-2xl font-bold text-red-600 mt-0.5">${{ number_format($royalties->where('status', 'overdue')->sum('royalty_amount'), 0) }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-200">
            <h2 class="text-sm font-semibold text-neutral-900">Royalty Ledger</h2>
            <x-ui.badge color="indigo" variant="outline">{{ $royalties->total() }} entries</x-ui.badge>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Franchise</th>
                        @endif
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Period</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-neutral-500 uppercase tracking-wide">Gross Sales</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-neutral-500 uppercase tracking-wide">Rate</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-neutral-500 uppercase tracking-wide">Amount</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Due Date</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($royalties as $royalty)
                    <tr class="hover:bg-neutral-50 transition-colors">
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <td class="px-5 py-3.5 font-medium text-neutral-900">{{ $royalty->franchise->name }}</td>
                        @endif
                        <td class="px-5 py-3.5">
                            <p class="font-medium text-neutral-900">{{ $royalty->period }}</p>
                            <p class="text-xs text-neutral-400">{{ $royalty->period_start->format('M d') }} – {{ $royalty->period_end->format('M d, Y') }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-right text-neutral-700">${{ number_format($royalty->gross_sales, 2) }}</td>
                        <td class="px-5 py-3.5 text-right text-neutral-500">{{ number_format($royalty->royalty_percentage, 2) }}%</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-neutral-900">${{ number_format($royalty->royalty_amount, 2) }}</td>
                        <td class="px-5 py-3.5 text-neutral-500 text-xs">{{ $royalty->due_date ? $royalty->due_date->format('M d, Y') : '—' }}</td>
                        <td class="px-5 py-3.5">
                            @if($royalty->status === 'paid')
                                <x-ui.badge color="emerald">Paid</x-ui.badge>
                            @elseif($royalty->status === 'overdue')
                                <x-ui.badge color="red">Overdue</x-ui.badge>
                            @elseif($royalty->status === 'invoiced')
                                <x-ui.badge color="blue">Invoiced</x-ui.badge>
                            @else
                                <x-ui.badge color="amber">{{ ucfirst($royalty->status) }}</x-ui.badge>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center">
                            <x-heroicon-m-currency-dollar class="w-8 h-8 text-neutral-300 mx-auto mb-2" />
                            <p class="text-sm text-neutral-400">No royalty records found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-neutral-200 bg-neutral-50">
            {{ $royalties->links() }}
        </div>
    </div>
</div>
