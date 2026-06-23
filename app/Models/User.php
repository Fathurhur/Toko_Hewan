<?php

namespace App\Models;

/**
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $last_seen
 * @method static \Illuminate\Database\Eloquent\Builder where(string $column, mixed $operator = null, mixed $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder latest(string $column = null)
 */
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'whatsapp_number',
        'last_seen',
    ];

    /**
     *
     * @var list<string>
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
        'last_seen' => 'datetime',
    ];


    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    /**
     * Helper to query by role explicitly (static for analyzer friendliness).
     */
    public static function role(string $role)
    {
        return static::where('role', $role);
    }
}
