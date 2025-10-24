<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['franchise', 'user', 'items']);
        
        if ($request->has('franchise_id')) {
            $query->where('franchise_id', $request->franchise_id);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('date_from')) {
            $query->where('sale_date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->where('sale_date', '<=', $request->date_to);
        }
        
        $sales = $query->latest('sale_date')->paginate($request->get('per_page', 15));
        
        return response()->json($sales);
    }

    public function show($id)
    {
        $sale = Sale::with(['franchise', 'user', 'items.product'])->findOrFail($id);
        
        return response()->json($sale);
    }

    public function stats(Request $request)
    {
        $franchiseId = $request->get('franchise_id');
        
        $query = Sale::query();
        
        if ($franchiseId) {
            $query->where('franchise_id', $franchiseId);
        }
        
        $stats = [
            'total_sales' => $query->completed()->sum('total'),
            'total_transactions' => $query->completed()->count(),
            'average_sale' => $query->completed()->avg('total'),
            'monthly_sales' => $query->completed()
                ->whereMonth('sale_date', now()->month)
                ->sum('total'),
        ];
        
        return response()->json($stats);
    }
}
