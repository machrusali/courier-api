<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courier\StoreCourierRequest;
use App\Http\Requests\Courier\UpdateCourierRequest;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        $query = Courier::query();

        if ($request->has('search')) {
            $search = $request->query('search');
            $keywords = explode(' ', $search);
            foreach ($keywords as $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            }
        }

        if ($request->has('level')) {
            $levels = explode(',', $request->query('level'));
            $query->whereIn('level', $levels);
        }

        $sortBy = $request->query('sort') === 'created_at' ? 'created_at' : 'name';
        $query->orderBy($sortBy, 'asc');

        $couriers = $query->paginate(10);

        return response()->json($couriers);
    }

    public function store(StoreCourierRequest $request)
    {
        $validated = $request->validated();

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

    public function update(UpdateCourierRequest $request, Courier $courier)
    {
        $validated = $request->validated();

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