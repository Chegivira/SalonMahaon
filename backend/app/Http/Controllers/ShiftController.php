<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    // Получить все смены
    public function index()
    {
        return Shift::all();
    }

    // Создать смену
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|date_format:H:i'
        ]);

        $shift = Shift::create($validated);
        return response()->json($shift, 201);
    }

    // Показать смену
    public function show(Shift $shift)
    {
        return $shift;
    }

    // Обновить смену
    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'time' => 'sometimes|date_format:H:i'
        ]);

        $shift->update($validated);
        return $shift;
    }

    // Удалить смену
    public function destroy(Shift $shift)
    {
        $shift->delete();
        return response()->noContent();
    }
}
