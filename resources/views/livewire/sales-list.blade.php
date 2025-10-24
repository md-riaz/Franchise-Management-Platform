<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Sales Tracking</h2>
    </div>

    <div class="bg-white shadow rounded-lg mb-6">
        <div class="p-4 border-b border-gray-200">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <input type="text" wire:model.live="search" placeholder="Search sales..." 
                       class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                
                @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                <select wire:model.live="franchiseId" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Franchises</option>
                    @foreach($franchises as $franchise)
                    <option value="{{ $franchise->id }}">{{ $franchise->name }}</option>
                    @endforeach
                </select>
                @endif
                
                <select wire:model.live="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="refunded">Refunded</option>
                </select>
                
                <div class="flex gap-2">
                    <input type="date" wire:model.live="dateFrom" placeholder="From" 
                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <input type="date" wire:model.live="dateTo" placeholder="To" 
                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale #</th>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Franchise</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tax</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sales as $sale)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $sale->sale_number }}</td>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->franchise->name }}</td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->sale_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($sale->subtotal, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($sale->tax, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">${{ number_format($sale->total, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($sale->payment_method) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($sale->status === 'completed') bg-green-100 text-green-800
                                @elseif($sale->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($sale->status === 'refunded') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">No sales found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-gray-200">
            {{ $sales->links() }}
        </div>
    </div>
</div>
