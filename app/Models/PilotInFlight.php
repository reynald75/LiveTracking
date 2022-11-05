<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilotInFlight extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'flight_id',
        'is_flying',
        'sos'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pilots_in_flight';
}
