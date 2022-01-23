<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     * All of the models Mutators&Accessors
     * should begin from here.
     */

    /**
     * All of the models scopes methods
     * should begin from here.
     */

    /**
     * All of the models custom methods
     * should begin from here.
     */

    /**
     * All of the models method overwrites
     * should begin from here.
     */


    /**
     * All of the models relationships
     * should begin from here.
     */

    /**
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
