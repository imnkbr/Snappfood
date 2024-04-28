<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Casts\RoleCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *
     */

    protected $table= 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone_number',
        'last_activity_at'
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
        'password' => 'hashed',
        'role_id' => RoleCast::class
    ];

    //eloquent
    public function restaurant()
    {
       return $this->hasOne(Restaurant::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function recordActivity()
    {
        $this->last_activity_at = now();
        $this->save();
    }

}
