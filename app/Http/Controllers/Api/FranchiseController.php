<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Franchise;
use Illuminate\Http\Request;

class FranchiseController extends Controller
{
    public function index(Request $request)
    {
        $query = Franchise::with('franchisor');
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }
        
        $franchises = $query->paginate($request->get('per_page', 15));
        
        return response()->json($franchises);
    }

    public function show($id)
    {
        $franchise = Franchise::with(['franchisor', 'users', 'inventory', 'sales'])->findOrFail($id);
        
        return response()->json($franchise);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:franchises',
            'location' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'royalty_percentage' => 'required|numeric|min:0|max:100',
        ]);
        
        $validated['franchisor_id'] = auth()->id();
        
        $franchise = Franchise::create($validated);
        
        return response()->json($franchise, 201);
    }

    public function update(Request $request, $id)
    {
        $franchise = Franchise::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:active,pending,suspended,closed',
            'royalty_percentage' => 'sometimes|required|numeric|min:0|max:100',
        ]);
        
        $franchise->update($validated);
        
        return response()->json($franchise);
    }
}
