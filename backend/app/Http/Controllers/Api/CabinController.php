<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cabin;
use Illuminate\Http\Request;

class CabinController extends Controller
{
    public function index()
    {
        return Cabin::orderBy('name')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|in:available,unavailable',
        ]);

        return response()->json(Cabin::create($data), 201);
    }

    public function show(Cabin $cabin)
    {
        return $cabin;
    }

    public function update(Request $request, Cabin $cabin)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|in:available,unavailable',
        ]);

        $cabin->update($data);

        return $cabin;
    }

    public function destroy(Cabin $cabin)
    {
        $cabin->delete();

        return response()->json([
            'message' => 'Cabin deleted successfully',
        ]);
    }

}

