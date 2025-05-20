<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Получить все роли
    public function index()
    {
        return Role::all();
    }

    // Создать роль
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles'
        ]);

        $role = Role::create($validated);
        return response()->json($role, 201);
    }

    // Показать роль
    public function show(Role $role)
    {
        return $role;
    }

    // Обновить роль
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:roles,name,' . $role->id
        ]);

        $role->update($validated);
        return $role;
    }

    // Удалить роль
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->noContent();
    }
}
