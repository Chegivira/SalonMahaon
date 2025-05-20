<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // Получить все записи графика
    public function index()
    {
        return Schedule::with(['employee', 'workplace', 'shift'])->get();
    }

    // Создать запись в графике
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'workplace_id' => 'required|exists:workplaces,id',
            'shift_id' => 'required|exists:shifts,id'
        ]);

        $schedule = Schedule::create($validated);
        return response()->json($schedule, 201);
    }

    // Показать запись графика
    public function show(Schedule $schedule)
    {
        return $schedule->load(['employee', 'workplace', 'shift']);
    }

    // Обновить запись графика
    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'employee_id' => 'sometimes|exists:employees,id',
            'day' => 'sometimes|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'sometimes|date_format:H:i',
            'end_time' => 'sometimes|date_format:H:i|after:start_time',
            'workplace_id' => 'sometimes|exists:workplaces,id',
            'shift_id' => 'sometimes|exists:shifts,id'
        ]);

        $schedule->update($validated);
        return $schedule;
    }

    // Удалить запись графика
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return response()->noContent();
    }
}
