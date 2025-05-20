<?php

namespace App\Http\Controllers;

use App\Models\Workplace;
use Illuminate\Http\Request;

class WorkplaceController extends Controller
{
    // Получить все рабочие места
    public function index()
    {
        return Workplace::all();
    }

    // Создать рабочее место
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $workplace = Workplace::create($validated);
        return response()->json($workplace, 201);
    }

    // Показать рабочее место
    public function show(Workplace $workplace)
    {
        return $workplace;
    }

    // Обновить рабочее место
    public function update(Request $request, Workplace $workplace)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:100'
        ]);

        $workplace->update($validated);
        return $workplace;
    }

    // Удалить рабочее место
    public function destroy(Workplace $workplace)
    {
        $workplace->delete();
        return response()->noContent();
    }
}
