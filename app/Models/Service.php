<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_services');
    }

    public function domains()
    {
        return $this->belongsToMany(Domain::class, 'domain_service_pivot');
    }
}
