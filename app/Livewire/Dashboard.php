<?php

namespace App\Livewire;

use App\Models\Franchise;
use App\Models\Sale;
use App\Models\Royalty;
use App\Models\ComplianceRecord;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalSales;
    public $monthlySales;
    public $pendingRoyalties;
    public $overdueCompliance;
    public $activeFranchises;
    public $recentSales;

    public function mount()
    {
        $user = Auth::user();
        
        if ($user->isFranchisor()) {
            $this->loadFranchisorDashboard();
        } else {
            $this->loadFranchiseeDashboard();
        }
    }

    protected function loadFranchisorDashboard()
    {
        $this->activeFranchises = Franchise::active()->count();
        
        // Total sales across all franchises
        $this->totalSales = Sale::completed()
            ->sum('total');
            
        // Monthly sales
        $this->monthlySales = Sale::completed()
            ->whereMonth('sale_date', now()->month)
            ->whereYear('sale_date', now()->year)
            ->sum('total');
            
        // Pending royalties
        $this->pendingRoyalties = Royalty::pending()->sum('royalty_amount');
        
        // Overdue compliance
        $this->overdueCompliance = ComplianceRecord::overdue()->count();
        
        // Recent sales
        $this->recentSales = Sale::with(['franchise', 'user'])
            ->completed()
            ->latest()
            ->limit(10)
            ->get();
    }

    protected function loadFranchiseeDashboard()
    {
        $franchise = Auth::user()->franchises()->first();
        
        if (!$franchise) {
            return;
        }
        
        // Total sales for this franchise
        $this->totalSales = Sale::where('franchise_id', $franchise->id)
            ->completed()
            ->sum('total');
            
        // Monthly sales
        $this->monthlySales = Sale::where('franchise_id', $franchise->id)
            ->completed()
            ->whereMonth('sale_date', now()->month)
            ->whereYear('sale_date', now()->year)
            ->sum('total');
            
        // Pending royalties
        $this->pendingRoyalties = Royalty::where('franchise_id', $franchise->id)
            ->pending()
            ->sum('royalty_amount');
        
        // Overdue compliance
        $this->overdueCompliance = ComplianceRecord::where('franchise_id', $franchise->id)
            ->overdue()
            ->count();
        
        // Recent sales
        $this->recentSales = Sale::where('franchise_id', $franchise->id)
            ->with(['user'])
            ->completed()
            ->latest()
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
