<?php

namespace App\Models;

use App\Enums\DomainApproval;
use App\Enums\DomainStatus;
use App\Models\Negotiation\PriceRequest;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Musonza\Chat\Traits\Messageable;

/**
 * @method static new()
 * @method static withoutGlobalScopes()
 * @method static find($id)
 * @method static approved()
 * @method static create(mixed $domain)
 * @method static paginate()
 * @property mixed|string $name
 * @property mixed|string $extension
 * @property int|mixed|null $user_id
 * @property int|mixed $price
 * @property mixed $approval
 * @property mixed $id
 */
class Domain extends Model
{
    use HasFactory;
    use Messageable;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'extension',
        'price',
        'user_id',
    ];

    protected $guarded = [
        'approval',
    ];

    protected $casts = [
        'name' => 'string',
        'extension' => 'string',
        'price' => 'integer',
        'user_id' => 'integer',
        'approval' => DomainApproval::class,
        'status' => DomainStatus::class,
    ];

    /**
     * Retrieve the User that the Domain belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function domainName(): string
    {
        return "{$this->name}.{$this->extension}";
    }

    /**
     * Scope a query to only include approved domains.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeApproved($query): mixed
    {
        return $query->where('approval', '=', DomainApproval::Approved->value);
    }

    /**
     * Scope a query to only include new domains.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNew(Builder $query): Builder
    {
        return $query->where('approval', '=', DomainApproval::New->value);
    }

    public function scopeNewApproved($query): Builder
    {
        return $query->where('approval', '=', DomainApproval::New->value)->orWhere(
            'approval',
            '=',
            DomainApproval::Approved->value
        );
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'ext' => $this->extension,
            'price' => $this->price,
            'approval' => $this->approval,
        ];
    }

    public static function getSearchFilterAttributes(): array
    {
        return [
            'price',
            'ext',
        ];
    }

    public function priceRequests(): HasMany
    {
        return $this->hasMany(PriceRequest::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'domain_service_pivot');
    }
}
