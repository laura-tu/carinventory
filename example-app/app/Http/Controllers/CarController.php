<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        return Car::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'nullable|required_if:is_registered,true|string|max:255',
            'is_registered' => 'required|boolean',
        ]);

        return Car::create($validated);
    }

    public function show(Car $car)
    {
        return $car;
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'nullable|required_if:is_registered,true|string|max:255',
            'is_registered' => 'required|boolean',
        ]);

        $car->update($validated);

        return $car;
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return response()->noContent();
    }
}
