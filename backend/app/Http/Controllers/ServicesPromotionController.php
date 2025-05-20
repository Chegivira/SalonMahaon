<?php

namespace App\Http\Controllers;

use App\Models\ServicesPromotion;
use Illuminate\Http\Request;

class ServicesPromotionController extends Controller
{
    // Получить все связи
    public function index()
    {
        return ServicesPromotion::with(['service', 'promotion'])->get();
    }

    // Создать связь
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'promotion_id' => 'required|exists:promotions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $link = ServicesPromotion::create($validated);
        return response()->json($link, 201);
    }

    // Показать связь
    public function show(ServicesPromotion $servicesPromotion)
    {
        return $servicesPromotion->load(['service', 'promotion']);
    }

    // Обновить связь
    public function update(Request $request, ServicesPromotion $servicesPromotion)
    {
        $validated = $request->validate([
            'service_id' => 'sometimes|exists:services,id',
            'promotion_id' => 'sometimes|exists:promotions,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date'
        ]);

        $servicesPromotion->update($validated);
        return $servicesPromotion;
    }

    // Удалить связь
    public function destroy(ServicesPromotion $servicesPromotion)
    {
        $servicesPromotion->delete();
        return response()->noContent();
    }
}
