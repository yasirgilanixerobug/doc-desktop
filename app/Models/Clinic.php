<?php

namespace App\Models;

use App\Traits\WithWhereHas;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Clinic extends Model
{
    use Sluggable, HasFactory, LogsActivity;

    protected $clinic_id;
    protected $appends = ['clinic_id'];

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}")
            ->useLogName('clinic configuration')
            ->dontSubmitEmptyLogs()
            ->logOnly(['name', 'owner_id', 'sub_domain', 'about', 'logo', 'favicon','clinic_id']);
        // Chain fluent methods for configuration options
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'owner_id',
        'sub_domain',
        'about',
        'logo',
        'favicon'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'sub_domain' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getClinicIdAttribute()
    {
        $this->clinic_id = $this->id;
        return "{$this->clinic_id}";
    }

    /**
     * @param $query
     * @param null $queryParam
     * @return mixed
     */
    public function scopeClinicStaff($query, $queryParam = null)
    {
        return $query->orWhere('name', 'LIKE', "%{$queryParam}%")
            ->orWhere('address', 'LIKE', "%{$queryParam}%")
            ->orWhere('state', 'LIKE', "%{$queryParam}%")
            ->orWhere('city', 'LIKE', "%{$queryParam}%");
    }

    /**
     * @return string
     */
    public function getBrandLogoAttribute(): string
    {
        $placeholderImageName = config('app.logo_white');
        $image = ($this->logo) ?? $placeholderImageName;

        return "{$image}";
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
    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'clinic_id', 'id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function configuration(): HasOne
    {
        return $this->hasOne(ClinicConfiguration::class, 'clinic_id', 'id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function providers()
    {
        return $this->hasMany(User::class, 'clinic_id', 'id')
            ->with('roles')
            ->whereHas('roles', function($q) {
                $q->whereIn('id', [Role::PROVIDER]);
            });
    }

    /**
     * Get the post that owns the comment.
     */
    public function staffs()
    {
        return $this->hasMany(User::class, 'clinic_id', 'id')
            ->with('roles')
            ->whereHas('roles', function($q) {
                $q->whereIn('id', [Role::RECEPTIONIST]);
            });
    }
}
