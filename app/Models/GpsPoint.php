<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpsPoint extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'flight_id',
        'messenger_id',
        'lat',
        'lon',
        'alt',
        'msg',
        'time',
    ];

    public $timestamps = false;
}
