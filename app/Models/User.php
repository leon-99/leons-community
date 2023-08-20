<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // Model relationships
    public function article()
    {
        return $this->hasMany('App\Models\Article');
    }


    // Local Scopes

    // search scope
    public function scopeSearch(Builder $query, $phrase): void
    {
        $query->where('name', 'like', '%'.$phrase.'%');
    }

    /**
     * Set the user's name.
     *
     * @param  string  $value
     * @return void
     */

     // Accessor in laravel 8
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }
}
