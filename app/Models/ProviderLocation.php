<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProviderLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'provider_id',
        'location_id',
        'status_id',
    ];

    /**
     * @return HasOne
     */
    public function provider(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'provider_id');
    }

    /**
     * @return HasOne
     */
    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    /**
     * @return HasMany
     */
    public function providerLocationAvailability(): HasMany
    {
        return $this->hasMany(ProviderLocationAvailability::class, 'provider_location_id', 'id');
    }
}
