<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        $query = Courier::query();

        // Fitur Opsi Pencarian (?search=budi+agung)
        if ($request->has('search')) {
            $search = $request->query('search');
            // Menangani pencarian multi-kata (seperti Budi Agung matching Budiono Hadi Agung)
            $keywords = explode(' ', $search);
            foreach ($keywords as $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            }
        }

        // Fitur Filter Level (?level=2,3)
        if ($request->has('level')) {
            $levels = explode(',', $request->query('level'));
            $query->whereIn('level', $levels);
        }

        // Fitur Sorting (?sort=created_at) -> Default ke 'name' jika tidak di-override
        $sortBy = $request->query('sort') === 'created_at' ? 'created_at' : 'name';
        $query->orderBy($sortBy, 'asc');

        // Hasil dengan Pagination (Default 10 data per halaman)
        $couriers = $query->paginate(10);

        return response()->json($couriers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:couriers,phone_number|max:20',
            'vehicle_type' => 'required|string|max:50',
            'level' => 'required|integer|between:1,5',
            'is_active' => 'boolean'
        ]);

        $courier = Courier::create($validated);

        return response()->json([
            'message' => 'Courier created successfully',
            'data' => $courier
        ], Response::HTTP_CREATED);
    }

    public function show(Courier $courier)
    {
        return response()->json($courier);
    }

    public function update(Request $request, Courier $courier)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:20|unique:couriers,phone_number,' . $courier->id,
            'vehicle_type' => 'sometimes|required|string|max:50',
            'level' => 'sometimes|required|integer|between:1,5',
            'is_active' => 'boolean'
        ]);

        $courier->update($validated);

        return response()->json([
            'message' => 'Courier updated successfully',
            'data' => $courier
        ]);
    }

    public function destroy(Courier $courier)
    {
        $courier->delete();

        return response()->json([
            'message' => 'Courier deleted successfully'
        ], Response::HTTP_OK);
    }
}