<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    /**
     * Retrieve the User that the Domain belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
