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
        'lat',
        'lon',
        'alt',
        'dist_LP',
        'avg_speed',
        'msg_type',
        'msg_content',
        'msg_show',
        'time',
    ];

    public $timestamps = false;
}
