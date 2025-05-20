<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Service;

class AdminController extends Controller
{
    // Метод для получения информации для dashboard
    public function dashboard()
    {
        // Пример вывода общей статистики, можно добавить больше информации
        $employeesCount = Employee::count();
        $servicesCount = Service::count();

        return response()->json([
            'employees_count' => $employeesCount,
            'services_count' => $servicesCount,
        ]);
    }
}
