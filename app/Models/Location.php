<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Location extends Model
{
    use HasFactory, LogsActivity;

    //protected static $recordEvents = ['created', 'updated', 'deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}")
            ->useLogName('location')
            ->dontSubmitEmptyLogs()
            ->logOnly(['name', 'clinic_id', 'per_appointment_min', 'address', 'email', 'phone', 'fax']);
        // Chain fluent methods for configuration options
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'clinic_id',
        'per_appointment_min',
        'state',
        'city',
        'address',
        'lat',
        'lng',
        'email',
        'phone',
        'fax',
        'image',
        'google_review_url',
    ];

    /**
     * @param $query
     * @param null $queryParam
     * @return mixed
     */
    public function scopeFilterRecord($query, $queryParam = null)
    {
        return $query->orWhere('name', 'LIKE', "%{$queryParam}%")
            ->orWhere('address', 'LIKE', "%{$queryParam}%")
            ->orWhere('state', 'LIKE', "%{$queryParam}%")
            ->orWhere('city', 'LIKE', "%{$queryParam}%");
    }

    /**
     * @return string
     */
    public function getImageAttribute(): string
    {
        $placeholderImageName = config('custom.location_placeholder');
        $image = ($this->image) ?? $placeholderImageName;

        return "{$image}";
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return "{$this->address}";
    }

    /**
     * @return string
     */
    public function getPhoneAttribute($value)
    {
        $number = explode('+1', $value);
        $number = ($number[1]) ?? null;
        return "{$number}";
    }

    /**
     * @return string
     */
    public function getFaxAttribute($value)
    {
        $number = explode('+1', $value);
        $number = ($number[1]) ?? null;
        return "{$number}";
    }

    /**
     * Get the post that owns the comment.
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function locationProvider(): HasMany
    {
        return $this->hasMany(ProviderLocation::class, 'location_id', 'id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function businessHour(): HasMany
    {
        return $this->hasMany(LocationBusinessHour::class, 'location_id', 'id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function locationStaff(): HasMany
    {
        return $this->hasMany(StaffLocation::class, 'location_id', 'id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'location_id', 'id');
    }

    /**
     * Get the provider listings associated with the location.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function providerListings(): HasMany
    {
        return $this->hasMany(ProviderListing::class, 'location_id', 'id');
    }
}
