<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderHoliday extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;


    protected $clinic_id;
    protected $appends = ['clinic_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'description',
        'provider_id',
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
}
