<div class="space-y-5">
    {{-- Page header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">Compliance</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Stay ahead of audits, renewals, and safety checks</p>
        </div>
        <x-ui.badge color="indigo" variant="outline">{{ $complianceRecords->total() }} items</x-ui.badge>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-neutral-200 p-5">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
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
                    <x-ui.select.option value="in_progress">In Progress</x-ui.select.option>
                    <x-ui.select.option value="completed">Completed</x-ui.select.option>
                    <x-ui.select.option value="overdue">Overdue</x-ui.select.option>
                    <x-ui.select.option value="non_compliant">Non-Compliant</x-ui.select.option>
                </x-ui.select>
            </div>
            <div class="space-y-1.5">
                <x-ui.label>Focus</x-ui.label>
                <x-ui.select wire:model.live="complianceFocus" placeholder="All Compliance">
                    <x-ui.select.option value="">All Compliance</x-ui.select.option>
                    <x-ui.select.option value="overdue">Overdue Only</x-ui.select.option>
                    <x-ui.select.option value="due_soon">Due in 7 Days</x-ui.select.option>
                    <x-ui.select.option value="non_compliant">Non-Compliant Only</x-ui.select.option>
                </x-ui.select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-neutral-200">
            <h2 class="text-sm font-semibold text-neutral-900">Compliance Obligations</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Franchise</th>
                        @endif
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Requirement</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Category</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Due Date</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Completed</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($complianceRecords as $record)
                    <tr class="hover:bg-neutral-50 transition-colors {{ $record->status === 'overdue' ? 'bg-red-50/40' : '' }}">
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <td class="px-5 py-3.5 text-neutral-700">{{ $record->franchise->name }}</td>
                        @endif
                        <td class="px-5 py-3.5">
                            <p class="font-medium text-neutral-900">{{ $record->requirement->name }}</p>
                            <p class="text-xs text-neutral-400 mt-0.5">{{ $record->requirement->frequency }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-neutral-500 capitalize text-xs">{{ $record->requirement->category }}</td>
                        <td class="px-5 py-3.5 text-xs">
                            <span class="{{ ($record->due_date < now() && $record->status !== 'completed') ? 'text-red-600 font-semibold' : 'text-neutral-500' }}">
                                {{ $record->due_date->format('M d, Y') }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-neutral-500 text-xs">
                            {{ $record->completion_date ? $record->completion_date->format('M d, Y') : '—' }}
                        </td>
                        <td class="px-5 py-3.5">
                            @if($record->status === 'completed')
                                <x-ui.badge color="emerald">{{ ucfirst($record->status) }}</x-ui.badge>
                            @elseif($record->status === 'in_progress')
                                <x-ui.badge color="blue">In Progress</x-ui.badge>
                            @elseif($record->status === 'overdue')
                                <x-ui.badge color="red">{{ ucfirst($record->status) }}</x-ui.badge>
                            @elseif($record->status === 'non_compliant')
                                <x-ui.badge color="orange">Non-Compliant</x-ui.badge>
                            @else
                                <x-ui.badge color="amber">{{ ucfirst($record->status) }}</x-ui.badge>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 transition-colors">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center">
                            <x-heroicon-m-clipboard-document-check class="w-8 h-8 text-neutral-300 mx-auto mb-2" />
                            <p class="text-sm text-neutral-400">No compliance records found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-neutral-200 bg-neutral-50">
            {{ $complianceRecords->links() }}
        </div>
    </div>
</div>
