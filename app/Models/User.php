<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role_id',
        'is_active',
    ];
    protected $table = 'users';
    protected $dates = ['deleted_at'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id', 'id'); // Quan hệ với mô hình Roles
    }
    public function order()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    public function isRoleAdmin()
    {
        return $this->role && $this->role->role_name === self::ROLE_ADMIN;
    }

    public function isRoleUser()
    {
        return $this->role && $this->role->role_name === self::ROLE_USER;
    }
}
