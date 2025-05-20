<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration'
    ];

    // Связь с акциями (многие ко многим)
    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'services_promotions')
            ->withPivot('start_date', 'end_date');
    }

    // Связь с записями
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
