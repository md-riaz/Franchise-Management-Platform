<?php

namespace App\Livewire;

use App\Models\Royalty;
use App\Models\Franchise;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RoyaltyList extends Component
{
    use WithPagination;

    public $franchiseId = '';
    public $status = '';
    
    public function render()
    {
        $query = Royalty::with('franchise');
        
        if ($this->franchiseId) {
            $query->where('franchise_id', $this->franchiseId);
        } elseif (!Auth::user()->isFranchisor() && !Auth::user()->isAdmin()) {
            $userFranchise = Auth::user()->franchises()->first();
            if ($userFranchise) {
                $query->where('franchise_id', $userFranchise->id);
            }
        }
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        $royalties = $query->latest('period_start')->paginate(15);
        
        $franchises = Franchise::active()->get();
        
        return view('livewire.royalty-list', [
            'royalties' => $royalties,
            'franchises' => $franchises
        ]);
    }

    public function calculateRoyalties()
    {
        if (!Auth::user()->isFranchisor() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $franchises = Franchise::active()->get();
        $periodStart = now()->startOfMonth();
        $periodEnd = now()->endOfMonth();
        $period = $periodStart->format('Y-m');
        $dueDate = $periodEnd->copy()->addDays(10);

        $calculatedCount = 0;

        foreach ($franchises as $franchise) {
            $grossSales = \App\Models\Sale::where('franchise_id', $franchise->id)
                ->completed()
                ->whereBetween('sale_date', [$periodStart->toDateString(), $periodEnd->toDateString()])
                ->sum('total');

            if ($grossSales <= 0) {
                continue;
            }

            $royalty = Royalty::firstOrNew([
                'franchise_id' => $franchise->id,
                'period' => $period,
            ]);

            if ($royalty->exists && $royalty->status === 'paid') {
                continue;
            }

            $royalty->period_start = $periodStart->toDateString();
            $royalty->period_end = $periodEnd->toDateString();
            $royalty->gross_sales = $grossSales;
            $royalty->royalty_percentage = $franchise->royalty_percentage;
            $royalty->royalty_amount = round($grossSales * ($franchise->royalty_percentage / 100), 2);
            $royalty->status = 'calculated';
            $royalty->due_date = $dueDate->toDateString();
            $royalty->save();

            $calculatedCount++;
        }

        session()->flash('message', $calculatedCount > 0
            ? "Calculated {$calculatedCount} royalty record(s) for {$period}."
            : "No completed sales found for {$period}; royalties unchanged.");
    }
}
