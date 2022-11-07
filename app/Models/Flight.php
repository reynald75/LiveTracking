<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'dist_FAI',
        'dist_SD',
        'dist_actual',
    ];

    /**
     * Get the user associated with the flight.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the points associated with the flight.
     */
    public function points()
    {
        return $this->hasMany(GpsPoint::class);
    }

    /**
     * Get the last point associated with the flight.
     */
    public function lastPoint()
    {
        return $this->points()->orderByDesc('time')->first();
    }
}
