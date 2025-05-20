<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesPromotion extends Model
{
    use HasFactory;

    protected $table = 'services_promotions';

    protected $fillable = [
        'service_id',
        'promotion_id',
        'start_date',
        'end_date'
    ];
}
