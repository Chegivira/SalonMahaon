<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; // Добавляем этот трейт
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Authenticatable
{
    use HasFactory, HasApiTokens; // Включаем трейт HasApiTokens

    protected $fillable = [
        'name',
        'surename',
        'patronymic',
        'phone',
        'email',
        'password'
    ];

    protected $hidden = ['password'];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
