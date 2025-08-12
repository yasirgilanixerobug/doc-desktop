<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderListing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'clinic_id',
        'provider_id',
        'location_id',
        'status_id',
        'google_review_url',
    ];

    protected $dates = ['deleted_at'];

    public function clinic(): HasOne
    {
        return $this->hasOne(clinic::class, 'id', 'clinic_id');
    }

    public function provider(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'provider_id');
    }

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
