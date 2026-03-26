<div class="space-y-4">
    <div class="glass-card p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="muted-label">Risk</p>
                <h2 class="text-2xl font-bold text-slate-900">Compliance Tracking</h2>
                <p class="text-sm text-slate-600 mt-1">Stay ahead of audits, renewals, and safety checks</p>
            </div>
            <div class="pill bg-slate-100 text-slate-700 border border-slate-200">
                {{ $complianceRecords->total() }} items
            </div>
        </div>

        <div class="mt-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
            @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
            <div class="sm:col-span-1">
                <label class="muted-label block mb-2">Franchise</label>
                <select wire:model.live="franchiseId" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    <option value="">All Franchises</option>
                    @foreach($franchises as $franchise)
                    <option value="{{ $franchise->id }}">{{ $franchise->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="sm:col-span-1">
                <label class="muted-label block mb-2">Status</label>
                <select wire:model.live="status" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="overdue">Overdue</option>
                    <option value="non_compliant">Non-Compliant</option>
                </select>
            </div>
            <div class="flex items-end">
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" wire:model.live="showOverdueOnly" class="rounded border-slate-300 text-red-600 shadow-sm focus:border-red-500 focus:ring-red-500">
                    Overdue Only
                </label>
            </div>
        </div>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/70 flex items-center justify-between">
            <div>
                <p class="muted-label">Tasks</p>
                <p class="text-slate-800 font-semibold">Compliance obligations</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-700">
                <thead class="text-xs uppercase text-slate-500 bg-slate-50">
                    <tr>
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <th class="px-6 py-3">Franchise</th>
                        @endif
                        <th class="px-6 py-3">Requirement</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Due Date</th>
                        <th class="px-6 py-3">Completion Date</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($complianceRecords as $record)
                    <tr class="hover:bg-slate-50/70 @if($record->status === 'overdue') bg-rose-50/70 @endif">
                        @if(auth()->user()->isFranchisor() || auth()->user()->isAdmin())
                        <td class="px-6 py-4 text-slate-800">{{ $record->franchise->name }}</td>
                        @endif
                        <td class="px-6 py-4 font-semibold text-slate-900">
                            <div>{{ $record->requirement->name }}</div>
                            <div class="text-xs text-slate-500">{{ $record->requirement->frequency }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 capitalize">
                            {{ $record->requirement->category }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $record->due_date->format('M d, Y') }}
                            @if($record->due_date < now() && $record->status !== 'completed')
                            <span class="text-rose-600 font-semibold ml-2">(Overdue)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $record->completion_date ? $record->completion_date->format('M d, Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="pill 
                                @if($record->status === 'completed') bg-emerald-50 text-emerald-700 border border-emerald-100
                                @elseif($record->status === 'in_progress') bg-blue-50 text-blue-700 border border-blue-100
                                @elseif($record->status === 'overdue') bg-rose-50 text-rose-700 border border-rose-100
                                @elseif($record->status === 'non_compliant') bg-amber-50 text-amber-800 border border-amber-100
                                @else bg-slate-100 text-slate-700 border border-slate-200
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $record->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-blue-600">
                            <a href="#" class="hover:text-blue-700">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-slate-500">No compliance records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200/70 bg-slate-50/60">
            {{ $complianceRecords->links() }}
        </div>
    </div>
</div>
