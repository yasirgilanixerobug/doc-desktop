<?php

namespace App\Models;

use App\Traits\WithWhereHas;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Insurance;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable, SoftDeletes, LogsActivity, WithWhereHas;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status_id',
        'clinic_id',
    ];

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}")
            ->useLogName('user')
            ->dontSubmitEmptyLogs()
            ->logOnly(['name', 'email', 'clinic_id', 'status_id']);
        // Chain fluent methods for configuration options
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return MorphOne
     */
    public function pastAppointment(): MorphOne
    {
        return $this->morphOne(Appointment::class, 'userable')
            ->whereDate('date', '<',Carbon::today())
            ->orderBy('id', 'desc');
    }

    /**
     * @return MorphOne
     */
    public function upComingAppointment(): MorphOne
    {
        return $this->morphOne(Appointment::class, 'userable')
            ->whereDate('date', '>=',Carbon::today());
    }

    /**
     * @return MorphMany
     */
    public function pastAppointments(): MorphMany
    {
        return $this->morphMany(Appointment::class, 'userable')
            ->whereDate('date', '<',Carbon::today())
            ->orderBy('id', 'desc');
    }

    /**
     * @return MorphMany
     */
    public function upComingAppointments(): MorphMany
    {
        return $this->morphMany(Appointment::class, 'userable')
            ->whereDate('date', '>=',Carbon::today());
    }

    /**
     * @return MorphMany
     */
    public function patientAppointments(): MorphMany
    {
        return $this->morphMany(Appointment::class, 'userable');
    }

    /**
     * @return string
     */
    public function getShortNameAttribute(): string
    {
        $explodeName = explode(" ",$this->name);
        $totalString = count($explodeName);
        $lastIndex = $totalString > 1 ? $totalString - 1 : 0;
        $fullName = '';

        if ($lastIndex === 0) {
            $fullName = ucwords($this->name);
        } else {
            foreach ($explodeName as $key => $value) {
                if ($lastIndex === $key) {
                    $fullName .= ' '.ucwords($value);
                } else {
                    $fullName .= ucfirst(substr($value, 0, 1));
                }
            }
        }

        return "{$fullName}";
    }

    /**
     * @param $query
     * @param null $queryParam
     * @return mixed
     */
    public function scopeFilterRecord($query, $queryParam = null)
    {
        return $query->orWhere('name', 'LIKE', "%{$queryParam}%")
            ->orWhere('email', 'LIKE', "%{$queryParam}%");
    }

    /**
     * Get the post's image.
     */
    public function appointment(): MorphOne
    {
        return $this->morphOne(Appointment::class, 'userable');
    }

    /**
     * Get the post that owns the comment.
     */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function userDetail(): HasOne
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function providerLocation(): HasMany
    {
        return $this->hasMany(ProviderLocation::class, 'provider_id', 'id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function staffLocation(): HasOne
    {
        return $this->hasOne(StaffLocation::class, 'staff_id', 'id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function staffLocations(): HasMany
    {
        return $this->hasMany(StaffLocation::class, 'staff_id', 'id');
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
    public function clinicOwner(): HasOne
    {
        return $this->hasOne(Clinic::class, 'owner_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function providerHoliday(): HasMany
    {
        return $this->hasMany(ProviderHoliday::class, 'provider_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function providerAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'provider_id', 'id');
    }

    public function insurance()
    {
        return $this->morphOne(Insurance::class, 'userable');
    }
}
