<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    // Получить все акции
    public function index()
    {
        return Promotion::all();
    }

    // Создать акцию
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_price' => 'required|integer|min:0'
        ]);

        $promotion = Promotion::create($validated);
        return response()->json($promotion, 201);
    }

    // Показать акцию
    public function show(Promotion $promotion)
    {
        return $promotion;
    }

    // Обновить акцию
    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'discount_price' => 'sometimes|integer|min:0'
        ]);

        $promotion->update($validated);
        return $promotion;
    }

    // Удалить акцию
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return response()->noContent();
    }
}
