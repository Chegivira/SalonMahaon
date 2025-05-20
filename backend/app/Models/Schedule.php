<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'day',
        'start_time',
        'end_time',
        'workplace_id',
        'shift_id'
    ];

    // Связь с сотрудником
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // Связь с рабочим местом
    public function workplace(): BelongsTo
    {
        return $this->belongsTo(Workplace::class);
    }

    // Связь со сменой
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }
}
