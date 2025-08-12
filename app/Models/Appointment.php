<?php

namespace App\Models;

use App\Traits\WithWhereHas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Insurance;

class Appointment extends Model
{
    use HasFactory, LogsActivity, WithWhereHas;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}")
            ->useLogName('appointment')
            ->dontSubmitEmptyLogs()
            ->logOnly(['location.name', 'clinic_id', 'provider.name', 'userable.name', 'start_time', 'date']);
        // Chain fluent methods for configuration options
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clinic_id',
        'location_id',
        'provider_id',
        'insurance_id',
        'userable_type',
        'userable_id',
        'app_booking_channel_id',
        'appointment_status_id',
        'start_time',
        'date',
        'comment',
        'other_name',
        'insurance_id'
    ];

    /**
     * @param $query
     * @param null $queryParam
     * @return mixed
     */
    public function scopeFilter($query, $queryParam = null)
    {
        return $query->where(function ($q) use($queryParam) {
            $q->whereHas('userable', function ($query) use($queryParam) {
                if ($query->from === 'guest_users') {
                    return $query->whereRaw("concat(first_name, ' ', last_name) LIKE '%{$queryParam}%' ");
                }
            })->orWhereHas('provider', function ($query) use($queryParam) {
                return $query->where('name', 'LIKE', "%{$queryParam}%");
            })->orWhereHas('location', function ($query) use($queryParam) {
                return $query->where('name', 'LIKE', "%{$queryParam}%");
            });
        });
    }

    /**
     * Get the parent imageable model (user or post).
     */
    public function userable(): MorphTo
    {
        return $this->morphTo();
    }


    /**
     * Get the post that owns the comment.
     */
    public function clinic(): HasOne
    {
        return $this->hasOne(Clinic::class, 'id', 'clinic_id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function provider(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'provider_id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function status(): HasOne
    {
        return $this->hasOne(AppointmentStatus::class, 'id', 'appointment_status_id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function insurance(): HasOne
    {
        return $this->hasOne(Insurance::class, 'id', 'insurance_id');
    }
}
