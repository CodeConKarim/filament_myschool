<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EnumTitles;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

final class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasUlids;
    use Notifiable;
    use SoftDeletes;


    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'email',
        'phone',
        'is_active',
        'is_owner',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'title' => EnumTitles::class,
        'is_active' => "boolean",
        'is_owner' => "boolean",
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
