<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Compliance Tracking</h2>
    </div>

    <div class="bg-white shadow rounded-lg mb-6">
        <div class="p-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row gap-4">
                @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                <div class="flex-1">
                    <select wire:model.live="franchiseId" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Franchises</option>
                        @foreach($franchises as $franchise)
                        <option value="{{ $franchise->id }}">{{ $franchise->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="flex-1">
                    <select wire:model.live="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="overdue">Overdue</option>
                        <option value="non_compliant">Non-Compliant</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model.live="showOverdueOnly" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-500 focus:ring-red-500">
                        <span class="ml-2 text-sm text-gray-700">Overdue Only</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Franchise</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requirement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completion Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($complianceRecords as $record)
                    <tr class="@if($record->status === 'overdue') bg-red-50 @endif">
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->franchise->name }}</td>
                        @endif
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            <div>{{ $record->requirement->name }}</div>
                            <div class="text-xs text-gray-500">{{ $record->requirement->frequency }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="capitalize">{{ $record->requirement->category }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $record->due_date->format('M d, Y') }}
                            @if($record->due_date < now() && $record->status !== 'completed')
                            <span class="text-red-600 font-semibold ml-2">(Overdue)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $record->completion_date ? $record->completion_date->format('M d, Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($record->status === 'completed') bg-green-100 text-green-800
                                @elseif($record->status === 'in_progress') bg-blue-100 text-blue-800
                                @elseif($record->status === 'overdue') bg-red-100 text-red-800
                                @elseif($record->status === 'non_compliant') bg-red-200 text-red-900
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $record->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-blue-600 hover:text-blue-900">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No compliance records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-gray-200">
            {{ $complianceRecords->links() }}
        </div>
    </div>
</div>
