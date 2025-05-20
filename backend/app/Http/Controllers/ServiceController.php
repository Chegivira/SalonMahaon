<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Получить все услуги
    public function index()
    {
        return Service::all();
    }

    // Создать услугу
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1'
        ]);

        $service = Service::create($validated);
        return response()->json($service, 201);
    }

    // Показать услугу
    public function show(Service $service)
    {
        return $service;
    }

    // Обновить услугу
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:100',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'duration' => 'sometimes|integer|min:1'
        ]);

        $service->update($validated);
        return $service;
    }

    // Удалить услугу
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->noContent();
    }
}
