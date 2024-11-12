<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Musonza\Chat\Traits\Messageable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use InteractsWithMedia;
    use Messageable;

    protected $appends = ['avatar', 'full_name'];

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
        'biography',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'linkedin_link',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn(): string => "{$this->firstname} {$this->lastname}",
        );
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->getFirstMedia('avatar')?->getUrl()
                ?? "https://ui-avatars.com/api/?name={$this->firstname}+{$this->lastname}",
        );
    }

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
