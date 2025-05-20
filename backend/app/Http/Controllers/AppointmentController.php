<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function index()
    {
        return Appointment::with(['client', 'master', 'service'])->get();
    }

    public function store(Request $request)
    {
        Log::info('Appointment Request (без client_id):', $request->all());

        $clientId = auth()->id();

        $validated = $request->validate([
            'master_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'date_time' => 'required|date',
        ]);

        $validated['client_id'] = $clientId;

        // Получаем длительность услуги
        $service = Service::findOrFail($validated['service_id']);
        $duration = $service->duration;

        $startTime = Carbon::parse($validated['date_time']);
        $endTime = $startTime->copy()->addMinutes($duration);

        // Получаем существующие записи мастера на тот же день
        $appointments = Appointment::where('master_id', $validated['master_id'])
            ->whereDate('date_time', $startTime->toDateString())
            ->with('service')
            ->get();

        foreach ($appointments as $existing) {
            $existingStart = Carbon::parse($existing->date_time);
            $existingEnd = $existingStart->copy()->addMinutes($existing->service->duration);

            // Проверка на пересечение
            if ($startTime < $existingEnd && $endTime > $existingStart) {
                return response()->json([
                    'message' => 'Время пересекается с другой записью'
                ], 409);
            }
        }

        $appointment = Appointment::create($validated);

        return response()->json($appointment, 201);
    }

    public function show(Appointment $appointment)
    {
        return $appointment->load(['client', 'master', 'service']);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'client_id' => 'sometimes|exists:users,id',
            'master_id' => 'sometimes|exists:users,id',
            'service_id' => 'sometimes|exists:services,id',
            'date_time' => 'sometimes|date',
        ]);

        $appointment->update($validated);
        return $appointment;
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->noContent();
    }

    public function occupiedSlots(Request $request)
    {
        $date = $request->input('date');
        $masterId = $request->input('master_id');

        $appointments = Appointment::whereDate('date_time', $date)
            ->where('master_id', $masterId)
            ->with('service')
            ->get();

        $slots = [];

        foreach ($appointments as $appointment) {
            $start = Carbon::parse($appointment->date_time);
            $duration = $appointment->service->duration;
            $end = $start->copy()->addMinutes($duration);

            while ($start < $end) {
                $slots[] = $start->format('H:i');
                $start->addMinutes(30);
            }
        }

        return response()->json($slots);
    }

    public function getMasterSchedule(Request $request)
    {
        $masterId = $request->input('master_id');
        $date = $request->input('date');

        $appointments = Appointment::where('master_id', $masterId)
            ->whereDate('date_time', $date)
            ->with(['client', 'service', 'promotion'])
            ->orderBy('date_time')
            ->get();

        return response()->json($appointments);
    }

    public function markAttendance(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate([
            'is_attended' => 'sometimes|boolean',
            'promotion_id' => 'nullable|exists:promotions,id'
        ]);

        $appointment->update($validated);

        return response()->json($appointment);
    }

    public function masterAppointments()
    {
        $masterId = auth()->id();

        $appointments = Appointment::where('master_id', $masterId)
            ->with(['client', 'service'])
            ->orderBy('date_time')
            ->get();

        return response()->json($appointments);
    }

    public function getByDate(Request $request)
    {
        $date = $request->query('date');
        if (! $date) {
            return response()->json(['message' => 'Не указана дата'], 400);
        }

        // Получаем все записи на эту дату
        $appointments = Appointment::with(['client', 'master', 'service'])
            ->whereDate('date_time', $date)
            ->orderBy('date_time')
            ->get()
            ->map(function($a) {
                // Формируем простой формат для фронта
                return [
                    'id'           => $a->id,
                    'service_name' => $a->service->name,
                    'master_name'  => $a->master->first_name . ' ' . $a->master->last_name,
                    'client_name'  => $a->client ? $a->client->first_name . ' ' . $a->client->last_name : null,
                    'time'         => Carbon::parse($a->date_time)->format('H:i'),
                ];
            });

        return response()->json($appointments);
    }
}
