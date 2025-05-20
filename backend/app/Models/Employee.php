<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ← обязательно для логина!
use Laravel\Sanctum\HasApiTokens;  // ← Добавь это для создания токенов
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Authenticatable
{
    use HasFactory, HasApiTokens;  // ← Добавь HasApiTokens сюда

    protected $table = 'employee'; // ← явно указываем имя таблицы

    protected $fillable = [
        'role_id',
        'name',
        'surename',
        'patronymic',
        'email',
        'password'
    ];

    protected $hidden = ['password'];

    // Связь с ролью
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Связь с записями
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'master_id');
    }

    // Связь с графиком работы
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}

