<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        return Part::with('car')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'serialnumber' => 'required|string|max:255',
            'car_id' => 'required|exists:cars,id',
        ]);

        return Part::create($validated);
    }

    public function show(Part $part)
    {
        return $part;
    }

    public function update(Request $request, Part $part)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'serialnumber' => 'required|string|max:255',
            'car_id' => 'required|exists:cars,id',
        ]);

        $part->update($validated);

        return $part;
    }

    public function destroy(Part $part)
    {
        $part->delete();
        return response()->noContent();
    }
}
