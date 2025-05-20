<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    // Получить всех клиентов (для админа)
    public function index()
    {
        return Client::all();
    }

    // Создать нового клиента
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'surename' => 'required|string|max:100',
            'email' => 'required|email|unique:clients',
            'password' => 'required|min:6',
            'phone' => 'required|string|max:20'
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $client = Client::create($validated);

        return response()->json($client, 201);
    }

    // Показать конкретного клиента (для админа)
    public function show(Client $client)
    {
        return $client;
    }

    // Обновление клиента (для админа)
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:100',
            'surename' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:clients,email,' . $client->id,
            'password' => 'sometimes|min:6',
            'phone' => 'sometimes|string|max:20'
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $client->update($validated);
        return $client;
    }

    // Удаление клиента (для админа)
    public function destroy(Client $client)
    {
        $client->delete();
        return response()->noContent();
    }

    // Получить профиль авторизованного клиента
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    // Обновить данные профиля клиента
    public function updateProfile(Request $request)
    {
        $client = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'surename' => 'required|string|max:100',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'required|string|max:20'
        ]);

        $client->update($validated);

        return response()->json(['message' => 'Профиль успешно обновлён']);
    }

    // Обновить пароль клиента
    public function updatePassword(Request $request)
    {
        $client = $request->user();

        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($validated['old_password'], $client->password)) {
            return response()->json(['message' => 'Неверный текущий пароль'], 422);
        }

        $client->update([
            'password' => bcrypt($validated['new_password']),
        ]);

        return response()->json(['message' => 'Пароль успешно изменён']);
    }
}
