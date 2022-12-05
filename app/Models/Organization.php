<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'ref_uuid',
    ];


    /**
     * Get the users associated with the organization.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
