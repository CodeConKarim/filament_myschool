<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EnumTitles;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

final class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use HasUlids;
    use InteractsWithMedia;
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'user_role'
        )->withTimestamps();
    }

    //let's go create a function that return if the user has a panel or not

    public function hasPanel(string $panelId): bool
    {
        return $this->roles()->where('panel_id', $panelId)->exists();
    }
}
