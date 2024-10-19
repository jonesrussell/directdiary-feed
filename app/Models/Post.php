<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $append = [
        'user',
    ];

    protected $fillable = [
        'user_id',
        'post',
        'file',
        'is_video',
    ];

    /**
     * Retrieve the User that the Domain belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('image');
    }
}
