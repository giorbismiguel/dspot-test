<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'img',
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'state',
        'zipcode',
        'available',
        'friend_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'available' => 'boolean',
    ];

    public function friend()
    {
        return $this->belongsToOne(Profile::class, 'friend_id');
    }

    public function friends()
    {
        return $this->hasMany(Profile::class, 'friend_id')->orderBy('id', 'asc');
    }
}
